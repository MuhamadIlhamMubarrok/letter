<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitStoryRsvpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public RSVP guestbook
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'guest_name' => ['required', 'string', 'max:100'],
            'attendance_status' => ['required', 'in:attending,not_attending,tentative'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:10'],
            'wishes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
