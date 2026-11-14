<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use App\Domains\DigitalStory\Models\DigitalStory;
use DomainException;
use Illuminate\Support\Facades\DB;

class UpdateFulfillmentStatusAction
{
    /**
     * Update fulfillment workflow status of a digital story.
     *
     * @param DigitalStory $story
     * @param StoryFulfillmentStatus $status
     * @return DigitalStory
     *
     * @throws DomainException
     */
    public function execute(DigitalStory $story, StoryFulfillmentStatus $status): DigitalStory
    {
        return DB::transaction(function () use ($story, $status): DigitalStory {
            $story->fulfillment_status = $status;
            $story->save();

            return $story;
        });
    }
}
