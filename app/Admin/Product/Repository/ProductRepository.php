<?php

namespace App\Admin\Product\Repository;

use App\Admin\Product\Model\Product;
use App\Core\Repository\BaseRepository;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getBestsellers(int $limit = 6): Collection
    {
        return $this->newQuery()
            ->with(['category', 'images', 'primaryImage'])
            ->where('is_available', true)
            ->where('is_bestseller', true)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->newQuery()
            ->with(['category', 'images', 'primaryImage'])
            ->where('slug', $slug)
            ->first();
    }

    public function filter(
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $search = null,
        ?bool $availableOnly = null,
        int $perPage = 12
    ): LengthAwarePaginator {
        $query = $this->newQuery()->with(['category', 'images', 'primaryImage']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('flower_composition', 'like', "%{$search}%");
            });
        }

        if ($availableOnly !== null) {
            $query->where('is_available', $availableOnly);
        }

        return $query->latest()->paginate($perPage);
    }

    public function addImages(int $productId, array $paths, int $primaryIndex = 0): void
    {
        foreach ($paths as $index => $path) {
            ProductImage::create([
                'product_id' => $productId,
                'image_path' => $path,
                'is_primary' => ($index === $primaryIndex),
            ]);
        }
    }

    public function setPrimaryImage(int $productId, int $imageId): void
    {
        ProductImage::where('product_id', $productId)->update(['is_primary' => false]);
        ProductImage::where('id', $imageId)->where('product_id', $productId)->update(['is_primary' => true]);
    }
}
