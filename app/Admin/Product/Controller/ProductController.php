<?php

namespace App\Admin\Product\Controller;

use App\Admin\Product\DTO\ProductDTO;
use App\Admin\Product\Repository\CategoryRepository;
use App\Admin\Product\Request\StoreProductRequest;
use App\Admin\Product\Request\UpdateProductRequest;
use App\Admin\Product\Service\ProductServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService,
        protected CategoryRepository $categoryRepo
    ) {
    }

    public function index(): View
    {
        $products = $this->productService->getPaginated(15);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = $this->categoryRepo->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $dto = ProductDTO::fromRequest($request);
        $this->productService->createProduct($dto);

        return redirect()->route('admin.products.index')
            ->with('success', 'Buket bunga berhasil ditambahkan ke katalog!');
    }

    public function edit(int $id): View
    {
        $product = $this->productService->getById($id);
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        $categories = $this->categoryRepo->getAllCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $dto = ProductDTO::fromRequest($request);
        $this->productService->updateProduct($id, $dto);

        return redirect()->route('admin.products.index')
            ->with('success', 'Informasi buket bunga berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->productService->deleteById($id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Buket bunga berhasil dihapus dari katalog.');
    }
}
