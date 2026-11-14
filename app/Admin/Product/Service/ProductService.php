<?php

namespace App\Admin\Product\Service;

use App\Admin\Product\DTO\ProductDTO;
use App\Admin\Product\Model\Product;
use App\Admin\Product\Repository\ProductRepositoryInterface;
use App\Core\Service\BaseCrudService;
use App\Core\Services\ImageOptimizer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService extends BaseCrudService implements ProductServiceInterface
{
    protected ProductRepositoryInterface $productRepo;
    protected ImageOptimizer $imageOptimizer;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ?ImageOptimizer $imageOptimizer = null
    ) {
        parent::__construct($productRepo);
        $this->productRepo = $productRepo;
        $this->imageOptimizer = $imageOptimizer ?? new ImageOptimizer();
    }

    public function createProduct(ProductDTO $dto): Product
    {
        return DB::transaction(function () use ($dto) {
            $slug = Str::slug($dto->name);
            $count = Product::where('slug', 'like', "{$slug}%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            /** @var Product $product */
            $product = $this->productRepo->create([
                'name' => $dto->name,
                'slug' => $slug,
                'category_id' => $dto->category_id,
                'description' => $dto->description,
                'price' => $dto->price,
                'flower_composition' => $dto->flower_composition,
                'dimensions' => $dto->dimensions ?? '45 x 30 cm',
                'is_bestseller' => $dto->is_bestseller,
                'is_available' => $dto->is_available,
            ]);

            if (!empty($dto->images)) {
                $paths = [];
                foreach ($dto->images as $file) {
                    $path = $this->imageOptimizer->optimizeAndStore(
                        file: $file,
                        directory: 'products',
                        maxKb: 100
                    );
                    $paths[] = $path;
                }
                $this->productRepo->addImages($product->id, $paths, $dto->primary_image_index ?? 0);
            }

            return $product;
        });
    }

    public function updateProduct(int $id, ProductDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $updated = $this->productRepo->update($id, [
                'name' => $dto->name,
                'category_id' => $dto->category_id,
                'description' => $dto->description,
                'price' => $dto->price,
                'flower_composition' => $dto->flower_composition,
                'dimensions' => $dto->dimensions ?? '45 x 30 cm',
                'is_bestseller' => $dto->is_bestseller,
                'is_available' => $dto->is_available,
            ]);

            if (!empty($dto->images)) {
                $paths = [];
                foreach ($dto->images as $file) {
                    $path = $this->imageOptimizer->optimizeAndStore(
                        file: $file,
                        directory: 'products',
                        maxKb: 100
                    );
                    $paths[] = $path;
                }
                $this->productRepo->addImages($id, $paths, $dto->primary_image_index ?? 0);
            }

            return $updated;
        });
    }

    public function getBestsellers(int $limit = 6): Collection
    {
        return $this->productRepo->getBestsellers($limit);
    }

    public function getBySlug(string $slug): ?Product
    {
        return $this->productRepo->findBySlug($slug);
    }

    public function filterProducts(
        ?int $categoryId = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $search = null,
        ?bool $availableOnly = null,
        int $perPage = 12
    ): LengthAwarePaginator {
        return $this->productRepo->filter($categoryId, $minPrice, $maxPrice, $search, $availableOnly, $perPage);
    }
}
