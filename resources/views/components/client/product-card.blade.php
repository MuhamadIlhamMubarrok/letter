@props(['product'])

@php
    $whatsappText = urlencode(
        "Halo Maja Flower (Buket No 1 di Maja), saya tertarik memesan buket: *{$product->name}* ({$product->formatted_price}). Mohon info ketersediaannya ya! " .
            route('catalog.show', $product->slug),
    );
    $waNum = setting('whatsapp_number', '6285882119900');
    $whatsappUrl = "https://wa.me/{$waNum}?text={$whatsappText}";
@endphp

<div
    class="group relative flex flex-col overflow-hidden rounded-3xl bg-surface/90 dark:bg-night-surface border border-primary/10 dark:border-night-border shadow-xs hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
    <!-- Image & Badge Container -->
    <div class="relative aspect-[4/5] w-full overflow-hidden bg-cream-light dark:bg-night-card">
        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }} - Buket Maja" loading="lazy"
            class="h-full w-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105" />

        <div
            class="absolute inset-0 bg-gradient-to-t from-dark/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>

        <!-- Badges -->
        <div class="absolute top-3.5 left-3.5 flex flex-wrap gap-1.5 z-10">
            @if ($product->is_bestseller)
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-mono tracking-wider font-semibold bg-primary text-cream shadow-xs">
                    ★ BESTSELLER
                </span>
            @endif

            @if ($product->category)
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-mono tracking-wide bg-cream/90 dark:bg-night-surface/90 text-dark dark:text-cream backdrop-blur-xs border border-cream-dark dark:border-night-border shadow-xs">
                    {{ $product->category->name }}
                </span>
            @endif
        </div>

        <!-- Dimensions floating pill -->
        @if ($product->dimensions)
            <div class="absolute bottom-3 left-3.5 z-10">
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-mono bg-dark/70 text-cream backdrop-blur-xs">
                    📐 {{ $product->dimensions }}
                </span>
            </div>
        @endif
    </div>

    <!-- Details -->
    <div class="flex flex-1 flex-col justify-between p-5">
        <div>
            <div class="flex items-baseline justify-between gap-2 mb-2">
                <span class="font-mono text-base md:text-lg font-bold text-primary dark:text-accent tracking-tight">
                    {{ $product->formatted_price }}
                </span>
                @if (!$product->is_available)
                    <span
                        class="text-[11px] font-mono text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 px-2 py-0.5 rounded-full border border-rose-200 dark:border-rose-800">
                        Habis
                    </span>
                @endif
            </div>

            <h3
                class="font-heading text-lg font-medium text-dark dark:text-cream line-clamp-1 group-hover:text-primary dark:group-hover:text-accent transition-colors duration-200">
                <a href="{{ route('catalog.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>

            @if (!empty($product->flower_composition))
                <p class="mt-1.5 text-xs text-dark/60 dark:text-cream/70 line-clamp-2 font-body leading-relaxed">
                    <span class="text-secondary-dark dark:text-accent font-medium">Bunga:</span>
                    {{ $product->flower_composition }}
                </p>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-4 pt-3 border-t border-dark/10 dark:border-night-border flex items-center gap-2">
            <a href="{{ route('catalog.show', $product->slug) }}"
                class="flex-1 text-center py-2 px-3 rounded-full text-xs font-medium text-dark dark:text-cream bg-cream dark:bg-night-card hover:bg-cream-dark dark:hover:bg-white/10 transition duration-200 border border-cream-dark dark:border-night-border">
                Lihat Detail
            </a>

            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center justify-center p-2 rounded-full text-cream bg-primary hover:bg-primary-dark transition duration-200 shadow-xs"
                title="Quick Order via WhatsApp">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.477-.15-.678.15-.2.301-.778.98-.954 1.18-.176.2-.351.226-.653.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.2-.301.301-.502.1-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.508-.678-.517-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.482 1.079 2.912 1.23 3.113.15.201 2.124 3.243 5.145 4.549.718.311 1.279.497 1.716.636.721.229 1.377.197 1.895.12.578-.087 1.78-.728 2.031-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z" />
                    <path
                        d="M12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.66 1.433 5.174L2 22l4.981-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.2c-1.577 0-3.056-.441-4.323-1.209l-.31-.188-3.208.899.914-3.123-.206-.328A8.163 8.163 0 013.8 12c0-4.521 3.679-8.2 8.2-8.2 4.521 0 8.2 3.679 8.2 8.2 0 4.521-3.679 8.2-8.2 8.2z" />
                </svg>
            </a>
        </div>
    </div>
</div>
