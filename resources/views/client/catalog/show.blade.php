<x-layouts.client>
    <section x-data="{
        activeImage: '{{ $product->primary_image_url }}',
        selectedWrapping: 'Sage Green',
        greetingCard: '',
        selectedAddons: [],
        addonPrices: {
            'Boneka Wisuda Teddy': 35000,
            'Cokelat Ferrero Rocher (5 pcs)': 45000,
            'Lampu LED Fairy Lights': 25000,
            'Cetak Foto Polaroid (2 lembar)': 15000
        },
        basePrice: {{ (float) $product->price }},
    
        calculateTotal() {
            let total = this.basePrice;
            this.selectedAddons.forEach(addon => {
                total += (this.addonPrices[addon] || 0);
            });
            return total;
        },
    
        generateWhatsAppUrl() {
            const totalFormatted = 'Rp ' + Number(this.calculateTotal()).toLocaleString('id-ID');
            let text = `Halo Florist Maja Flower (Buket No 1 di Maja), saya ingin konsultasi pemesanan custom buket referensi berikut:
    
    *Desain Referensi:* {{ $product->name }}
    *Kategori:* {{ $product->category->name ?? 'Signature' }}
    *Warna Wrapping:* ${this.selectedWrapping}
    *Kartu Ucapan Gratis:* ${this.greetingCard.trim() ? this.greetingCard.trim() : '(Kosong / Ditulis Sendiri)'}
    *Add-ons:* ${this.selectedAddons.length > 0 ? this.selectedAddons.join(', ') : 'Tanpa Add-on'}
    *Estimasi Total:* ${totalFormatted}
    
    *Link Produk:* {{ url()->current() }}
    
    Mohon info ketersediaan slot kuota bunga segar / opsi artificial & dried flowers, serta estimasi pengerjaannya ya. Terima kasih!`;
    
            return 'https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text=' + encodeURIComponent(text);
        }
    }" class="py-10 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center space-x-2 text-xs font-mono text-dark/60 dark:text-cream/60 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary dark:hover:text-accent">Beranda</a>
                <span>/</span>
                <a href="{{ route('catalog.index') }}" class="hover:text-primary dark:hover:text-accent">Katalog</a>
                <span>/</span>
                <span class="text-dark dark:text-cream font-medium">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">

                <!-- LEFT: IMAGE GALLERY (ALPINE.JS THUMBNAILS) -->
                <div class="lg:col-span-6 space-y-4">
                    <!-- Main Large Display -->
                    <div
                        class="relative aspect-[4/5] w-full rounded-3xl overflow-hidden bg-cream-light dark:bg-night-card border border-primary/10 dark:border-night-border shadow-lg">
                        <img :src="activeImage" alt="{{ $product->name }} - Buket Maja"
                            class="w-full h-full object-cover transition-all duration-500" />
                        @if ($product->is_bestseller)
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-primary text-cream shadow-md">
                                    ★ BESTSELLER
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails row -->
                    <div class="flex items-center gap-3 overflow-x-auto pb-2">
                        @foreach ($product->images as $img)
                            <button type="button" @click="activeImage = '{{ $img->url }}'"
                                :class="activeImage === '{{ $img->url }}' ?
                                    'ring-2 ring-primary dark:ring-accent border-transparent' :
                                    'opacity-70 hover:opacity-100 border-dark/10 dark:border-night-border'"
                                class="w-20 h-20 rounded-2xl overflow-hidden border bg-cream-light dark:bg-night-card flex-shrink-0 cursor-pointer transition-all duration-200">
                                <img src="{{ $img->url }}" alt="Thumbnail" class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT: PRODUCT DETAILS & BESPOKE CUSTOMIZATION FORM -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <!-- Category Badge -->
                        @if ($product->category)
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-mono bg-primary/10 dark:bg-primary/20 text-primary dark:text-accent border border-primary/20 dark:border-primary/40 mb-2">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        <h1 class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream">
                            {{ $product->name }}
                        </h1>

                        <!-- Dynamic Price (Roboto Mono) -->
                        <div class="mt-3 flex items-baseline gap-3">
                            <span
                                class="font-mono text-2xl sm:text-3xl font-bold text-primary dark:text-accent tracking-tight"
                                x-text="'Rp ' + Number(calculateTotal()).toLocaleString('id-ID')">
                                {{ $product->formatted_price }}
                            </span>
                            <span class="text-xs text-dark/50 dark:text-cream/50 font-mono">
                                (Termasuk Pajak & Packaging)
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p
                        class="text-xs sm:text-sm text-dark/75 dark:text-cream/80 font-body leading-relaxed border-t border-dark/10 dark:border-night-border pt-4">
                        {{ $product->description }}
                    </p>

                    <!-- SPECIFICATIONS GRID (ROBOTO MONO) -->
                    <div
                        class="p-5 rounded-2xl bg-surface/90 dark:bg-night-surface border border-primary/15 dark:border-night-border shadow-xs space-y-3 font-mono text-xs">
                        <div
                            class="flex items-start justify-between pb-2 border-b border-dark/10 dark:border-night-border">
                            <span class="text-dark/60 dark:text-cream/60 font-medium">Bunga Referensi:</span>
                            <span
                                class="text-dark dark:text-cream font-semibold text-right max-w-[65%]">{{ $product->flower_composition }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between pb-2 border-b border-dark/10 dark:border-night-border">
                            <span class="text-dark/60 dark:text-cream/60 font-medium">Dimensi Buket:</span>
                            <span class="text-dark dark:text-cream font-semibold">{{ $product->dimensions }}</span>
                        </div>
                        <div
                            class="flex items-start justify-between pb-2 border-b border-dark/10 dark:border-night-border">
                            <span class="text-dark/60 dark:text-cream/60 font-medium">Pilihan Bunga:</span>
                            <span class="text-primary dark:text-accent font-semibold text-right">Fresh (Kuota Terbatas)
                                / Artificial / Dried</span>
                        </div>
                        <div
                            class="flex items-center justify-between pb-2 border-b border-dark/10 dark:border-night-border">
                            <span class="text-dark/60 dark:text-cream/60 font-medium">Alur Pengerjaan:</span>
                            <span class="text-dark dark:text-cream font-semibold">7 Tahap Custom & Live Preview</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-dark/60 dark:text-cream/60 font-medium">Status Pengerjaan:</span>
                            <a href="{{ route('tracking.index') }}"
                                class="text-primary dark:text-accent font-semibold hover:underline flex items-center gap-1">
                                <span>Cek Resi Buket Online →</span>
                            </a>
                        </div>
                    </div>

                    <!-- 7-STEP ALUR CUSTOM CALLOUT NOTE -->
                    <div
                        class="p-4 rounded-2xl bg-amber-500/10 dark:bg-amber-500/15 border border-amber-500/30 text-xs font-body space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span
                                class="font-heading font-bold text-dark dark:text-cream flex items-center gap-1.5 text-xs">
                                <span>🌸</span>
                                <span>Model Pesanan Custom Buket</span>
                            </span>
                            <span
                                class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-900 dark:text-amber-200 font-bold">
                                Kuota Terbatas
                            </span>
                        </div>
                        <p class="text-dark/75 dark:text-cream/80 leading-relaxed text-[11px]">
                            Buket ini dirangkai secara <strong>custom sesuai budget & momen Anda</strong>. Stok bunga
                            segar (<em>fresh flowers</em>) kami sediakan dalam kuota harian terbatas—tersedia juga opsi
                            <em>artificial</em> & <em>dried flowers</em> premium yang awet. Semua pesanan melalui
                            konfirmasi foto preview sebelum dikirim!
                        </p>
                    </div>

                    <!-- CUSTOMIZATION PREVIEW BOX -->
                    <div
                        class="p-6 rounded-3xl bg-cream-light/80 dark:bg-night-surface/60 border border-dark/10 dark:border-night-border space-y-5">
                        <h3 class="font-heading text-lg font-medium text-dark dark:text-cream flex items-center gap-2">
                            <span>Personalisasi Buket Anda</span>
                            <span
                                class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-accent/30 dark:bg-accent/20 text-primary dark:text-accent">Gratis</span>
                        </h3>

                        <!-- 1. Wrapping Paper Color Palette -->
                        <div>
                            <label
                                class="block text-xs font-semibold font-mono uppercase tracking-wider text-dark/70 dark:text-cream/70 mb-2">
                                1. Pilihan Warna Kertas Wrapping
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                @foreach (['Sage Green', 'Earth Tone', 'Pastel Blush', 'Monochrome Ivory'] as $wrapping)
                                    <button type="button" @click="selectedWrapping = '{{ $wrapping }}'"
                                        :class="selectedWrapping === '{{ $wrapping }}' ?
                                            'bg-primary dark:bg-accent dark:text-night-bg text-cream border-primary dark:border-accent shadow-xs font-semibold' :
                                            'bg-white dark:bg-night-card text-dark dark:text-cream border-dark/15 dark:border-night-border hover:bg-cream dark:hover:bg-white/10'"
                                        class="p-2.5 rounded-xl border text-xs text-center transition cursor-pointer">
                                        {{ $wrapping }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- 2. Free Greeting Card Note -->
                        <div>
                            <label
                                class="block text-xs font-semibold font-mono uppercase tracking-wider text-dark/70 dark:text-cream/70 mb-1">
                                2. Kartu Ucapan Puitis (Gratis Cetak)
                            </label>
                            <textarea x-model="greetingCard" rows="3" placeholder="Tuliskan ucapan tulus Anda di sini (maks. 250 karakter)..."
                                class="w-full rounded-xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border p-3 text-xs text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 focus:outline-none focus:border-primary dark:focus:border-accent font-body"></textarea>
                            <span class="text-[10px] font-mono text-dark/40 dark:text-cream/40 mt-1 block">Kami cetak di
                                atas fine textured card dengan amplop mini.</span>
                        </div>

                        <!-- 3. Add-on Options -->
                        <div>
                            <label
                                class="block text-xs font-semibold font-mono uppercase tracking-wider text-dark/70 dark:text-cream/70 mb-2">
                                3. Tambahan Aksesoris (Opsional)
                            </label>
                            <div class="space-y-2 text-xs">
                                <label
                                    class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border cursor-pointer hover:border-primary dark:hover:border-accent transition">
                                    <div class="flex items-center gap-2.5">
                                        <input type="checkbox" value="Boneka Wisuda Teddy" x-model="selectedAddons"
                                            class="rounded accent-primary dark:accent-accent text-primary dark:text-accent h-4 w-4">
                                        <span class="text-dark dark:text-cream">Boneka Wisuda Teddy (+Toga)</span>
                                    </div>
                                    <span class="font-mono text-primary dark:text-accent font-semibold">+Rp
                                        35.000</span>
                                </label>

                                <label
                                    class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border cursor-pointer hover:border-primary dark:hover:border-accent transition">
                                    <div class="flex items-center gap-2.5">
                                        <input type="checkbox" value="Cokelat Ferrero Rocher (5 pcs)"
                                            x-model="selectedAddons"
                                            class="rounded accent-primary dark:accent-accent text-primary dark:text-accent h-4 w-4">
                                        <span class="text-dark dark:text-cream">Cokelat Ferrero Rocher (5 pcs)</span>
                                    </div>
                                    <span class="font-mono text-primary dark:text-accent font-semibold">+Rp
                                        45.000</span>
                                </label>

                                <label
                                    class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border cursor-pointer hover:border-primary dark:hover:border-accent transition">
                                    <div class="flex items-center gap-2.5">
                                        <input type="checkbox" value="Lampu LED Fairy Lights" x-model="selectedAddons"
                                            class="rounded accent-primary dark:accent-accent text-primary dark:text-accent h-4 w-4">
                                        <span class="text-dark dark:text-cream">Lampu LED Fairy Lights (Warm
                                            Light)</span>
                                    </div>
                                    <span class="font-mono text-primary dark:text-accent font-semibold">+Rp
                                        25.000</span>
                                </label>

                                <label
                                    class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border cursor-pointer hover:border-primary dark:hover:border-accent transition">
                                    <div class="flex items-center gap-2.5">
                                        <input type="checkbox" value="Cetak Foto Polaroid (2 lembar)"
                                            x-model="selectedAddons"
                                            class="rounded accent-primary dark:accent-accent text-primary dark:text-accent h-4 w-4">
                                        <span class="text-dark dark:text-cream">Cetak Foto Polaroid (2 lembar)</span>
                                    </div>
                                    <span class="font-mono text-primary dark:text-accent font-semibold">+Rp
                                        15.000</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTON: ORDER DIRECT VIA WHATSAPP -->
                    <div class="pt-2">
                        <a :href="generateWhatsAppUrl()" target="_blank"
                            class="flex items-center justify-center gap-3 w-full py-4 px-6 rounded-full bg-primary hover:bg-primary-dark text-cream text-sm font-semibold shadow-xl hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.477-.15-.678.15-.2.301-.778.98-.954 1.18-.176.2-.351.226-.653.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.2-.301.301-.502.1-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.508-.678-.517-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.482 1.079 2.912 1.23 3.113.15.201 2.124 3.243 5.145 4.549.718.311 1.279.497 1.716.636.721.229 1.377.197 1.895.12.578-.087 1.78-.728 2.031-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z" />
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.66 1.433 5.174L2 22l4.981-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.2c-1.577 0-3.056-.441-4.323-1.209l-.31-.188-3.208.899.914-3.123-.206-.328A8.163 8.163 0 013.8 12c0-4.521 3.679-8.2 8.2-8.2 4.521 0 8.2 3.679 8.2 8.2 0 4.521-3.679 8.2-8.2 8.2z" />
                            </svg>
                            <span>Pesan Sekarang via WhatsApp</span>
                            <span class="font-serif text-base">→</span>
                        </a>
                        <p class="text-center text-[11px] font-mono text-dark/50 dark:text-cream/50 mt-2">
                            Pesan WhatsApp otomatis terisi nama buket, wrapping, ucapan, dan kalkulasi add-on.
                        </p>
                    </div>

                </div>
            </div>

            <!-- RELATED PRODUCTS SECTION -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-24 pt-12 border-t border-dark/10 dark:border-night-border">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <span
                                class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">Rekomendasi
                                Lainnya</span>
                            <h2 class="font-heading text-2xl sm:text-3xl font-normal text-dark dark:text-cream mt-1">
                                Koleksi Bunga Terkait
                            </h2>
                        </div>
                        <a href="{{ route('catalog.index') }}"
                            class="text-xs font-mono text-primary dark:text-accent font-semibold hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($relatedProducts as $relProduct)
                            <x-client.product-card :product="$relProduct" />
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
</x-layouts.client>
