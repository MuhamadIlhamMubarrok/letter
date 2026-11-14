<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Actions;

use App\Domains\DigitalStory\Models\DigitalStory;
use DomainException;
use Illuminate\Support\Facades\DB;

class SaveGuestListAction
{
    /**
     * Parse and persist personal guest list and WhatsApp template into story metadata.
     *
     * @param DigitalStory $story
     * @param string $rawGuestNames
     * @param string|null $waTemplate
     * @return array{story: DigitalStory, guests: array<int, string>, count: int}
     *
     * @throws DomainException
     */
    public function execute(DigitalStory $story, string $rawGuestNames, ?string $waTemplate = null): array
    {
        return DB::transaction(function () use ($story, $rawGuestNames, $waTemplate): array {
            $lines = preg_split('/\r\n|\r|\n/', $rawGuestNames);
            $guests = array_values(array_filter(array_map('trim', $lines ?: []), fn ($line) => $line !== ''));

            $metadata = is_array($story->metadata) ? $story->metadata : [];
            $metadata['guest_list'] = $guests;

            if ($waTemplate !== null && trim($waTemplate) !== '') {
                $metadata['wa_template'] = trim($waTemplate);
            }

            $story->metadata = $metadata;
            $story->save();

            return [
                'story' => $story,
                'guests' => $guests,
                'count' => count($guests),
            ];
        });
    }
}
