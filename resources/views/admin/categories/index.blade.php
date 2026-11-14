<x-layouts.admin title="Kategori & Series Buket" header="Manajemen Kategori / Series Buket">
    <!-- Header Action & Overview -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs text-dark/70">
                Kelola kategori dan series buket bunga (seperti Teddy Series, Lumière Series, Bouquet Wisuda, dll.). Kategori ini terhubung langsung ke katalog, navbar, dan opsi pembuatan produk.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button href="{{ route('admin.categories.create') }}" variant="primary" size="sm" class="shadow-sm">
                <span>+ Tambah Kategori Baru</span>
            </x-ui.button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>✓</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-bold">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>⚠️</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-rose-700 hover:text-rose-950 font-bold">&times;</button>
        </div>
    @endif

    <!-- Stat Cards Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-dark/50 block">Total Kategori / Series</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-dark">{{ $stats['total'] }}</span>
                <span class="text-xs text-dark/60 font-mono">Series Aktif</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-dark/50 block">Total Produk Terdistribusi</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-primary">{{ $stats['total_products'] }}</span>
                <span class="text-xs text-dark/60 font-mono">Buket Terdaftar</span>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs p-4 mb-6">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama kategori, series, atau slug..."
                    class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                >
            </div>

            <button
                type="submit"
                class="px-5 py-2.5 rounded-2xl bg-primary text-cream hover:bg-primary-dark text-xs font-mono font-semibold transition"
            >
                Cari
            </button>

            @if(request()->filled('search'))
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="px-4 py-2.5 rounded-2xl bg-cream text-dark/70 hover:text-dark text-xs font-mono border border-dark/15 transition"
                >
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table of Categories -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead class="bg-cream-light/60 font-mono text-[11px] uppercase tracking-wider text-dark/60 border-b border-dark/10">
                    <tr>
                        <th class="py-3 px-5">Nama Kategori / Series</th>
                        <th class="py-3 px-5">Slug URL</th>
                        <th class="py-3 px-5">Deskripsi</th>
                        <th class="py-3 px-5 text-center">Jumlah Produk</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark/5">
                    @forelse ($categories as $cat)
                        <tr class="hover:bg-cream/40 transition">
                            <!-- Category Name -->
                            <td class="py-4 px-5">
                                <span class="font-heading text-sm font-bold text-dark block">{{ $cat->name }}</span>
                            </td>

                            <!-- Slug Column -->
                            <td class="py-4 px-5 font-mono text-xs">
                                <span class="px-2.5 py-1 rounded-full bg-cream-light text-primary border border-primary/20 font-mono text-[11px]">
                                    {{ $cat->slug }}
                                </span>
                                <a
                                    href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                                    target="_blank"
                                    class="ml-1 text-[10px] text-dark/40 hover:text-primary underline"
                                    title="Lihat di Katalog Publik"
                                >
                                    ↗
                                </a>
                            </td>

                            <!-- Description -->
                            <td class="py-4 px-5 text-dark/70 max-w-xs truncate">
                                {{ $cat->description ?: '-' }}
                            </td>

                            <!-- Product Count -->
                            <td class="py-4 px-5 text-center font-mono">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $cat->products_count > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $cat->products_count }} Buket
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-5 text-right space-x-1 whitespace-nowrap">
                                <a
                                    href="{{ route('admin.categories.edit', $cat->id) }}"
                                    class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-cream hover:bg-cream-dark text-dark border border-dark/15 font-mono text-[11px] transition shadow-2xs"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.categories.destroy', $cat->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-mono text-[11px] transition cursor-pointer"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-dark/40 font-mono">
                                Belum ada kategori buket. Klik tombol <strong>+ Tambah Kategori Baru</strong> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="p-4 border-t border-dark/10">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
