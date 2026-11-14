<?php

namespace App\Admin\Product\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'flower_composition' => ['nullable', 'string', 'max:1000'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'is_bestseller' => ['nullable', 'boolean'],
            'is_available' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'primary_image_index' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
