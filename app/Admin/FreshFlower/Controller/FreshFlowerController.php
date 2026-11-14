<?php

namespace App\Admin\FreshFlower\Controller;

use App\Admin\FreshFlower\Request\FreshFlowerRequest;
use App\Core\Services\ImageOptimizer;
use App\Http\Controllers\Controller;
use App\Models\FreshFlower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FreshFlowerController extends Controller
{
    public function __construct(
        protected ImageOptimizer $imageOptimizer = new ImageOptimizer()
    ) {
    }
    public function index(Request $request): View
    {
        $query = FreshFlower::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('botanical_name', 'like', "%{$search}%")
                    ->orWhere('origin', 'like', "%{$search}%")
                    ->orWhere('color_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $flowers = $query->orderBy('sort_order', 'asc')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total_varieties' => FreshFlower::count(),
            'ready_today' => FreshFlower::where('status', 'ready')->count(),
            'limited_stock' => FreshFlower::where('status', 'limited')->count(),
            'total_stems' => FreshFlower::where('is_active', true)->sum('stock_stems'),
        ];

        return view('admin.fresh_flowers.index', compact('flowers', 'stats'));
    }

    public function create(): View
    {
        $nextOrder = (FreshFlower::max('sort_order') ?? 0) + 1;
        return view('admin.fresh_flowers.create', compact('nextOrder'));
    }

    public function store(FreshFlowerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageOptimizer->optimizeAndStore(
                file: $request->file('image'),
                directory: 'fresh-flowers',
                maxKb: 100,
            );
        }

        FreshFlower::create($data);

        return redirect()->route('admin.fresh-flowers.index')
            ->with('success', 'Stok bunga segar berhasil ditambahkan ke inventaris studio!');
    }

    public function edit(int $id): View
    {
        $flower = FreshFlower::findOrFail($id);
        return view('admin.fresh_flowers.edit', compact('flower'));
    }

    public function update(FreshFlowerRequest $request, int $id): RedirectResponse
    {
        $flower = FreshFlower::findOrFail($id);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($flower->image_path && Storage::disk('public')->exists($flower->image_path)) {
                Storage::disk('public')->delete($flower->image_path);
            }
            $data['image_path'] = $this->imageOptimizer->optimizeAndStore(
                file: $request->file('image'),
                directory: 'fresh-flowers',
                maxKb: 100,
            );
        }

        $flower->update($data);

        return redirect()->route('admin.fresh-flowers.index')
            ->with('success', "Spesimen bunga segar '{$flower->name}' berhasil diperbarui!");
    }

    public function destroy(int $id): RedirectResponse
    {
        $flower = FreshFlower::findOrFail($id);

        if ($flower->image_path && Storage::disk('public')->exists($flower->image_path)) {
            Storage::disk('public')->delete($flower->image_path);
        }

        $flower->delete();

        return redirect()->route('admin.fresh-flowers.index')
            ->with('success', 'Bunga segar berhasil dihapus dari inventaris.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $flower = FreshFlower::findOrFail($id);
        $flower->is_active = !$flower->is_active;
        $flower->save();

        $statusText = $flower->is_active ? 'ditampilkan di beranda' : 'disembunyikan dari beranda';
        return back()->with('success', "Bunga '{$flower->name}' berhasil {$statusText}.");
    }

    public function quickUpdate(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'stock_stems' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:ready,limited,sold_out'],
        ]);

        $flower = FreshFlower::findOrFail($id);
        $flower->update([
            'stock_stems' => $request->integer('stock_stems'),
            'status' => $request->input('status'),
        ]);

        return back()->with('success', "Stok harian '{$flower->name}' berhasil diubah (Stok: {$flower->stock_stems} tangkai, Status: {$flower->status_label}).");
    }
}
