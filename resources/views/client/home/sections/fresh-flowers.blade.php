    <!-- SECTION: ATELIER COLD ROOM & DAILY FRESH BLOOM VAULT (STOK BUNGA SEGAR HARI INI) -->
    <section id="fresh-flowers-vault" x-data="freshFlowersVault({{ Js::from(
            ($freshFlowers ?? collect())->map(function ($f) {
                return [
                    'id' => $f->id,
                    'name' => $f->name,
                    'botanical_name' => $f->botanical_name,
                    'origin' => $f->origin ?? 'Botanical Farm',
                    'color_name' => $f->color_name,
                    'color_hex' => $f->color_hex,
                    'stock_stems' => (int) $f->stock_stems,
                    'status' => $f->status,
                    'status_label' => $f->status_label,
                    'status_badge' => $f->status_badge,
                    'status_dot' => $f->status_dot_class,
                    'price' => $f->formatted_price,
                    'price_raw' => (int) ($f->price_per_stem ?? 0),
                    'vase_life' => $f->vase_life ?? '5 - 7 Hari',
                    'aroma_note' => $f->aroma_note ?? 'Segar Alami',
                    'description' => $f->description ?? '',
                    'image' => $f->image_url,
                ];
            }),
        ) }}, '{{ setting('whatsapp_number', '6285882119900') }}')"
        class="py-12 xs:py-16 md:py-20 lg:py-24 bg-cream-light/35 dark:bg-night-surface border-y border-border-subtle dark:border-night-border relative">
        <div class="max-w-7xl mx-auto px-4 xs:px-6 lg:px-8 relative z-10">

            <!-- 1. SECTION HEADER: MINIMAL & EDITORIAL -->
            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12">
                <span
                    class="inline-block text-[11px] sm:text-xs font-mono tracking-widest text-primary dark:text-accent uppercase font-semibold mb-2">
                    ATELIER COLD ROOM • Daily Fresh Bloom Vault
                </span>
                <h2
                    class="font-heading text-3xl xs:text-4xl lg:text-5xl text-dark dark:text-cream font-normal leading-tight">
                    Ketersediaan Bunga Segar Hari Ini
                </h2>
                <p class="text-xs sm:text-sm text-dark/65 dark:text-cream/65 font-body mt-2.5 leading-relaxed">
                    Bunga potong segar harian kurasi florist dari batch harian terbatas, disimpan dalam cold room untuk kesegaran mekar maksimal di vas Anda.
                </p>
            </div>

            <!-- 2. INTERACTIVE FILTER TABS & INSTANT SEARCH -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 sm:mb-10">
                <!-- Status Filter Pills -->
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" @click="filterStatus = 'all'"
                        :class="filterStatus === 'all' ?
                            'bg-primary dark:bg-accent text-cream dark:text-night-bg font-semibold shadow-xs' :
                            'bg-surface-light dark:bg-night-card text-dark/70 dark:text-cream/70 border border-border-subtle dark:border-night-border hover:bg-cream dark:hover:bg-surface-hover'"
                        class="px-4 py-2 rounded-full text-xs font-mono transition-all cursor-pointer flex items-center gap-1.5">
                        <span>Semua Bunga</span>
                        <span class="opacity-70">({{ count($freshFlowers) }})</span>
                    </button>

                    <button type="button" @click="filterStatus = 'ready'"
                        :class="filterStatus === 'ready' ? 'bg-primary dark:bg-accent text-cream dark:text-night-bg font-semibold shadow-xs' :
                            'bg-surface-light dark:bg-night-card text-dark/70 dark:text-cream/70 border border-border-subtle dark:border-night-border hover:bg-cream dark:hover:bg-surface-hover'"
                        class="px-4 py-2 rounded-full text-xs font-mono transition-all cursor-pointer flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-brand-emerald"></span>
                        <span>Ready Hari Ini</span>
                        <span class="opacity-70">({{ $freshFlowers->where('status', 'ready')->count() }})</span>
                    </button>

                    <button type="button" @click="filterStatus = 'limited'"
                        :class="filterStatus === 'limited' ? 'bg-brand-amber text-cream font-semibold shadow-xs' :
                            'bg-surface-light dark:bg-night-card text-dark/70 dark:text-cream/70 border border-border-subtle dark:border-night-border hover:bg-cream dark:hover:bg-surface-hover'"
                        class="px-4 py-2 rounded-full text-xs font-mono transition-all cursor-pointer flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-brand-amber animate-pulse"></span>
                        <span>Sisa Sedikit</span>
                        <span class="opacity-70">({{ $freshFlowers->where('status', 'limited')->count() }})</span>
                    </button>
                </div>

                <!-- Instant Search Input -->
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="searchQuery" placeholder="Cari mawar, lily, warna..."
                        class="w-full pl-9 pr-8 py-2 rounded-full bg-surface-light dark:bg-night-card border border-dark/15 dark:border-night-border text-xs text-dark dark:text-cream focus:outline-none focus:border-primary font-body">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-dark/40 dark:text-cream/40 text-xs">🔍</span>
                    <button x-show="searchQuery" @click="searchQuery = ''" type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-dark/40 dark:text-cream/40 hover:text-dark text-xs font-bold">&times;</button>
                </div>
            </div>

            <!-- 3. INTERACTIVE SPECIMEN CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <template x-for="item in filteredFlowers()" :key="item.id">
                    <div @click="toggleCard(item.id)"
                        class="group relative aspect-[4/5] rounded-[2rem] overflow-hidden border border-border-subtle dark:border-night-border shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 select-none bg-dark cursor-pointer">
                        <!-- 1. FULL-BLEED BACKGROUND PRODUCT PHOTO -->
                        <img :src="item.image" :alt="item.name"
                            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out"
                            :class="isCardActive(item.id) ? 'scale-105 filter brightness-75' : 'group-hover:scale-105'"
                            loading="lazy" decoding="async" />

                        <!-- Gradient Scrim -->
                        <div class="absolute inset-0 transition-opacity duration-300 pointer-events-none"
                            :class="isCardActive(item.id) ? 'bg-night-bg/60' :
                                'bg-gradient-to-t from-night-bg/50 via-transparent to-transparent'">
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-night-bg/40 to-transparent pointer-events-none">
                        </div>

                        <!-- 2. STATE 1: PURE PHOTO SHOWCASE -->
                        <div x-show="!isCardActive(item.id)" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute inset-x-0 bottom-4 sm:bottom-5 z-10 flex flex-col items-center gap-2 px-4 pointer-events-none">
                            <!-- Badge Stok -->
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] sm:text-xs font-mono font-semibold shadow-md border backdrop-blur-xs"
                                :class="item.status === 'ready' ?
                                    'bg-night-card/90 text-accent border-secondary/40' :
                                    (item.status === 'limited' ? 'bg-night-card/90 text-brand-amber border-brand-amber/40' :
                                        'bg-night-card/90 text-cream/70 border-border-subtle')">
                                <span class="w-2 h-2 rounded-full" :class="item.status_dot"></span>
                                <span x-text="'Stok Tersisa: ' + item.stock_stems + ' Tangkai'"></span>
                            </span>

                            <!-- Button "Klik untuk memesan" -->
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-cream text-dark font-mono text-xs font-bold shadow-xl border border-white/40 group-hover:scale-105 group-hover:bg-primary group-hover:text-cream transition-all duration-300">
                                <span>Klik untuk memesan</span>
                                <span class="font-serif text-sm">→</span>
                            </div>
                        </div>

                        <!-- 3. STATE 2: ACTIVE ORDERING VIEW -->
                        <div x-show="isCardActive(item.id)" x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-6 scale-98"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-6 scale-98" @click.stop
                            class="absolute inset-0 z-20 p-5 sm:p-6 rounded-[2rem] bg-night-surface/95 border border-border-subtle shadow-2xl flex flex-col justify-between text-cream">
                            <!-- Top Bar -->
                            <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                                <div class="flex items-center gap-2 text-xs font-mono text-cream/80">
                                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                                    <span class="truncate" x-text="'Stok: ' + item.stock_stems + ' Tangkai'"></span>
                                </div>

                                <button type="button" @click.stop="activeCardId = null"
                                    class="px-3 py-1 rounded-full bg-surface-hover text-cream/80 hover:text-cream text-xs font-mono transition flex items-center gap-1 cursor-pointer"
                                    title="Tutup & Kembali ke Foto">
                                    <span>✕</span>
                                    <span>Tutup</span>
                                </button>
                            </div>

                            <!-- Mid Section -->
                            <div class="space-y-3 my-auto py-2">
                                <div>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-serif italic text-xs sm:text-sm text-accent block truncate"
                                            x-text="item.botanical_name || 'Botanical Species'"></span>

                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-card text-cream text-[10px] font-mono border border-border-subtle shrink-0">
                                            <span class="w-2.5 h-2.5 rounded-full border border-white/30 shrink-0"
                                                :style="'background-color: ' + item.color_hex"></span>
                                            <span class="truncate max-w-[100px]" x-text="item.color_name"></span>
                                        </span>
                                    </div>
                                    <h3 class="font-heading text-xl sm:text-2xl font-normal text-cream leading-tight mt-1"
                                        x-text="item.name"></h3>
                                </div>

                                <!-- Specs Grid -->
                                <div class="grid grid-cols-2 gap-2 text-xs font-mono">
                                    <div class="p-2.5 rounded-xl bg-night-card border border-border-subtle">
                                        <span class="block text-[10px] text-cream/50 uppercase">Ketahanan Vas</span>
                                        <span class="font-bold text-cream flex items-center gap-1 mt-0.5">
                                            <span>⏳</span>
                                            <span x-text="item.vase_life"></span>
                                        </span>
                                    </div>

                                    <div class="p-2.5 rounded-xl bg-night-card border border-border-subtle">
                                        <span class="block text-[10px] text-cream/50 uppercase">Asal Kebun</span>
                                        <span class="font-bold text-cream flex items-center gap-1 mt-0.5 truncate">
                                            <span>📍</span>
                                            <span x-text="item.origin"></span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Aroma Note -->
                                <div class="flex items-center gap-1.5 text-xs text-cream/75 font-body">
                                    <span>🌸</span>
                                    <span class="truncate" x-text="item.aroma_note"></span>
                                </div>
                            </div>

                            <!-- Bottom Section -->
                            <div class="space-y-3 pt-3 border-t border-border-subtle">
                                <div class="flex items-baseline justify-between">
                                    <div>
                                        <span class="block text-[10px] font-mono uppercase text-cream/50">Harga Satuan</span>
                                        <span class="font-mono text-base sm:text-lg font-bold text-accent"
                                            x-text="item.price"></span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-[10px] font-mono uppercase text-cream/50">Estimasi Total</span>
                                        <span class="font-mono text-sm sm:text-base font-bold text-cream"
                                            x-text="getSubtotal(item)"></span>
                                    </div>
                                </div>

                                <!-- Stepper & Presets -->
                                <div class="flex items-center justify-between gap-2">
                                    <div
                                        class="flex items-center rounded-full bg-night-card border border-border-subtle p-0.5">
                                        <button type="button"
                                            @click.stop="setQuantity(item.id, getQuantity(item.id) - 1, item.stock_stems)"
                                            :disabled="getQuantity(item.id) <= 1"
                                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-cream hover:bg-surface-hover disabled:opacity-25 transition cursor-pointer"
                                            aria-label="Kurangi tangkai">&minus;</button>
                                        <span class="w-8 text-center font-mono text-xs font-bold text-cream"
                                            x-text="getQuantity(item.id)"></span>
                                        <button type="button"
                                            @click.stop="setQuantity(item.id, getQuantity(item.id) + 1, item.stock_stems)"
                                            :disabled="getQuantity(item.id) >= (item.stock_stems || 99)"
                                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-cream hover:bg-surface-hover disabled:opacity-25 transition cursor-pointer"
                                            aria-label="Tambah tangkai">&plus;</button>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <template x-for="q in [3, 5, 10]">
                                            <button type="button" x-show="(item.stock_stems || 99) >= q"
                                                @click.stop="setQuantity(item.id, q, item.stock_stems)"
                                                :class="getQuantity(item.id) === q ?
                                                    'bg-primary text-cream font-bold shadow-xs' :
                                                    'bg-night-card text-cream/80 hover:bg-surface-hover'"
                                                class="px-2.5 py-1 rounded-full text-xs font-mono transition cursor-pointer"
                                                x-text="q + ' tkg'"></button>
                                        </template>
                                    </div>
                                </div>

                                <a :href="getWaLink(item)" target="_blank" rel="noopener noreferrer"
                                    class="w-full py-3 px-4 rounded-full bg-cream hover:bg-cream-light text-dark font-mono text-xs sm:text-sm font-semibold shadow-md transition-all flex items-center justify-center gap-2 text-center cursor-pointer hover:scale-102 active:scale-98">
                                    <span>Pesan Sekarang (<span x-text="getQuantity(item.id)"></span> Tangkai)</span>
                                    <span class="font-serif text-sm">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty Search Results State -->
            <div x-show="filteredFlowers().length === 0" class="py-16 text-center space-y-3">
                <span class="text-4xl block">🌸</span>
                <p class="font-heading text-lg font-bold text-dark dark:text-cream">Tidak ada bunga yang sesuai pencarian</p>
                <p class="text-xs text-dark/60 dark:text-cream/60 max-w-md mx-auto">
                    Coba ganti kata kunci pencarian atau hubungi florist kami untuk menanyakan stok bunga potong segar di luar daftar hari ini.
                </p>
                <button type="button" @click="filterStatus = 'all'; searchQuery = ''"
                    class="mt-2 px-4 py-2 rounded-full bg-cream text-dark border border-border-subtle text-xs font-mono font-semibold">
                    Reset Filter
                </button>
            </div>

            <!-- 4. ATELIER VASE CARE BANNER -->
            <div
                class="mt-10 p-5 sm:p-6 rounded-2xl bg-surface-light dark:bg-night-card border border-border-subtle dark:border-night-border flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-2 font-mono text-dark dark:text-cream font-bold shrink-0">
                    <span>💡</span>
                    <span>Tips Florist Merawat Bunga di Vas:</span>
                </div>
                <div
                    class="flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-dark/70 dark:text-cream/70 text-xs font-mono">
                    <span>✂️ Potong miring 45°</span>
                    <span>💧 Ganti air steril tiap 1-2 hari</span>
                    <span>☀️ Jauhkan dari AC & terik matahari langsung</span>
                </div>
            </div>

            <!-- 5. CALLOUT -->
            <div
                class="mt-10 p-6 sm:p-8 rounded-[2rem] bg-surface-light dark:bg-night-card border border-primary/20 dark:border-night-border shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-mono text-secondary-dark dark:text-accent font-semibold uppercase tracking-wider">
                        <span>✨</span>
                        <span>Request Bunga Langka & Impor Khusus</span>
                    </span>
                    <h4 class="font-heading text-xl sm:text-2xl font-normal text-dark dark:text-cream">
                        Mencari Peony, Ranunculus, Tulip Holland, atau Calla Lily?
                    </h4>
                    <p class="text-xs text-dark/70 dark:text-cream/70 font-body max-w-xl">
                        Kami melayani pre-order bunga segar langka (H-3 sebelum acara) langsung didatangkan dari kebun mitra kami dengan garansi kesegaran mekar optimal.
                    </p>
                </div>

                <x-ui.button
                    href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode('Halo Florist Maja Flower, saya ingin menanyakan pre-order jenis bunga segar khusus (seperti Peony / Tulip / Ranunculus / Calla Lily) untuk pesanan custom saya.') }}"
                    variant="primary" size="lg" target="_blank" class="shrink-0 shadow-md">
                    <span>Konsultasi Pre-Order Bunga Segar</span>
                    <span class="ml-2 font-serif">→</span>
                </x-ui.button>
            </div>

        </div>
    </section>
