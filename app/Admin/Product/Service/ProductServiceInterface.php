<?php

namespace App\Admin\Product\Service;

use App\Admin\Product\DTO\ProductDTO;
use App\Admin\Product\Model\Product;
use App\Core\Service\BaseCrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface extends BaseCrudServiceInterface
{
    public function createProduct(ProductDTO $dto): Product;

    public function updateProduct(int $id, ProductDTO $dto): bool;

    public function getBestsellers(int $limit = 6): Collection;

    public function getBySlug(string $slug): ?Product;

    public function filterProducts(
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $search = null,
        ?bool $availableOnly = null,
        int $perPage = 12
    ): LengthAwarePaginator;
}
