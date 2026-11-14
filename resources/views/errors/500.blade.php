<x-layouts.client title="500 — Kendala Sistem Studio | Maja Flower">
    <section class="min-h-[75vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Botanical Ambient Background Glow -->
        <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-40 dark:opacity-20">
            <div class="w-96 h-96 rounded-full bg-secondary/20 blur-3xl"></div>
            <div class="w-80 h-80 rounded-full bg-primary/20 blur-3xl -ml-20"></div>
        </div>

        <div class="max-w-2xl mx-auto text-center relative z-10 space-y-8">
            <!-- Botanical Flower Emblem & 500 Badge -->
            <div class="flex flex-col items-center justify-center">
                <div class="relative inline-block mb-3">
                    <div
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-cream-light dark:bg-night-card p-4 shadow-xl border-2 border-primary/20 dark:border-night-border flex items-center justify-center">
                        <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo"
                            class="h-full w-auto object-contain">
                    </div>
                    <span
                        class="absolute -bottom-1 -right-1 px-3 py-1 rounded-full text-xs font-mono font-bold bg-amber-600 text-cream shadow-md">
                        500
                    </span>
                </div>
                <span
                    class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">
                    Atelier Maja Flower • Kendala Teknis Sementara
                </span>
            </div>

            <!-- Poetic Headline & Explanation -->
            <div class="space-y-3">
                <h1
                    class="font-heading text-3xl sm:text-4xl md:text-5xl font-normal text-dark dark:text-cream leading-tight">
                    Taman Kami Sedang Ditata Ulang, <br />
                    <span class="italic font-serif text-primary dark:text-accent font-medium">Harap Bersabar Sejenak.</span>
                </h1>
                <p
                    class="text-xs sm:text-sm text-dark/75 dark:text-cream/75 font-body max-w-lg mx-auto leading-relaxed">
                    Sistem server kami sedang mengalami kendala sementara saat memproses permintaan Anda. Tim teknis atelier kami sedang berupaya memulihkannya sesegera mungkin.
                </p>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ route('home') }}"
                    class="px-6 py-3 rounded-full bg-primary hover:bg-primary-dark text-cream text-xs font-semibold font-body shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer">
                    <span>← Kembali ke Beranda</span>
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="px-6 py-3 rounded-full bg-white dark:bg-night-card text-dark dark:text-cream hover:bg-cream dark:hover:bg-white/10 border border-dark/15 dark:border-night-border text-xs font-semibold font-body shadow-xs transition flex items-center gap-2 cursor-pointer">
                    <span>💐 Katalog Koleksi</span>
                </a>
                <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode('Halo Florist Maja Flower, saya mengalami kendala teknis (Error 500) pada website saat ingin melakukan pemesanan.') }}"
                    target="_blank"
                    class="px-5 py-3 rounded-full bg-secondary/10 dark:bg-accent/15 text-secondary-dark dark:text-accent hover:bg-secondary/20 text-xs font-semibold font-mono border border-secondary/20 dark:border-accent/30 transition flex items-center gap-2 cursor-pointer">
                    <span>💬 Hubungi Florist via WhatsApp</span>
                </a>
            </div>

            <!-- Botanical Quote Footer -->
            <div class="pt-6 border-t border-dark/10 dark:border-night-border">
                <p class="font-serif italic text-xs text-dark/50 dark:text-cream/50">
                    "Kecantikan bunga butuh waktu untuk mekar sempurna, begitu pula dedikasi kami dalam melayani Anda." — Maja Flower Studio
                </p>
            </div>
        </div>
    </section>
</x-layouts.client>
