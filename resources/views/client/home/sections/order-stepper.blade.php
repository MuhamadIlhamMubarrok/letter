    <!-- SECTION: ALUR PEMESANAN BUKET (4 LANGKAH INTERAKTIF) -->
    <section class="py-16 bg-cream-light/60 dark:bg-night-surface/60 border-y border-dark/10 dark:border-night-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span
                    class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">{{ __('messages.stepper_subtitle') }}</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream mt-1">
                    {{ __('messages.stepper_title') }}
                </h2>
                <p class="text-xs sm:text-sm text-dark/70 dark:text-cream/70 font-body mt-2">
                    {{ __('messages.stepper_desc') }}
                </p>
            </div>

            <x-client.order-stepper />
        </div>
    </section>
