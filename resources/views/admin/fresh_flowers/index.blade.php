<x-layouts.admin title="Stok Bunga Segar Florist" header="Inventaris Bunga Segar (Daily Fresh Blooms)">
    <!-- Header Action & Overview -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs text-dark/70">
                Kelola stok bunga potong segar (fresh cut) harian, kuota tangkai ready, dan status ketersediaan yang tampil di homepage.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button href="{{ route('admin.fresh-flowers.create') }}" variant="primary" size="sm" class="shadow-sm">
                <span>+ Tambah Bunga Segar</span>
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

    <!-- Stat Cards Overview -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-dark/50 block">Total Varian Bunga</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-dark">{{ $stats['total_varieties'] }}</span>
                <span class="text-xs text-dark/60 font-mono">Spesies</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-emerald-50/70 border border-emerald-200 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-emerald-800 font-semibold block">Ready Hari Ini</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-emerald-900">{{ $stats['ready_today'] }}</span>
                <span class="text-xs text-emerald-700 font-mono">Varian Siap</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-amber-50/70 border border-amber-200 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-amber-800 font-semibold block">Stok Menipis</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-amber-900">{{ $stats['limited_stock'] }}</span>
                <span class="text-xs text-amber-700 font-mono">Limited Kuota</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs">
            <span class="font-mono text-[11px] uppercase tracking-wider text-dark/50 block">Total Tangkai di Studio</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="font-mono text-2xl font-bold text-primary">{{ $stats['total_stems'] }}</span>
                <span class="text-xs text-dark/60 font-mono">Tangkai Ready</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs p-4 mb-6">
        <form method="GET" action="{{ route('admin.fresh-flowers.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[220px]">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama bunga, varietas botani, warna, asal..."
                    class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                >
            </div>

            <div class="w-44">
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                >
                    <option value="">Semua Status</option>
                    <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Ready Hari Ini</option>
                    <option value="limited" {{ request('status') === 'limited' ? 'selected' : '' }}>Sisa Sedikit</option>
                    <option value="sold_out" {{ request('status') === 'sold_out' ? 'selected' : '' }}>Habis / Restock</option>
                </select>
            </div>

            <button
                type="submit"
                class="px-5 py-2.5 rounded-2xl bg-primary text-cream hover:bg-primary-dark text-xs font-mono font-semibold transition"
            >
                Cari
            </button>

            @if(request()->filled('search') || request()->filled('status'))
                <a
                    href="{{ route('admin.fresh-flowers.index') }}"
                    class="px-4 py-2.5 rounded-2xl bg-cream text-dark/70 hover:text-dark text-xs font-mono border border-dark/15 transition"
                >
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table of Fresh Flowers -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead class="bg-cream-light/60 font-mono text-[11px] uppercase tracking-wider text-dark/60 border-b border-dark/10">
                    <tr>
                        <th class="py-3 px-5">Foto</th>
                        <th class="py-3 px-5">Nama Spesimen & Varietas</th>
                        <th class="py-3 px-4">Warna & Hex</th>
                        <th class="py-3 px-5 min-w-[240px]">Quick Update Stok & Status</th>
                        <th class="py-3 px-4">Harga / Tangkai</th>
                        <th class="py-3 px-4 text-center">Status Beranda</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark/5">
                    @forelse ($flowers as $flower)
                        <tr class="hover:bg-cream/40 transition">
                            <!-- Image Column -->
                            <td class="py-4 px-5">
                                <img
                                    src="{{ $flower->image_url }}"
                                    alt="{{ $flower->name }}"
                                    class="w-14 h-14 object-cover rounded-2xl shadow-xs border border-dark/10"
                                >
                            </td>

                            <!-- Name & Species -->
                            <td class="py-4 px-5">
                                <span class="font-heading text-sm font-bold text-dark block">{{ $flower->name }}</span>
                                @if($flower->botanical_name)
                                    <span class="italic font-serif text-[11px] text-secondary-dark block">{{ $flower->botanical_name }}</span>
                                @endif
                                <div class="flex items-center gap-2 mt-1 text-[10px] text-dark/50 font-mono">
                                    @if($flower->origin)
                                        <span>📍 {{ $flower->origin }}</span>
                                        <span>•</span>
                                    @endif
                                    @if($flower->vase_life)
                                        <span>⏳ {{ $flower->vase_life }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Color Column -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full border border-dark/20 shadow-xs shrink-0"
                                        style="background-color: {{ $flower->color_hex }}"
                                    ></span>
                                    <div>
                                        <span class="font-medium text-dark block text-[11px]">{{ $flower->color_name }}</span>
                                        <span class="font-mono text-[10px] text-dark/40 uppercase">{{ $flower->color_hex }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Quick Update Column (Inline Form) -->
                            <td class="py-4 px-5">
                                <form action="{{ route('admin.fresh-flowers.quick-update', $flower->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <div class="relative w-20">
                                        <input
                                            type="number"
                                            name="stock_stems"
                                            value="{{ $flower->stock_stems }}"
                                            min="0"
                                            class="w-full px-2.5 py-1.5 rounded-xl border border-dark/20 text-xs font-mono font-bold text-center focus:outline-none focus:border-primary"
                                            title="Jumlah tangkai ready"
                                        >
                                    </div>

                                    <select
                                        name="status"
                                        class="px-2.5 py-1.5 rounded-xl border border-dark/20 text-[11px] font-mono focus:outline-none focus:border-primary"
                                    >
                                        <option value="ready" {{ $flower->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                        <option value="limited" {{ $flower->status === 'limited' ? 'selected' : '' }}>Limited</option>
                                        <option value="sold_out" {{ $flower->status === 'sold_out' ? 'selected' : '' }}>Habis</option>
                                    </select>

                                    <button
                                        type="submit"
                                        class="p-1.5 rounded-xl bg-primary/10 hover:bg-primary text-primary hover:text-cream transition shadow-2xs font-mono text-[10px]"
                                        title="Simpan Stok Tangkai"
                                    >
                                        💾
                                    </button>
                                </form>
                                <div class="mt-1 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $flower->status_dot_class }}"></span>
                                    <span class="text-[10px] font-mono text-dark/60">{{ $flower->status_label }}</span>
                                </div>
                            </td>

                            <!-- Price Column -->
                            <td class="py-4 px-4 font-mono font-semibold text-primary">
                                {{ $flower->formatted_price }}
                            </td>

                            <!-- Visibility Toggle Column -->
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.fresh-flowers.toggle', $flower->id) }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="px-3 py-1 rounded-full text-[10px] font-mono border transition cursor-pointer {{ $flower->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}"
                                        title="Klik untuk ubah status tampil di beranda"
                                    >
                                        {{ $flower->is_active ? '● Aktif' : '○ Draf' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Action Column -->
                            <td class="py-4 px-5 text-right space-x-1 whitespace-nowrap">
                                <a
                                    href="{{ route('admin.fresh-flowers.edit', $flower->id) }}"
                                    class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-cream hover:bg-cream-dark text-dark border border-dark/15 font-mono text-[11px] transition shadow-2xs"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.fresh-flowers.destroy', $flower->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus varietas bunga segar {{ $flower->name }} dari inventaris?');"
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
                            <td colspan="7" class="py-12 text-center text-dark/40 font-mono">
                                Belum ada spesimen bunga segar. Klik tombol <strong>+ Tambah Bunga Segar</strong> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($flowers->hasPages())
            <div class="p-4 border-t border-dark/10">
                {{ $flowers->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
