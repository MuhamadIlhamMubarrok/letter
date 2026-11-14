<x-layouts.admin title="Manajemen Katalog Produk" header="Katalog & Stok Buket Bunga">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-heading text-lg font-bold text-dark">Daftar Produk Buket</h3>
            <p class="text-xs text-dark/60 font-body">Kelola koleksi buket signature, harga, komposisi bunga, dan ketersediaan stok.</p>
        </div>
        <x-ui.button href="{{ route('admin.products.create') }}" variant="primary" size="md">
            <span>+ Tambah Buket Baru</span>
        </x-ui.button>
    </div>

    <!-- Products Table -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead class="bg-cream-light/60 font-mono text-[11px] uppercase tracking-wider text-dark/60 border-b border-dark/10">
                    <tr>
                        <th class="py-3.5 px-6">Buket</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Harga Satuan</th>
                        <th class="py-3.5 px-6">Dimensi</th>
                        <th class="py-3.5 px-6">Status Bestseller & Stok</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark/5">
                    @forelse ($products as $product)
                        <tr class="hover:bg-cream/30 transition">
                            <!-- Image & Name -->
                            <td class="py-4 px-6 flex items-center gap-3">
                                <img
                                    src="{{ $product->primary_image_url }}"
                                    alt="{{ $product->name }}"
                                    class="w-12 h-12 rounded-xl object-cover bg-cream-light border border-dark/10 flex-shrink-0"
                                />
                                <div>
                                    <h4 class="font-heading text-sm font-semibold text-dark">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="hover:text-primary">
                                            {{ $product->name }}
                                        </a>
                                    </h4>
                                    <p class="text-[11px] text-dark/60 line-clamp-1 max-w-xs mt-0.5">
                                        {{ $product->flower_composition }}
                                    </p>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-mono bg-cream text-dark border border-cream-dark">
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>

                            <!-- Price -->
                            <td class="py-4 px-6 font-mono font-bold text-primary text-sm">
                                {{ $product->formatted_price }}
                            </td>

                            <!-- Dimensions -->
                            <td class="py-4 px-6 font-mono text-dark/70">
                                {{ $product->dimensions }}
                            </td>

                            <!-- Status & Bestseller -->
                            <td class="py-4 px-6 space-y-1">
                                <div>
                                    @if ($product->is_available)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-mono text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                            ● Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-mono text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200">
                                            ● Habis
                                        </span>
                                    @endif
                                </div>
                                @if ($product->is_bestseller)
                                    <div>
                                        <span class="text-[10px] font-mono text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                            ★ Bestseller
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2">
                                <a
                                    href="{{ route('admin.products.edit', $product->id) }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl bg-cream hover:bg-cream-dark text-dark font-mono text-[11px] transition border border-cream-dark shadow-2xs"
                                >
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus buket {{ $product->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-mono text-[11px] transition border border-rose-200 cursor-pointer"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-dark/50 font-mono">
                                Belum ada buket bunga. Klik "Tambah Buket Baru" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="p-4 border-t border-dark/10">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
