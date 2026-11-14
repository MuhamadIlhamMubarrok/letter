<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteStoryAction
{
    /**
     * Delete a story and cleanup associated media files safely in a database transaction.
     */
    public function execute(DigitalStory $story): bool
    {
        return DB::transaction(function () use ($story) {
            // 1. Delete associated media files from storage
            $story->load('media');
            foreach ($story->media as $media) {
                if ($media->file_path && ! str_starts_with($media->file_path, 'http') && Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }

            // 2. Delete QR Code file from storage if present
            if ($story->qr_code_path && Storage::disk('public')->exists($story->qr_code_path)) {
                Storage::disk('public')->delete($story->qr_code_path);
            }

            // 3. Delete uploaded audio file from storage if local
            if ($story->audio_path && ! str_starts_with($story->audio_path, 'http') && Storage::disk('public')->exists($story->audio_path)) {
                Storage::disk('public')->delete($story->audio_path);
            }

            // 4. Delete related RSVPs
            $story->rsvps()->delete();

            // 5. Delete story record (or soft delete)
            return (bool) $story->delete();
        });
    }
}
