<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Domains\DigitalStory\Enums\StoryType;
use App\Domains\DigitalStory\Models\DigitalStory;
use App\Domains\DigitalStory\Models\StoryRsvp;
use DomainException;
use Illuminate\Support\Facades\DB;

class SubmitStoryRsvpAction
{
    /**
     * Validate and persist RSVP entry for a wedding invitation within a transaction.
     *
     * @param DigitalStory $story
     * @param array<string, mixed> $payload
     * @param string|null $ipAddress
     * @return StoryRsvp
     *
     * @throws DomainException
     */
    public function execute(DigitalStory $story, array $payload, ?string $ipAddress = null): StoryRsvp
    {
        if ($story->is_expired) {
            throw new DomainException('Masa aktif undangan ini telah berakhir.');
        }

        if ($story->story_type !== StoryType::WEDDING_INVITATION) {
            throw new DomainException('Cerita ini bukan undangan pernikahan.');
        }

        return DB::transaction(function () use ($story, $payload, $ipAddress): StoryRsvp {
            $rsvp = new StoryRsvp();
            $rsvp->digital_story_id = $story->id;
            $rsvp->guest_name = trim((string) $payload['guest_name']);
            $rsvp->attendance_status = (string) $payload['attendance_status'];
            $rsvp->guest_count = (int) $payload['guest_count'];
            $rsvp->wishes = isset($payload['wishes']) && trim((string) $payload['wishes']) !== '' ? trim((string) $payload['wishes']) : null;
            $rsvp->ip_address = $ipAddress;
            $rsvp->save();

            return $rsvp;
        });
    }
}
