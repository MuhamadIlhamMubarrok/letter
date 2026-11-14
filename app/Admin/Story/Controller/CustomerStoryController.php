<?php

namespace App\Admin\Story\Controller;

use App\Admin\Story\Request\CustomerStoryRequest;
use App\Core\Services\ImageOptimizer;
use App\Http\Controllers\Controller;
use App\Models\CustomerStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerStoryController extends Controller
{
    public function __construct(
        protected ImageOptimizer $imageOptimizer = new ImageOptimizer()
    ) {
    }
    public function index(Request $request): View
    {
        $query = CustomerStory::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('event_title', 'like', "%{$search}%")
                    ->orWhere('story', 'like', "%{$search}%");
            });
        }

        $stories = $query->orderBy('sort_order', 'asc')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => CustomerStory::count(),
            'published' => CustomerStory::where('is_published', true)->count(),
            'draft' => CustomerStory::where('is_published', false)->count(),
        ];

        return view('admin.stories.index', compact('stories', 'stats'));
    }

    public function create(): View
    {
        $nextOrder = (CustomerStory::max('sort_order') ?? 0) + 1;
        return view('admin.stories.create', compact('nextOrder'));
    }

    public function store(CustomerStoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageOptimizer->optimizeAndStore(
                file: $request->file('image'),
                directory: 'stories',
                maxKb: 100,
            );
        }

        CustomerStory::create($data);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Cerita & testimoni pelanggan berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $story = CustomerStory::findOrFail($id);
        return view('admin.stories.edit', compact('story'));
    }

    public function update(CustomerStoryRequest $request, int $id): RedirectResponse
    {
        $story = CustomerStory::findOrFail($id);

        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            // Delete old uploaded image if it was stored in public storage
            if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                Storage::disk('public')->delete($story->image_path);
            }
            $data['image_path'] = $this->imageOptimizer->optimizeAndStore(
                file: $request->file('image'),
                directory: 'stories',
                maxKb: 100,
            );
        }

        $story->update($data);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Cerita pelanggan berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $story = CustomerStory::findOrFail($id);

        if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
            Storage::disk('public')->delete($story->image_path);
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'Cerita pelanggan berhasil dihapus.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $story = CustomerStory::findOrFail($id);
        $story->is_published = !$story->is_published;
        $story->save();

        $statusText = $story->is_published ? 'ditampilkan di website' : 'disembunyikan (draf)';
        return back()->with('success', "Status cerita pelanggan berhasil diubah menjadi: {$statusText}.");
    }
}
