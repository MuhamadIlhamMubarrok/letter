<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use App\Domains\DigitalStory\Enums\StoryFulfillmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateFulfillmentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'fulfillment_status' => ['required', new Enum(StoryFulfillmentStatus::class)],
        ];
    }
}
