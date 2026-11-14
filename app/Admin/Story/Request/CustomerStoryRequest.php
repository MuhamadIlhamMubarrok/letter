<?php

namespace App\Admin\Story\Request;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'event_title' => ['required', 'string', 'max:100'],
            'story' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'is_published' => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'event_title.required' => 'Momen atau nama acara wajib diisi (contoh: Wisuda UI, Anniversary 3rd).',
            'story.required' => 'Isi cerita atau testimoni pelanggan wajib diisi.',
            'rating.required' => 'Rating bintang wajib dipilih (1-5).',
            'image.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'image.max' => 'Ukuran foto maksimal adalah 10MB.',
        ];
    }
}
