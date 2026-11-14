    <!-- SECTION: KATALOG PRODUK PILIHAN (CURATED SIGNATURE) -->
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span
                        class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">{{ __('messages.curated_subtitle') }}</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream mt-1">
                        {{ __('messages.curated_title') }}
                    </h2>
                    <p class="text-xs sm:text-sm text-dark/70 dark:text-cream/70 font-body mt-2 max-w-xl">
                        {{ __('messages.curated_desc') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <x-ui.button href="{{ route('catalog.index') }}" variant="outline" size="sm">
                        <span>{{ __('messages.view_all') }} ({{ count($bestsellers) }}+)</span>
                        <span class="ml-1 font-serif">→</span>
                    </x-ui.button>
                </div>
            </div>

            <!-- Products Grid: 2 cols on mobile, 4 cols on desktop -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($bestsellers as $product)
                    <x-client.product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
