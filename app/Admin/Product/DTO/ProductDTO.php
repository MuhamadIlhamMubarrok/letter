<?php

namespace App\Admin\Product\DTO;

use App\Core\DTO\BaseDTO;
use Illuminate\Http\Request;

class ProductDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public int $category_id,
        public string $description,
        public float $price,
        public ?string $flower_composition = null,
        public ?string $dimensions = '45 x 30 cm',
        public bool $is_bestseller = false,
        public bool $is_available = true,
        public array $images = [],
        public ?int $primary_image_index = 0,
        public ?string $slug = null,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            category_id: (int) $request->validated('category_id'),
            description: $request->validated('description'),
            price: (float) $request->validated('price'),
            flower_composition: $request->validated('flower_composition'),
            dimensions: $request->validated('dimensions', '45 x 30 cm'),
            is_bestseller: $request->boolean('is_bestseller', false),
            is_available: $request->boolean('is_available', true),
            images: $request->file('images', []) ?? [],
            primary_image_index: $request->filled('primary_image_index') ? (int) $request->input('primary_image_index') : 0,
        );
    }
}
