<x-layouts.admin title="Edit Kategori Buket" header="Edit Kategori / Series Buket">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-mono text-primary hover:underline flex items-center gap-1">
            <span>← Kembali ke Daftar Kategori</span>
        </a>
    </div>

    <div
        x-data="{
            name: '{{ old('name', addslashes($category->name)) }}',
            slug: '{{ old('slug', $category->slug) }}'
        }"
        class="max-w-2xl bg-surface rounded-3xl border border-primary/10 shadow-xs p-6 sm:p-8"
    >
        <div class="flex items-center justify-between mb-1">
            <h3 class="font-heading text-lg font-bold text-dark">Perbarui Kategori: {{ $category->name }}</h3>
            <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-cream text-primary border border-primary/20">
                {{ $category->products_count }} Produk Terkait
            </span>
        </div>
        <p class="text-xs text-dark/60 mb-6">Ubah nama, slug URL, atau deskripsi tema series buket ini.</p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div>
                <label for="name" class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                    Nama Kategori / Series <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    x-model="name"
                    required
                    class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                >
            </div>

            <!-- Slug URL -->
            <div>
                <label for="slug" class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                    Slug URL
                </label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    x-model="slug"
                    required
                    class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs font-mono focus:outline-none focus:border-primary"
                >
                <span class="text-[10px] text-dark/40 block mt-1 font-mono">Digunakan pada tautan URL: /katalog/series/{slug}</span>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                    Deskripsi Singkat (Opsional)
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-4 py-3 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body resize-y"
                >{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex items-center gap-3">
                <x-ui.button type="submit" variant="primary" size="lg" class="flex-1 shadow-md">
                    <span>Perbarui Kategori</span>
                    <span class="ml-2">✓</span>
                </x-ui.button>

                <a href="{{ route('admin.categories.index') }}" class="px-5 py-3 rounded-full bg-cream hover:bg-cream-dark text-dark border border-dark/15 font-mono text-xs font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.admin>
