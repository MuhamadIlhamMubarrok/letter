<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Core\Services\ImageOptimizer;
use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Enums\StoryTemplateKey;
use App\Domains\DigitalStory\Enums\StoryTemplateTheme;
use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryMedia;
use App\Domains\DigitalStory\Templates\StoryTemplateRegistry;
use Carbon\Carbon;
use DomainException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateStoryAction
{
    public function __construct(
        private readonly GenerateStoryQrCodeAction $generateQrCodeAction,
        private readonly ImageOptimizer $imageOptimizer = new ImageOptimizer(),
    ) {
    }

    /**
     * Create a new Digital Story / Wedding Invitation inside a single DB transaction.
     *
     * @param array<string, mixed> $payload
     * @param array<int, UploadedFile> $photos
     * @param UploadedFile|null $audioFile
     * @return DigitalStory
     *
     * @throws DomainException
     */
    public function execute(
        array $payload,
        array $photos = [],
        ?UploadedFile $audioFile = null,
    ): DigitalStory {
        return DB::transaction(function () use ($payload, $photos, $audioFile): DigitalStory {
            $storyType = $payload['story_type'] instanceof StoryType
                ? $payload['story_type']
                : StoryType::from((string) $payload['story_type']);

            $durationPlan = $payload['duration_plan'] instanceof StoryDurationPlan
                ? $payload['duration_plan']
                : StoryDurationPlan::from((string) $payload['duration_plan']);

            $theme = isset($payload['theme'])
                ? ($payload['theme'] instanceof StoryTemplateTheme ? $payload['theme'] : StoryTemplateTheme::from((string) $payload['theme']))
                : StoryTemplateTheme::ROMANTIC_ROSE;

            // Generate high-entropy, unique slug
            $baseTitle = ! empty($payload['title']) ? (string) $payload['title'] : 'story';
            $slugPrefix = Str::limit(Str::slug($baseTitle), 35, '');
            if (empty($slugPrefix)) {
                $slugPrefix = 'story';
            }
            $slug = $slugPrefix . '-' . strtolower(Str::random(6));

            while (DigitalStory::where('slug', $slug)->exists()) {
                $slug = $slugPrefix . '-' . strtolower(Str::random(8));
            }

            // Calculate expiration date
            $expiredAt = $durationPlan->calculateExpiry(Carbon::now());

            // Handle Audio file upload if provided
            $audioPath = null;
            if ($audioFile instanceof UploadedFile) {
                if (! $audioFile->isValid()) {
                    throw new DomainException('File audio yang diunggah tidak valid atau rusak.');
                }
                $audioFilename = 'audio_' . Str::uuid()->toString() . '.' . $audioFile->getClientOriginalExtension();
                $audioPath = $audioFile->storeAs('stories/audio', $audioFilename, 'public');
            } elseif (! empty($payload['audio_url'])) {
                $audioPath = (string) $payload['audio_url'];
            }

            // Structure metadata for wedding details if applicable
            $metadata = [];
            if ($storyType === StoryType::WEDDING_INVITATION) {
                $metadata = [
                    'venue_name' => $payload['wedding_venue_name'] ?? null,
                    'venue_address' => $payload['wedding_venue_address'] ?? null,
                    'maps_url' => $payload['wedding_maps_url'] ?? null,
                    'ceremony_time' => $payload['wedding_ceremony_time'] ?? null,
                    'reception_time' => $payload['wedding_reception_time'] ?? null,
                ];
            }

            // Audio trimming cut settings
            if (isset($payload['audio_start_sec']) && $payload['audio_start_sec'] !== '') {
                $metadata['audio_start_sec'] = (float) $payload['audio_start_sec'];
            }
            if (isset($payload['audio_end_sec']) && $payload['audio_end_sec'] !== '') {
                $metadata['audio_end_sec'] = (float) $payload['audio_end_sec'];
            }

            $templateRegistry = app(StoryTemplateRegistry::class);
            $templateKey = ! empty($payload['template_key'])
                ? ($payload['template_key'] instanceof StoryTemplateKey ? $payload['template_key'] : StoryTemplateKey::tryFrom((string) $payload['template_key']))
                : null;
            if (! $templateKey) {
                $templateKey = $templateRegistry->defaultForType($storyType);
            }

            $fulfillmentStatus = ! empty($payload['fulfillment_status'])
                ? ($payload['fulfillment_status'] instanceof StoryFulfillmentStatus ? $payload['fulfillment_status'] : StoryFulfillmentStatus::tryFrom((string) $payload['fulfillment_status']))
                : StoryFulfillmentStatus::DRAFTING;
            if (! $fulfillmentStatus) {
                $fulfillmentStatus = StoryFulfillmentStatus::DRAFTING;
            }

            // Create story record
            $story = new DigitalStory();
            $story->order_code = ! empty($payload['order_code']) ? (string) $payload['order_code'] : null;
            $story->customer_phone = ! empty($payload['customer_phone']) ? (string) $payload['customer_phone'] : null;
            $story->fulfillment_status = $fulfillmentStatus;
            $story->template_key = $templateKey;
            $story->slug = $slug;
            $story->story_type = $storyType;
            $story->duration_plan = $durationPlan;
            $story->status = StoryStatus::ACTIVE;
            $story->theme = $theme;
            $story->title = (string) $payload['title'];
            $story->sender_name = (string) $payload['sender_name'];
            $story->recipient_name = (string) $payload['recipient_name'];
            $story->message = (string) $payload['message'];
            $story->event_date = ! empty($payload['event_date']) ? Carbon::parse($payload['event_date']) : null;
            $story->audio_path = $audioPath;
            $story->audio_title = ! empty($payload['audio_title']) ? (string) $payload['audio_title'] : null;
            $story->expired_at = $expiredAt;
            $story->notes = ! empty($payload['notes']) ? (string) $payload['notes'] : null;
            $story->metadata = $metadata;
            $story->views_count = 0;
            $story->save();

            // Handle multi-photos upload for Polaroid gallery (Auto converted to WebP & compressed < 100KB)
            $sortOrder = 0;
            foreach ($photos as $photo) {
                if (! $photo instanceof UploadedFile || ! $photo->isValid()) {
                    continue;
                }

                $storedPath = $this->imageOptimizer->optimizeAndStore(
                    file: $photo,
                    directory: 'stories/media',
                    customFilename: 'polaroid_' . Str::uuid()->toString(),
                    maxKb: 100,
                );

                $media = new StoryMedia();
                $media->digital_story_id = $story->id;
                $media->file_path = $storedPath;
                $media->file_name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                $media->mime_type = 'image/webp';
                $media->caption = $payload['photo_captions'][$sortOrder] ?? null;
                $media->sort_order = $sortOrder++;
                $media->save();
            }

            // Generate SVG QR Code instantly
            $qrPath = $this->generateQrCodeAction->execute($story->public_url, $story->slug);
            $story->qr_code_path = $qrPath;
            $story->save();

            return $story->load(['media', 'rsvps']);
        });
    }
}
