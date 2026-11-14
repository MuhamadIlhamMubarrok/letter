<?php

namespace App\Admin\FreshFlower\Request;

use Illuminate\Foundation\Http\FormRequest;

class FreshFlowerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'botanical_name' => ['nullable', 'string', 'max:150'],
            'origin' => ['nullable', 'string', 'max:100'],
            'color_name' => ['required', 'string', 'max:100'],
            'color_hex' => ['required', 'string', 'max:20'],
            'stock_stems' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:ready,limited,sold_out'],
            'price_per_stem' => ['nullable', 'integer', 'min:0'],
            'vase_life' => ['nullable', 'string', 'max:50'],
            'aroma_note' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'is_active' => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama bunga segar wajib diisi.',
            'color_name.required' => 'Nama warna bunga wajib diisi.',
            'color_hex.required' => 'Kode warna hex wajib dipilih.',
            'stock_stems.required' => 'Jumlah stok tangkai wajib diisi.',
            'stock_stems.min' => 'Jumlah stok tangkai minimal 0.',
            'status.required' => 'Status ketersediaan stok wajib dipilih.',
            'status.in' => 'Status ketersediaan tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
        ];
    }
}
