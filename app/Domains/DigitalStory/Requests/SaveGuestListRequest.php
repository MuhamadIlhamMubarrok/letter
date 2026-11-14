<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGuestListRequest extends FormRequest
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
            'guest_names' => ['nullable', 'string', 'max:50000'],
            'wa_template' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
