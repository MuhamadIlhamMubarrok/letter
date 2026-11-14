    @php
        // Mood presets for curated hero bouquets (aligned with official Design Tokens)
        $moodPresets = [
            'teddy-series-rose-petite' => [
                'mood_title' => 'Romansa Kasih',
                'mood_subtitle' => 'Mawar Pink & Teddy Manis',
                'mood_icon' => '🌹',
                'aura_color' => 'bg-brand-rose/15 dark:bg-brand-rose/10',
            ],
            'teddy-series-violette' => [
                'mood_title' => 'Ceria Sahabat',
                'mood_subtitle' => 'Mawar Beludru & Aster Ungu',
                'mood_icon' => '💜',
                'aura_color' => 'bg-brand-indigo/15 dark:bg-brand-indigo/10',
            ],
            'teddy-series-rose-big-size' => [
                'mood_title' => 'Momen Wisuda',
                'mood_subtitle' => 'Grand Teddy & Mawar Mekar',
                'mood_icon' => '🎓',
                'aura_color' => 'bg-brand-amber/15 dark:bg-brand-amber/10',
            ],
            'lumiere-series-sunshine' => [
                'mood_title' => 'Mentari Hangat',
                'mood_subtitle' => 'Sunflower Jumbo & Wild Daisy',
                'mood_icon' => '🌻',
                'aura_color' => 'bg-cream-dark/30 dark:bg-cream-dark/15',
            ],
            'lumiere-series-blanche' => [
                'mood_title' => 'Kemurnian Elegan',
                'mood_subtitle' => 'Mawar Putih & Eucalyptus',
                'mood_icon' => '🤍',
                'aura_color' => 'bg-brand-emerald/15 dark:bg-brand-emerald/10',
            ],
            'lumiere-series-aurore' => [
                'mood_title' => 'Pesona Senja',
                'mood_subtitle' => 'Signature Botanical Palette',
                'mood_icon' => '✨',
                'aura_color' => 'bg-secondary/15 dark:bg-secondary/10',
            ],
        ];

        // Prepare hero bouquets with lowest price first & mood descriptors
        $heroBouquets = ($bestsellers ?? collect())
            ->sortBy('price')
            ->values()
            ->map(function ($product) use ($moodPresets) {
                $priceNum = (float) $product->price;
                $slug = $product->slug;
                $preset = $moodPresets[$slug] ?? [
                    'mood_title' => $product->name,
                    'mood_subtitle' => $product->category?->name ?? 'Signature Collection',
                    'mood_icon' => '🌸',
                    'aura_color' => 'bg-secondary/15 dark:bg-secondary/10',
                ];

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category?->name ?? 'Signature Collection',
                    'price' => $product->formatted_price,
                    'price_num' => $priceNum,
                    'flowers' => $product->flower_composition ?: 'Rangkaian bunga segar & artificial terkurasi',
                    'dimensions' => $product->dimensions ?? 'Ukuran Standar Florist',
                    'image' => $product->primary_image_url,
                    'slug' => $slug,
                    'mood_title' => $preset['mood_title'],
                    'mood_subtitle' => $preset['mood_subtitle'],
                    'mood_icon' => $preset['mood_icon'],
                    'aura_color' => $preset['aura_color'],
                    'wa_link' => 'https://wa.me/' . setting('whatsapp_number', '6285882119900') . '?text=' . rawurlencode('Halo Florist Maja Flower, saya mau pesan buket ' . $product->name . ' (' . $product->formatted_price . '). Apakah bisa kirim sameday?'),
                ];
            })
            ->values();
    @endphp

    <!-- HERO SECTION: THE BOTANICAL LIVING ATELIER -->
    <section x-data="{
        activeBouquet: 0,
        bouquets: {{ Js::from($heroBouquets) }},
        selectBouquet(idx, event) {
            this.activeBouquet = idx;
            if (event && window.heroFlowerCanvasInstance) {
                window.dispatchEvent(new CustomEvent('hero-flower-burst', {
                    detail: { x: event.clientX, y: event.clientY }
                }));
            }
        }
    }" class="hero-section relative overflow-hidden pt-6 pb-16 md:pt-10 md:pb-24 select-none">

        <!-- INTERACTIVE 60FPS BOTANICAL PETAL CANVAS (Zero lag, cursor-driven breeze, click to bloom) -->
        <canvas id="hero-flower-canvas"
            class="absolute inset-0 w-full h-full pointer-events-auto cursor-pointer z-0 opacity-80 dark:opacity-60"
            title="Klik atau sentuh layar untuk memekarkan bunga"></canvas>

        <!-- Ambient Atmospheric Botanical Glow (Smoothly reacts to active bouquet palette) -->
        <div class="absolute -top-36 -left-20 w-[550px] h-[550px] rounded-full blur-[140px] pointer-events-none transition-colors duration-700"
            :class="bouquets[activeBouquet]?.aura_color || 'bg-secondary/15 dark:bg-secondary/10'">
        </div>
        <div class="absolute top-1/4 -right-24 w-[500px] h-[500px] rounded-full bg-accent/20 dark:bg-accent/10 blur-[140px] pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pointer-events-none">

            <!-- MINIMALIST ARCHITECTURAL TOP RIBBON -->
            <div class="flex items-center justify-between pb-4 mb-8 sm:mb-12 border-b border-dark/10 dark:border-night-border text-xs pointer-events-auto">
                <div class="flex items-center gap-2.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary dark:bg-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary dark:bg-accent"></span>
                    </span>
                    <span class="font-mono text-[11px] uppercase tracking-[0.18em] text-dark/70 dark:text-cream/70 font-semibold">
                        MAJA FLOWER ATELIER &bull; {{ setting('hero_ticker_text', 'Fresh Flower Terbatas') }}
                    </span>
                    <span class="hidden md:inline text-dark/40 dark:text-cream/40 font-mono text-[11px]">
                        ({{ __('messages.hero_slot') }})
                    </span>
                </div>

                <div class="hidden sm:flex items-center gap-3 font-mono text-[11px] text-dark/65 dark:text-cream/65">
                    <span class="text-primary dark:text-accent font-semibold">
                        <span class="font-bold">{{ setting('hero_stat_curated', '12.4k+') }}</span> Buket Terkurasi
                    </span>
                    <span class="opacity-40">&bull;</span>
                    <span>Sameday Siap Kirim</span>
                    <span class="opacity-40">&bull;</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-primary/10 dark:bg-accent/15 text-primary dark:text-accent font-bold">
                        Mulai {{ $startingPrice ?? 'Rp 70.000' }}
                    </span>
                </div>
            </div>

            <!-- MAIN EDITORIAL ASYMMETRIC STAGE -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">

                <!-- LEFT COLUMN: POETIC HEADLINE, BOTANICAL MOOD DIAL & MINIMALIST CTAs -->
                <div class="lg:col-span-7 space-y-7 pointer-events-auto">

                    <!-- Official Brand Badge -->
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-surface/85 dark:bg-night-card/85 backdrop-blur-md border border-dark/10 dark:border-night-border text-xs font-mono shadow-2xs">
                        <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo" class="w-3.5 h-3.5 object-contain inline-block">
                        <span class="text-primary dark:text-accent font-bold">MAJA FLOWER</span>
                        <span class="text-dark/30 dark:text-cream/30">&bull;</span>
                        <span class="text-dark/70 dark:text-cream/70">Boutique Floral Studio Maja</span>
                    </div>

                    <!-- Master Poetic Headline -->
                    <div class="space-y-2">
                        <h1 class="font-heading text-4xl sm:text-6xl lg:text-[4.2rem] font-medium text-dark dark:text-cream tracking-tight leading-[1.08]">
                            {{ __('messages.hero_title_1') }} <br />
                            <span class="italic font-serif font-normal text-primary dark:text-accent relative inline-block">
                                {{ __('messages.hero_title_highlight') }} {{ __('messages.hero_title_2') }}
                                <svg class="absolute -bottom-1.5 left-0 w-full h-3 text-secondary/40 dark:text-accent/35 -z-10" viewBox="0 0 260 12" fill="none" preserveAspectRatio="none">
                                    <path d="M3 8.5C60 2 180 2 257 8.5" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </h1>
                        <p class="text-sm sm:text-base text-dark/75 dark:text-cream/80 font-body leading-relaxed max-w-xl pt-2">
                            {{ __('messages.hero_subtitle') }}
                        </p>
                    </div>

                    <!-- INTERACTIVE FLORAL MOOD DIAL (Replaces messy tags with clean interactive mood switcher) -->
                    <div class="space-y-2.5 pt-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-mono uppercase tracking-widest text-secondary-dark dark:text-accent font-bold flex items-center gap-1.5">
                                <span>🌸</span>
                                <span>Pilih Nuansa Rangkaian:</span>
                            </span>
                            <span class="text-[10px] font-mono text-dark/50 dark:text-cream/50 hidden sm:inline">
                                Klik untuk mekar &bull; Ubah buket
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="(item, idx) in bouquets" :key="idx">
                                <button type="button"
                                    @click="selectBouquet(idx, $event)"
                                    :class="activeBouquet === idx ?
                                        'bg-primary text-cream border-primary shadow-lg scale-[1.02] dark:bg-accent dark:text-night-bg dark:border-accent font-bold' :
                                        'bg-surface/90 dark:bg-night-card/90 text-dark/80 dark:text-cream/80 border-dark/10 dark:border-night-border hover:border-primary/40 hover:bg-surface dark:hover:bg-white/10'"
                                    class="group px-3.5 py-2 rounded-2xl text-xs font-mono border transition-all duration-300 cursor-pointer flex items-center gap-2 active:scale-95">
                                    <span class="text-sm transition-transform duration-300 group-hover:scale-125" x-text="item.mood_icon"></span>
                                    <span x-text="item.mood_title"></span>
                                    <span class="opacity-60 text-[11px]" x-text="'(' + item.price + ')'"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- REFINED CALL TO ACTIONS -->
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <!-- Primary WhatsApp Order CTA -->
                        <a :href="bouquets[activeBouquet]?.wa_link || 'https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}'"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group inline-flex items-center justify-center gap-2.5 px-6 sm:px-7 py-3.5 sm:py-4 rounded-full bg-primary hover:bg-primary-dark text-cream font-body font-bold text-xs sm:text-sm shadow-xl hover:shadow-primary/30 transition-all duration-300 active:scale-95 cursor-pointer">
                            <span class="text-base group-hover:scale-125 transition-transform">💬</span>
                            <span>Pesan via WhatsApp</span>
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-xs font-mono font-normal" x-text="bouquets[activeBouquet]?.price"></span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>

                        <!-- Secondary Explore Catalog CTA -->
                        <x-ui.button href="{{ route('catalog.index') }}" variant="outline" size="lg" class="rounded-full!">
                            <span>{{ __('messages.hero_btn_explore') }}</span>
                            <span class="ml-2 font-serif text-lg">↗</span>
                        </x-ui.button>
                    </div>

                    <!-- MINIMALIST TRUST BAR (Understated, single-line assurances) -->
                    <div class="pt-2 flex flex-wrap items-center gap-y-2 gap-x-4 text-xs font-mono text-dark/70 dark:text-cream/70">
                        <div class="flex items-center gap-1.5">
                            <span class="text-brand-emerald dark:text-accent font-bold">✓</span>
                            <span>Live Foto Sebelum Kirim</span>
                        </div>
                        <span class="text-dark/20 dark:text-cream/20">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-brand-emerald dark:text-accent font-bold">✓</span>
                            <span>Siap Kirim Sameday</span>
                        </div>
                        <span class="text-dark/20 dark:text-cream/20">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-brand-emerald dark:text-accent font-bold">✓</span>
                            <span>Gratis Kartu Ucapan</span>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: THE BOTANICAL LIVING ARCH (Unique centerpiece showcase) -->
                <div class="lg:col-span-5 relative pointer-events-auto">
                    <div class="relative mx-auto max-w-sm sm:max-w-md lg:max-w-none">

                        <!-- Ambient Rotating Botanical Halo Orbit -->
                        <div class="absolute -inset-4 sm:-inset-6 pointer-events-none flex items-center justify-center opacity-40 dark:opacity-30">
                            <svg class="w-full h-full animate-slow-rotate" viewBox="0 0 400 400" fill="none">
                                <circle cx="200" cy="200" r="190" stroke="currentColor" stroke-width="1.2" stroke-dasharray="8 8" class="text-secondary/50 dark:text-accent/40" />
                                <circle cx="200" cy="10" r="4" fill="currentColor" class="text-primary dark:text-accent" />
                                <circle cx="390" cy="200" r="3" fill="currentColor" class="text-secondary dark:text-accent" />
                                <circle cx="200" cy="390" r="4" fill="currentColor" class="text-primary dark:text-accent" />
                                <circle cx="10" cy="200" r="3" fill="currentColor" class="text-secondary dark:text-accent" />
                            </svg>
                        </div>

                        <!-- Sculpted Botanical Arch Frame -->
                        <div class="relative overflow-hidden rounded-[3.5rem] md:rounded-[4.5rem] bg-cream-dark/40 dark:bg-night-card/60 shadow-2xl aspect-[4/5] border-[6px] border-surface/90 dark:border-night-card backdrop-blur-xs group">

                            <!-- Bouquet Showcase Image with smooth transition -->
                            <img :src="bouquets[activeBouquet]?.image || ''"
                                :alt="bouquets[activeBouquet]?.name || 'Maja Flower Bouquet'"
                                class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105" />

                            <!-- Artistic Vignette & Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent"></div>

                            <!-- Floating Price Tag (Top Right) -->
                            <div class="absolute top-5 right-5 bg-surface/95 dark:bg-night-card/95 backdrop-blur-md px-4 py-1.5 rounded-full shadow-lg border border-primary/20 dark:border-night-border flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-brand-emerald animate-pulse"></span>
                                <span class="text-xs sm:text-sm font-mono font-bold text-primary dark:text-accent"
                                    x-text="bouquets[activeBouquet]?.price || 'Rp 70.000'"></span>
                            </div>

                            <!-- Category / Mood Badge (Top Left) -->
                            <div class="absolute top-5 left-5 bg-primary/90 dark:bg-accent/90 text-cream dark:text-night-bg backdrop-blur-md px-3.5 py-1 rounded-full text-[10px] font-mono font-bold shadow-md tracking-wider uppercase flex items-center gap-1.5">
                                <span x-text="bouquets[activeBouquet]?.mood_icon"></span>
                                <span x-text="bouquets[activeBouquet]?.category"></span>
                            </div>

                            <!-- Frosted Glass Floral Card Footer -->
                            <div class="absolute bottom-6 left-6 right-6 text-cream">
                                <div class="bg-dark/40 dark:bg-black/50 backdrop-blur-md p-4 rounded-3xl border border-white/15">
                                    <span class="font-mono text-[10px] uppercase tracking-widest text-accent font-semibold block"
                                        x-text="bouquets[activeBouquet]?.mood_subtitle || ''"></span>
                                    <h3 class="font-heading text-lg sm:text-xl font-bold mt-0.5 leading-snug line-clamp-1"
                                        x-text="bouquets[activeBouquet]?.name || ''"></h3>
                                    <p class="text-[11px] text-cream/75 font-body mt-1 line-clamp-1"
                                        x-text="bouquets[activeBouquet]?.flowers || ''"></p>

                                    <div class="mt-2.5 pt-2 border-t border-white/10 flex items-center justify-between text-xs font-mono">
                                        <span class="text-[11px] text-cream/60"
                                            x-text="bouquets[activeBouquet]?.dimensions || ''"></span>
                                        <a :href="'/katalog/' + (bouquets[activeBouquet]?.slug || '')"
                                            class="text-accent hover:underline font-bold flex items-center gap-1">
                                            <span>Detail Buket</span>
                                            <span>→</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gentle Floating Easter Egg Tooltip -->
                        <div class="mt-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface/70 dark:bg-night-card/70 backdrop-blur-md border border-dark/10 dark:border-night-border text-[11px] font-mono text-dark/60 dark:text-cream/60">
                                <span>🌸</span>
                                <span>Klik di mana saja untuk memekarkan bunga</span>
                            </span>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
