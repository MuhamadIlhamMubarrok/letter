    <!-- SECTION: KONTAK, STUDIO & PETA INTERAKTIF -->
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Studio Info Card -->
                <div
                    class="lg:col-span-5 p-8 sm:p-10 rounded-[2.5rem] bg-primary dark:bg-night-surface text-cream flex flex-col justify-between shadow-xl border border-primary/20 dark:border-night-border">
                    <div class="space-y-6">
                        <span
                            class="font-mono text-xs uppercase tracking-widest text-accent font-semibold">{{ __('messages.contact_badge') }}</span>
                        <h2 class="font-heading text-3xl font-normal text-cream leading-tight">
                            {{ __('messages.contact_title') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-cream/80 font-body leading-relaxed">
                            {{ __('messages.contact_desc') }}
                        </p>

                        <div class="space-y-3 text-xs text-cream/90 font-body">
                            <p class="flex items-start gap-2.5">
                                <span class="text-accent font-mono text-sm">📍</span>
                                <span>{{ setting('address', 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan, 12180') }}</span>
                            </p>
                            <p class="flex items-center gap-2.5">
                                <span class="text-accent font-mono text-sm">⏰</span>
                                <span>{{ setting('operating_hours', 'Senin - Minggu: 08.00 - 20.00 WIB') }}</span>
                            </p>
                            <p class="flex items-center gap-2.5">
                                <span class="text-accent font-mono text-sm">📱</span>
                                <span class="font-mono">+{{ setting('whatsapp_number', '6285882119900') }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="pt-8">
                        <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Florist Maja Flower, saya ingin bertanya seputar pemesanan buket no 1 di maja.')) }}" target="_blank"
                            class="inline-flex items-center justify-center w-full py-3.5 px-6 rounded-full bg-cream dark:bg-night-card text-dark dark:text-cream hover:bg-cream-light dark:hover:bg-white/10 font-semibold text-xs tracking-wide transition shadow-md border border-dark/10 dark:border-night-border">
                            <span>Chat Langsung dengan Florist Studio</span>
                            <span class="ml-2 font-serif">→</span>
                        </a>
                    </div>
                </div>

                <!-- Interactive Botanical Map -->
                <div
                    class="lg:col-span-7 rounded-[2.5rem] overflow-hidden shadow-xl border border-primary/20 dark:border-night-border bg-cream dark:bg-night-card relative min-h-[360px]">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!4v1792650091400!6m8!1m7!1sMyNMHRn3MpqrqfvEtxeH5w!2m2!1d-6.339728281069731!2d106.3853053077846!3f290.7755!4f0!5f0.7820865974627469"
                        width="100%" height="100%"
                        style="border:0; min-height: 380px;" allowfullscreen=""
                        loading="lazy" referrerpolicy="strict-origin-when-cross-origin"
                        title="Peta Lokasi Studio Maja Flower"></iframe>
                </div>
            </div>
        </div>
    </section>
