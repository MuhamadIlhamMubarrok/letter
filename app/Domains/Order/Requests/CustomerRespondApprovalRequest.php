<?php

declare(strict_types=1);

namespace App\Domains\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRespondApprovalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action' => ['required', 'in:APPROVE,REVISE'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
