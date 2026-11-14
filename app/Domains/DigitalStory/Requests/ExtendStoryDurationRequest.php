<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use App\Domains\DigitalStory\Enums\StoryDurationPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExtendStoryDurationRequest extends FormRequest
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
            'duration_plan' => ['required', new Enum(StoryDurationPlan::class)],
        ];
    }
}
