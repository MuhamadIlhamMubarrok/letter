<?php

namespace App\Admin\Philosophy\Controller;

use App\Admin\Philosophy\Request\FlowerPhilosophyRequest;
use App\Http\Controllers\Controller;
use App\Models\FlowerPhilosophy;
use Illuminate\Http\Request;

class FlowerPhilosophyController extends Controller
{
    /**
     * Display a listing of Flower Philosophies.
     */
    public function index(Request $request)
    {
        $query = FlowerPhilosophy::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('flower_name', 'like', "%{$search}%")
                  ->orWhere('meaning', 'like', "%{$search}%")
                  ->orWhere('scientific_name', 'like', "%{$search}%");
            });
        }

        $philosophies = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15);

        return view('admin.philosophies.index', compact('philosophies'));
    }

    /**
     * Show the form for creating a new Flower Philosophy.
     */
    public function create()
    {
        return view('admin.philosophies.create');
    }

    /**
     * Store a newly created Flower Philosophy in storage.
     */
    public function store(FlowerPhilosophyRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? (FlowerPhilosophy::max('sort_order') + 1);

        FlowerPhilosophy::create($data);

        return redirect()->route('admin.philosophies.index')
            ->with('success', 'Filosofi bunga baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified Flower Philosophy.
     */
    public function edit(FlowerPhilosophy $philosophy)
    {
        return view('admin.philosophies.edit', compact('philosophy'));
    }

    /**
     * Update the specified Flower Philosophy in storage.
     */
    public function update(FlowerPhilosophyRequest $request, FlowerPhilosophy $philosophy)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        $philosophy->update($data);

        return redirect()->route('admin.philosophies.index')
            ->with('success', 'Filosofi bunga berhasil diperbarui.');
    }

    /**
     * Remove the specified Flower Philosophy from storage.
     */
    public function destroy(FlowerPhilosophy $philosophy)
    {
        $philosophy->delete();

        return redirect()->route('admin.philosophies.index')
            ->with('success', 'Filosofi bunga berhasil dihapus.');
    }

    /**
     * Toggle the active status of the Flower Philosophy.
     */
    public function toggle(FlowerPhilosophy $philosophy)
    {
        $philosophy->update(['is_active' => !$philosophy->is_active]);

        return redirect()->back()
            ->with('success', 'Status tayang filosofi bunga berhasil diubah.');
    }
}
