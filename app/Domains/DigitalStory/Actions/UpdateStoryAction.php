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
use Carbon\Carbon;
use DomainException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateStoryAction
{
    public function __construct(
        private readonly GenerateStoryQrCodeAction $generateQrCodeAction,
        private readonly ImageOptimizer $imageOptimizer = new ImageOptimizer(),
    ) {
    }

    /**
     * Update an existing Digital Story inside a database transaction.
     *
     * @param DigitalStory $story
     * @param array<string, mixed> $payload
     * @param array<int, UploadedFile> $newPhotos
     * @param UploadedFile|null $audioFile
     * @return DigitalStory
     *
     * @throws DomainException
     */
    public function execute(
        DigitalStory $story,
        array $payload,
        array $newPhotos = [],
        ?UploadedFile $audioFile = null,
    ): DigitalStory {
        return DB::transaction(function () use ($story, $payload, $newPhotos, $audioFile): DigitalStory {
            if (isset($payload['story_type'])) {
                $story->story_type = $payload['story_type'] instanceof StoryType
                    ? $payload['story_type']
                    : StoryType::from((string) $payload['story_type']);
            }

            if (isset($payload['theme'])) {
                $story->theme = $payload['theme'] instanceof StoryTemplateTheme
                    ? $payload['theme']
                    : StoryTemplateTheme::from((string) $payload['theme']);
            }

            if (isset($payload['status'])) {
                $story->status = $payload['status'] instanceof StoryStatus
                    ? $payload['status']
                    : StoryStatus::from((string) $payload['status']);
            }

            // Duration plan update
            if (isset($payload['duration_plan'])) {
                $newPlan = $payload['duration_plan'] instanceof StoryDurationPlan
                    ? $payload['duration_plan']
                    : StoryDurationPlan::from((string) $payload['duration_plan']);

                if ($story->duration_plan !== $newPlan) {
                    $story->duration_plan = $newPlan;
                    $story->expired_at = $newPlan->calculateExpiry(Carbon::now());
                    if ($story->status === StoryStatus::EXPIRED) {
                        $story->status = StoryStatus::ACTIVE;
                    }
                }
            }

            if (isset($payload['template_key'])) {
                $story->template_key = $payload['template_key'] instanceof StoryTemplateKey
                    ? $payload['template_key']
                    : StoryTemplateKey::from((string) $payload['template_key']);
            }

            if (isset($payload['fulfillment_status'])) {
                $story->fulfillment_status = $payload['fulfillment_status'] instanceof StoryFulfillmentStatus
                    ? $payload['fulfillment_status']
                    : StoryFulfillmentStatus::from((string) $payload['fulfillment_status']);
            }

            if (array_key_exists('order_code', $payload)) {
                $story->order_code = ! empty($payload['order_code']) ? (string) $payload['order_code'] : null;
            }

            if (array_key_exists('customer_phone', $payload)) {
                $story->customer_phone = ! empty($payload['customer_phone']) ? (string) $payload['customer_phone'] : null;
            }

            if (array_key_exists('notes', $payload)) {
                $story->notes = ! empty($payload['notes']) ? (string) $payload['notes'] : null;
            }

            $story->title = (string) ($payload['title'] ?? $story->title);
            $story->sender_name = (string) ($payload['sender_name'] ?? $story->sender_name);
            $story->recipient_name = (string) ($payload['recipient_name'] ?? $story->recipient_name);
            $story->message = (string) ($payload['message'] ?? $story->message);

            if (array_key_exists('event_date', $payload)) {
                $story->event_date = ! empty($payload['event_date']) ? Carbon::parse($payload['event_date']) : null;
            }

            if (isset($payload['audio_title'])) {
                $story->audio_title = (string) $payload['audio_title'];
            }

            // Audio Replacement
            if ($audioFile instanceof UploadedFile && $audioFile->isValid()) {
                if ($story->audio_path && Storage::disk('public')->exists($story->audio_path)) {
                    Storage::disk('public')->delete($story->audio_path);
                }
                $audioFilename = 'audio_' . Str::uuid()->toString() . '.' . $audioFile->getClientOriginalExtension();
                $story->audio_path = $audioFile->storeAs('stories/audio', $audioFilename, 'public');
            } elseif (! empty($payload['audio_url'])) {
                $story->audio_path = (string) $payload['audio_url'];
            }

            // Metadata update
            $metadata = is_array($story->metadata) ? $story->metadata : [];
            if ($story->story_type === StoryType::WEDDING_INVITATION) {
                $metadata['venue_name'] = $payload['wedding_venue_name'] ?? ($metadata['venue_name'] ?? null);
                $metadata['venue_address'] = $payload['wedding_venue_address'] ?? ($metadata['venue_address'] ?? null);
                $metadata['maps_url'] = $payload['wedding_maps_url'] ?? ($metadata['maps_url'] ?? null);
                $metadata['ceremony_time'] = $payload['wedding_ceremony_time'] ?? ($metadata['ceremony_time'] ?? null);
                $metadata['reception_time'] = $payload['wedding_reception_time'] ?? ($metadata['reception_time'] ?? null);
            }

            if (array_key_exists('audio_start_sec', $payload)) {
                $metadata['audio_start_sec'] = ($payload['audio_start_sec'] !== null && $payload['audio_start_sec'] !== '') ? (float) $payload['audio_start_sec'] : 0;
            }
            if (array_key_exists('audio_end_sec', $payload)) {
                $metadata['audio_end_sec'] = ($payload['audio_end_sec'] !== null && $payload['audio_end_sec'] !== '') ? (float) $payload['audio_end_sec'] : null;
            }
            $story->metadata = $metadata;

            // Remove selected photos
            if (! empty($payload['delete_photos']) && is_array($payload['delete_photos'])) {
                $mediaToDelete = StoryMedia::where('digital_story_id', $story->id)
                    ->whereIn('id', $payload['delete_photos'])
                    ->get();

                foreach ($mediaToDelete as $mediaItem) {
                    if (Storage::disk('public')->exists($mediaItem->file_path)) {
                        Storage::disk('public')->delete($mediaItem->file_path);
                    }
                    $mediaItem->delete();
                }
            }

            // Add new photos (Auto converted to WebP & compressed < 100KB)
            $currentMaxOrder = (int) $story->media()->max('sort_order');
            foreach ($newPhotos as $photo) {
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
                $media->sort_order = ++$currentMaxOrder;
                $media->save();
            }

            // Regenerate QR code if path missing
            if (empty($story->qr_code_path) || ! Storage::disk('public')->exists($story->qr_code_path)) {
                $story->qr_code_path = $this->generateQrCodeAction->execute($story->public_url, $story->slug);
            }

            $story->save();

            return $story->load(['media', 'rsvps']);
        });
    }
}
