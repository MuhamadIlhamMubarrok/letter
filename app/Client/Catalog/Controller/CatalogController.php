<?php

namespace App\Client\Catalog\Controller;

use App\Admin\Product\Repository\CategoryRepository;
use App\Admin\Product\Service\ProductServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService,
        protected CategoryRepository $categoryRepo
    ) {
    }

    public function index(Request $request): View|JsonResponse
    {
        $categoryParam = $request->query('category');
        $categoryId = null;
        $activeCategory = null;

        if ($categoryParam) {
            if (is_numeric($categoryParam)) {
                $activeCategory = \App\Models\Category::find((int) $categoryParam);
            } else {
                $activeCategory = \App\Models\Category::where('slug', $categoryParam)->first();
            }
            if ($activeCategory) {
                $categoryId = $activeCategory->id;
            }
        }

        $minPrice = $request->filled('min_price') ? (float) $request->query('min_price') : null;
        $maxPrice = $request->filled('max_price') ? (float) $request->query('max_price') : null;
        $search = $request->query('q');
        $availableOnly = $request->has('available') ? $request->boolean('available') : null;

        $products = $this->productService->filterProducts(
            categoryId: $categoryId,
            minPrice: $minPrice,
            maxPrice: $maxPrice,
            search: $search,
            availableOnly: $availableOnly,
            perPage: 12
        );

        $categories = $this->categoryRepo->getAllCategories();

        if ($request->wantsJson()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ],
            ]);
        }

        return view('client.catalog.index', compact(
            'products',
            'categories',
            'categoryId',
            'activeCategory',
            'minPrice',
            'maxPrice',
            'search',
            'availableOnly'
        ));
    }

    public function show(string $slug): View|\Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->getBySlug($slug);
        if (!$product) {
            // Check if slug matches a Series/Category (e.g. user entered /katalog/teddy-series)
            $cat = \App\Models\Category::where('slug', $slug)->first();
            if ($cat) {
                return redirect()->route('catalog.index', ['category' => $cat->slug]);
            }
            abort(404, 'Buket bunga tidak ditemukan.');
        }

        $product->load(['category', 'images', 'primaryImage']);
        $relatedProducts = $this->productService->getBestsellers(4);

        return view('client.catalog.show', compact('product', 'relatedProducts'));
    }

    public function category(string $slug): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('catalog.index', ['category' => $slug]);
    }
}
