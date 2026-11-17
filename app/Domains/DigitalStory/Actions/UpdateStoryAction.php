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
                // Groom Photo processing
                if (isset($payload['groom_photo']) && $payload['groom_photo'] instanceof UploadedFile && $payload['groom_photo']->isValid()) {
                    $savedPath = $this->imageOptimizer->optimizeAndStore($payload['groom_photo'], 'stories/couples');
                    $metadata['groom_photo'] = 'storage/' . $savedPath;
                } elseif (! empty($payload['groom_photo_url'])) {
                    $metadata['groom_photo'] = (string) $payload['groom_photo_url'];
                }

                // Bride Photo processing
                if (isset($payload['bride_photo']) && $payload['bride_photo'] instanceof UploadedFile && $payload['bride_photo']->isValid()) {
                    $savedPath = $this->imageOptimizer->optimizeAndStore($payload['bride_photo'], 'stories/couples');
                    $metadata['bride_photo'] = 'storage/' . $savedPath;
                } elseif (! empty($payload['bride_photo_url'])) {
                    $metadata['bride_photo'] = (string) $payload['bride_photo_url'];
                }

                $metadata['groom_full_name'] = $payload['groom_full_name'] ?? ($metadata['groom_full_name'] ?? null);
                $metadata['groom_nickname'] = $payload['groom_nickname'] ?? ($metadata['groom_nickname'] ?? null);
                $metadata['groom_parents'] = $payload['groom_parents'] ?? ($metadata['groom_parents'] ?? null);
                $metadata['groom_instagram'] = $payload['groom_instagram'] ?? ($metadata['groom_instagram'] ?? null);
                $metadata['groom_bio'] = $payload['groom_bio'] ?? ($metadata['groom_bio'] ?? null);

                $metadata['bride_full_name'] = $payload['bride_full_name'] ?? ($metadata['bride_full_name'] ?? null);
                $metadata['bride_nickname'] = $payload['bride_nickname'] ?? ($metadata['bride_nickname'] ?? null);
                $metadata['bride_parents'] = $payload['bride_parents'] ?? ($metadata['bride_parents'] ?? null);
                $metadata['bride_instagram'] = $payload['bride_instagram'] ?? ($metadata['bride_instagram'] ?? null);
                $metadata['bride_bio'] = $payload['bride_bio'] ?? ($metadata['bride_bio'] ?? null);

                $metadata['ceremony_date'] = $payload['ceremony_date'] ?? ($metadata['ceremony_date'] ?? null);
                $metadata['ceremony_time'] = $payload['wedding_ceremony_time'] ?? ($metadata['ceremony_time'] ?? null);
                $metadata['ceremony_venue'] = $payload['ceremony_venue_name'] ?? ($metadata['ceremony_venue'] ?? null);
                $metadata['ceremony_venue_address'] = $payload['ceremony_venue_address'] ?? ($metadata['ceremony_venue_address'] ?? null);
                $metadata['ceremony_maps_url'] = $payload['ceremony_maps_url'] ?? ($metadata['ceremony_maps_url'] ?? null);

                $metadata['reception_date'] = $payload['reception_date'] ?? ($metadata['reception_date'] ?? null);
                $metadata['reception_time'] = $payload['wedding_reception_time'] ?? ($metadata['reception_time'] ?? null);
                $metadata['venue_name'] = $payload['wedding_venue_name'] ?? ($metadata['venue_name'] ?? null);
                $metadata['venue_address'] = $payload['wedding_venue_address'] ?? ($metadata['venue_address'] ?? null);
                $metadata['maps_url'] = $payload['wedding_maps_url'] ?? ($metadata['maps_url'] ?? null);

                $metadata['bank_1_name'] = $payload['bank_1_name'] ?? ($metadata['bank_1_name'] ?? null);
                $metadata['bank_1_number'] = $payload['bank_1_number'] ?? ($metadata['bank_1_number'] ?? null);
                $metadata['bank_1_holder'] = $payload['bank_1_holder'] ?? ($metadata['bank_1_holder'] ?? null);
                $metadata['bank_2_name'] = $payload['bank_2_name'] ?? ($metadata['bank_2_name'] ?? null);
                $metadata['bank_2_number'] = $payload['bank_2_number'] ?? ($metadata['bank_2_number'] ?? null);
                $metadata['bank_2_holder'] = $payload['bank_2_holder'] ?? ($metadata['bank_2_holder'] ?? null);
                $metadata['gift_delivery_address'] = $payload['gift_delivery_address'] ?? ($metadata['gift_delivery_address'] ?? null);

                $metadata['holy_verse_text'] = $payload['holy_verse_text'] ?? ($metadata['holy_verse_text'] ?? null);
                $metadata['holy_verse_source'] = $payload['holy_verse_source'] ?? ($metadata['holy_verse_source'] ?? null);
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
