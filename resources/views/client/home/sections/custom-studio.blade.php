    <!-- SECTION: BESPOKE CUSTOM STUDIO -->
    <section id="custom-studio" class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-surface dark:bg-night-surface rounded-[2.5rem] border border-primary/15 dark:border-night-border shadow-xl p-8 sm:p-12 lg:p-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-6 space-y-6">
                        <span
                            class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">{{ __('messages.custom_badge') }}</span>
                        <h2
                            class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream leading-tight">
                            {{ __('messages.custom_title') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-dark/75 dark:text-cream/80 font-body leading-relaxed">
                            {{ __('messages.custom_desc') }}
                        </p>

                        <!-- Customization Feature List -->
                        <div class="space-y-3 pt-2 text-xs text-dark/80 dark:text-cream/80 font-body">
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-6 h-6 rounded-full bg-accent/30 dark:bg-accent/20 text-primary dark:text-accent flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                                <div>
                                    <strong>Momen & Konsep Bebas:</strong>
                                    <span class="text-dark/70 dark:text-cream/70">Untuk ulang tahun, kelulusan
                                        (wisuda), anniversary, lamaran, atau sekadar kejutan manis. Kirimkan referensi
                                        foto & nuansa warna favorit Anda.</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-6 h-6 rounded-full bg-accent/30 dark:bg-accent/20 text-primary dark:text-accent flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                                <div>
                                    <strong>Pilihan Jenis Bunga & Ukuran:</strong>
                                    <span class="text-dark/70 dark:text-cream/70">Bunga segar (fresh cut), artificial
                                        premium, atau dried flowers awet dengan pilihan ukuran Small, Medium, atau Large
                                        (Big Size).</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-6 h-6 rounded-full bg-accent/30 dark:bg-accent/20 text-primary dark:text-accent flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                                <div>
                                    <strong>Live Photo Approval & Pantau Resi:</strong>
                                    <span class="text-dark/70 dark:text-cream/70">Setelah DP, kami kirimkan foto/video
                                        preview sebelum pelunasan dan pengiriman. Status pengerjaan dapat dipantau di
                                        halaman Cek Resi Buket.</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex flex-wrap items-center gap-3">
                            @php
                                $customWaMsg = urlencode(
                                    'Halo Florist Maja Flower (Buket No 1 di Maja), saya ingin berkonsultasi mengenai pemesanan Bespoke Custom Bouquet (Momen, Gaya Bunga, dan Ukuran).',
                                );
                            @endphp
                            <x-ui.button href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ $customWaMsg }}"
                                variant="primary" size="lg" target="_blank" class="shadow-lg">
                                <span>Konsultasi Desain via WhatsApp</span>
                                <span class="ml-2 font-serif">→</span>
                            </x-ui.button>
                            <x-ui.button href="{{ route('tracking.index') }}" variant="outline" size="lg">
                                <span>Cek Resi Buket</span>
                            </x-ui.button>
                        </div>
                    </div>

                    <!-- Right Visual Showcase -->
                    <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <img src="{{ asset('catalog-media/lumiere series - 2/lumirere series - 2.png') }}"
                                alt="Custom Bouquet 1" class="rounded-3xl shadow-md object-cover aspect-[3/4]" />
                            <div
                                class="p-4 rounded-2xl bg-cream dark:bg-night-card border border-cream-dark dark:border-night-border text-center">
                                <span class="font-mono text-xs font-semibold text-primary dark:text-accent">Palet Earth
                                    Tone & Sage</span>
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div
                                class="p-4 rounded-2xl bg-cream dark:bg-night-card border border-cream-dark dark:border-night-border text-center">
                                <span class="font-mono text-xs font-semibold text-primary dark:text-accent">Add-on
                                    Fairy Lights & Photo</span>
                            </div>
                            <img src="{{ asset('catalog-media/tedy - rose big/Teddy bloom series - 2.png') }}"
                                alt="Custom Bouquet 2" class="rounded-3xl shadow-md object-cover aspect-[3/4]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
