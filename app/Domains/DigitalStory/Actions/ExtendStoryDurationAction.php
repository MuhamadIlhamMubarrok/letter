<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use App\Domains\DigitalStory\Enums\StoryStatus;
use App\Domains\DigitalStory\Models\DigitalStory;
use Carbon\Carbon;
use DomainException;
use Illuminate\Support\Facades\DB;

class ExtendStoryDurationAction
{
    /**
     * Extend story duration plan and re-activate story if expired.
     *
     * @param DigitalStory $story
     * @param StoryDurationPlan $newPlan
     * @return DigitalStory
     *
     * @throws DomainException
     */
    public function execute(DigitalStory $story, StoryDurationPlan $newPlan): DigitalStory
    {
        return DB::transaction(function () use ($story, $newPlan): DigitalStory {
            $baseDate = Carbon::now();

            // If story is currently active and not yet expired, extend from current expiry date
            if (! $story->is_expired && $story->expired_at !== null && $story->expired_at->isFuture()) {
                $baseDate = $story->expired_at;
            }

            $newExpiry = $newPlan->calculateExpiry($baseDate);

            $story->duration_plan = $newPlan;
            $story->expired_at = $newExpiry;
            $story->status = StoryStatus::ACTIVE;
            $story->save();

            return $story;
        });
    }
}
