<?php

namespace App\Admin\Category\Controller;

use App\Admin\Category\Request\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::query()->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest('id')->paginate(10)->withQueryString();

        $stats = [
            'total' => Category::count(),
            'total_products' => \App\Models\Product::count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori / Series buket '{$data['name']}' berhasil ditambahkan!");
    }

    public function edit(int $id): View
    {
        $category = Category::withCount('products')->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return back()->with('error', "Tidak dapat menghapus kategori '{$category->name}' karena masih memiliki {$category->products_count} produk buket di dalamnya. Silakan pindahkan atau hapus produk terlebih dahulu.");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil dihapus.");
    }
}
