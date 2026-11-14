<x-layouts.client>
    <!-- Catalog Header -->
    <section class="py-10 md:py-14 bg-cream-light/60 dark:bg-night-surface/60 border-b border-dark/10 dark:border-night-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            <span class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">Bespoke Custom Atelier & Desain Referensi</span>
            <h1 class="font-heading text-3xl sm:text-4xl md:text-5xl font-normal text-dark dark:text-cream mt-2">
                Katalog Rangkaian Bunga
            </h1>
            <p class="text-xs sm:text-sm text-dark/75 dark:text-cream/75 font-body mt-3 leading-relaxed">
                Koleksi desain referensi buket kami dapat dipesan dan disesuaikan (<em>custom</em>) dengan budget Anda. Kami melayani pilihan <strong>bunga segar (kuota terbatas)</strong>, <strong>artificial flowers</strong>, serta <strong>dried flowers</strong> melalui 7 tahap alur kerja transparan & live preview online.
            </p>
        </div>
    </section>

    <!-- Main Catalog Interactive Section with Alpine.js live filter -->
    <section
        x-data="{
            selectedCategory: '{{ $categoryId ?? '' }}',
            searchQuery: '{{ $search ?? '' }}',
            maxPrice: {{ $maxPrice ?? 700000 }},
            onlyAvailable: {{ $availableOnly ? 'true' : 'false' }},
            loading: false,

            applyFilter() {
                const params = new URLSearchParams();
                if (this.selectedCategory) params.set('category', this.selectedCategory);
                if (this.searchQuery) params.set('q', this.searchQuery);
                if (this.maxPrice < 700000) params.set('max_price', this.maxPrice);
                if (this.onlyAvailable) params.set('available', '1');

                window.location.href = '{{ route('catalog.index') }}?' + params.toString();
            },

            resetFilter() {
                window.location.href = '{{ route('catalog.index') }}';
            }
        }"
        class="py-12 md:py-16"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- Sidebar Filters (Desktop & Mobile collapsible) -->
                <aside class="lg:col-span-1 space-y-6">
                    <div class="bg-surface/90 dark:bg-night-surface border border-primary/10 dark:border-night-border rounded-3xl p-6 shadow-xs sticky top-28">
                        <div class="flex items-center justify-between pb-4 border-b border-dark/10 dark:border-night-border">
                            <h3 class="font-heading text-lg font-bold text-dark dark:text-cream flex items-center gap-2">
                                <span>Filter Katalog</span>
                            </h3>
                            <button
                                @click="resetFilter()"
                                class="text-[11px] font-mono text-rose-600 dark:text-rose-400 hover:underline cursor-pointer"
                            >
                                Reset
                            </button>
                        </div>

                        <!-- Search input -->
                        <div class="pt-4 space-y-2">
                            <label class="block text-xs font-semibold text-dark/70 dark:text-cream/70 font-mono uppercase tracking-wider">Cari Buket / Bunga</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    x-model="searchQuery"
                                    @keydown.enter="applyFilter()"
                                    placeholder="Contoh: Mawar, Sunflower..."
                                    class="w-full rounded-xl bg-cream-light/60 dark:bg-night-card border border-dark/15 dark:border-night-border px-3.5 py-2 text-xs text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 focus:outline-none focus:border-primary dark:focus:border-accent"
                                />
                                <button
                                    @click="applyFilter()"
                                    class="absolute right-2.5 top-2 text-xs text-primary dark:text-accent font-bold"
                                >
                                    🔍
                                </button>
                            </div>
                        </div>

                        <!-- Category Selector -->
                        <div class="pt-5 space-y-2">
                            <label class="block text-xs font-semibold text-dark/70 dark:text-cream/70 font-mono uppercase tracking-wider">Kategori Pilihan</label>
                            <div class="space-y-1.5 text-xs">
                                <button
                                    type="button"
                                    @click="selectedCategory = ''; applyFilter();"
                                    :class="selectedCategory === '' ? 'bg-primary dark:bg-accent dark:text-night-bg text-cream font-semibold' : 'text-dark/80 dark:text-cream/80 hover:bg-black/5 dark:hover:bg-white/5'"
                                    class="w-full text-left px-3 py-2 rounded-xl transition flex items-center justify-between cursor-pointer"
                                >
                                    <span>Semua Kategori</span>
                                </button>
                                @foreach ($categories as $cat)
                                    <button
                                        type="button"
                                        @click="selectedCategory = '{{ $cat->id }}'; applyFilter();"
                                        :class="selectedCategory === '{{ $cat->id }}' ? 'bg-primary dark:bg-accent dark:text-night-bg text-cream font-semibold' : 'text-dark/80 dark:text-cream/80 hover:bg-black/5 dark:hover:bg-white/5'"
                                        class="w-full text-left px-3 py-2 rounded-xl transition flex items-center justify-between cursor-pointer"
                                    >
                                        <span>{{ $cat->name }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Slider -->
                        <div class="pt-5 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <label class="font-semibold text-dark/70 dark:text-cream/70 font-mono uppercase tracking-wider">Maks. Harga</label>
                                <span class="font-mono text-primary dark:text-accent font-bold" x-text="'Rp ' + Number(maxPrice).toLocaleString('id-ID')"></span>
                            </div>
                            <input
                                type="range"
                                min="100000"
                                max="700000"
                                step="25000"
                                x-model="maxPrice"
                                @change="applyFilter()"
                                class="w-full accent-primary dark:accent-accent cursor-pointer"
                            />
                            <div class="flex justify-between text-[10px] font-mono text-dark/40 dark:text-cream/40">
                                <span>Rp 100k</span>
                                <span>Rp 700k</span>
                            </div>
                        </div>

                        <!-- Availability Checkbox -->
                        <div class="pt-5 border-t border-dark/10 dark:border-night-border">
                            <label class="flex items-center gap-2.5 text-xs text-dark/80 dark:text-cream/80 cursor-pointer">
                                <input
                                    type="checkbox"
                                    x-model="onlyAvailable"
                                    @change="applyFilter()"
                                    class="rounded accent-primary dark:accent-accent text-primary dark:text-accent focus:ring-primary h-4 w-4"
                                />
                                <span class="font-medium">Hanya produk yang tersedia (Ready)</span>
                            </label>
                        </div>
                    </div>
                </aside>

                <!-- Product Grid (2 cols smartphone, 4 cols laptop/desktop) -->
                <main class="lg:col-span-3">
                    <!-- Results Header & Active Filter Pills -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-dark/10 dark:border-night-border">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs text-dark/60 dark:text-cream/60">Menampilkan</span>
                            <span class="font-mono text-xs font-bold text-primary dark:text-accent">{{ $products->total() }} Buket Rangkaian</span>
                        </div>

                        <!-- Active filters -->
                        @if ($categoryId || $search || $maxPrice || $availableOnly)
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if ($search)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-mono bg-primary/10 dark:bg-primary/20 text-primary dark:text-accent">
                                        Cari: "{{ $search }}"
                                    </span>
                                @endif
                                @if ($categoryId)
                                    @php
                                        $activeCat = $categories->firstWhere('id', $categoryId);
                                    @endphp
                                    @if ($activeCat)
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-mono bg-primary/10 dark:bg-primary/20 text-primary dark:text-accent">
                                            Kategori: {{ $activeCat->name }}
                                        </span>
                                    @endif
                                @endif
                                <button @click="resetFilter()" class="text-xs text-dark/40 dark:text-cream/40 hover:text-rose-600 dark:hover:text-rose-400 font-mono ml-2">
                                    Bersihkan Filter ✕
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Products Grid -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6">
                            @foreach ($products as $product)
                                <x-client.product-card :product="$product" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-surface/70 dark:bg-night-surface/70 rounded-3xl border border-dashed border-primary/20 dark:border-night-border p-8">
                            <span class="text-4xl block mb-3">🌿</span>
                            <h3 class="font-heading text-xl font-medium text-dark dark:text-cream">Tidak Ada Buket yang Cocok</h3>
                            <p class="text-xs text-dark/60 dark:text-cream/60 font-body mt-2 max-w-sm mx-auto">
                                Coba ubah kata kunci pencarian atau bersihkan filter untuk menemukan rangkaian bunga lainnya.
                            </p>
                            <div class="mt-6">
                                <x-ui.button @click="resetFilter()" variant="primary" size="sm">
                                    Bersihkan Filter
                                </x-ui.button>
                            </div>
                        </div>
                    @endif
                </main>

            </div>
        </div>
    </section>
</x-layouts.client>
