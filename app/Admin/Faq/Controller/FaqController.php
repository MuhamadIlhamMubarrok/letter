<?php

namespace App\Admin\Faq\Controller;

use App\Admin\Faq\Request\FaqRequest;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs.
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15);
        $categories = Faq::select('category')->distinct()->pluck('category');

        return view('admin.faqs.index', compact('faqs', 'categories'));
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create()
    {
        $categories = Faq::select('category')->distinct()->pluck('category');
        return view('admin.faqs.create', compact('categories'));
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? (Faq::max('sort_order') + 1);

        Faq::create($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'Pertanyaan FAQ baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit(Faq $faq)
    {
        $categories = Faq::select('category')->distinct()->pluck('category');
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        $faq->update($data);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'Pertanyaan FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'Pertanyaan FAQ berhasil dihapus.');
    }

    /**
     * Toggle the active status of the FAQ.
     */
    public function toggle(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);

        return redirect()->back()
            ->with('success', 'Status tayang FAQ berhasil diubah.');
    }
}
