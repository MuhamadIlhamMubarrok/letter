<?php

namespace App\Admin\Product\Repository;

use App\Admin\Product\Model\Product;
use App\Core\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getBestsellers(int $limit = 6): Collection;

    public function findBySlug(string $slug): ?Product;

    public function filter(
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $search = null,
        ?bool $availableOnly = null,
        int $perPage = 12
    ): LengthAwarePaginator;

    public function addImages(int $productId, array $paths, int $primaryIndex = 0): void;

    public function setPrimaryImage(int $productId, int $imageId): void;
}
