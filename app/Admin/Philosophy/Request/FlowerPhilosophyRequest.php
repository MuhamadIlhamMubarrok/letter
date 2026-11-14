<?php

namespace App\Admin\Philosophy\Request;

use Illuminate\Foundation\Http\FormRequest;

class FlowerPhilosophyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'flower_name' => ['required', 'string', 'max:150'],
            'scientific_name' => ['nullable', 'string', 'max:150'],
            'emoji_or_icon' => ['required', 'string', 'max:50'],
            'meaning' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'flower_name.required' => 'Nama bunga wajib diisi.',
            'emoji_or_icon.required' => 'Emoji atau ikon bunga wajib diisi (contoh: 🌹, 🌸).',
            'meaning.required' => 'Makna & filosofi bunga wajib diisi.',
            'description.required' => 'Penjelasan filosofi wajib diisi.',
        ];
    }
}
