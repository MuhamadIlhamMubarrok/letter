    <!-- SECTION: MOMEN BAHAGIA (TESTIMONIAL & REAL POLAROID PHOTOS) -->
    <section
        class="py-16 md:py-24 bg-cream-light/60 dark:bg-night-surface/60 border-t border-dark/10 dark:border-night-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span
                    class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">{{ __('messages.testi_badge') }}</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream mt-1">
                    {{ __('messages.testi_title') }}
                </h2>
                <p class="text-xs sm:text-sm text-dark/70 dark:text-cream/70 font-body mt-2">
                    {{ __('messages.testi_desc') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $tiltRotations = ['rotate-[-1.5deg]', 'rotate-[1.5deg]', 'rotate-[-1deg]', 'rotate-[2deg]', 'rotate-[-2deg]'];
                @endphp
                @forelse ($stories as $idx => $story)
                    @php
                        $rotation = $tiltRotations[$idx % count($tiltRotations)];
                    @endphp
                    <div
                        class="bg-surface dark:bg-night-card p-4 pb-6 rounded-2xl shadow-md border border-dark/10 dark:border-night-border {{ $rotation }} hover:rotate-0 transition-transform duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative mb-4">
                                <img src="{{ $story->image_url }}"
                                    alt="Testimoni {{ $story->customer_name }}" class="w-full aspect-square object-cover rounded-xl shadow-xs" />
                                <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-3 bg-amber-100/90 dark:bg-amber-900/60 border border-amber-200 dark:border-amber-700/60 rounded-xs rotate-[-3deg] shadow-2xs"></div>
                            </div>
                            <div class="flex items-center gap-1 mb-2 text-amber-500 text-xs">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= ($story->rating ?? 5) ? '★' : '☆' }}</span>
                                @endfor
                                <span class="font-mono text-[10px] text-dark/40 dark:text-cream/40 ml-1">({{ number_format($story->rating ?? 5, 1) }})</span>
                            </div>
                            <p class="font-body text-xs text-dark/80 dark:text-cream/80 italic leading-relaxed">
                                "{{ $story->story }}"
                            </p>
                        </div>
                        <div
                            class="mt-4 pt-3 border-t border-dark/10 dark:border-night-border flex items-center justify-between">
                            <span class="font-heading text-sm font-bold text-primary dark:text-accent">{{ $story->customer_name }}</span>
                            <span class="font-mono text-[10px] text-dark/50 dark:text-cream/50">{{ $story->event_title }}</span>
                        </div>
                    </div>
                @empty
                    <!-- Fallback default cards if table is empty -->
                    <div
                        class="bg-surface dark:bg-night-card p-4 pb-6 rounded-2xl shadow-md border border-dark/10 dark:border-night-border rotate-[-1.5deg] hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('catalog-media/lumiere series - 1/lumirere series - 1.png') }}"
                            alt="Testimoni Clara" class="w-full aspect-square object-cover rounded-xl mb-4" />
                        <p class="font-body text-xs text-dark/80 dark:text-cream/80 italic leading-relaxed">
                            "Buket bunganya wangi sekali dan wrapping-nya sangat rapi! Fitur approval foto sebelum kirim benar-benar bikin tenang karena hasilnya persis seperti ekspektasi."
                        </p>
                        <div
                            class="mt-3 pt-3 border-t border-dark/10 dark:border-night-border flex items-center justify-between">
                            <span class="font-heading text-sm font-bold text-primary dark:text-accent">Clara & Rangga</span>
                            <span class="font-mono text-[10px] text-dark/50 dark:text-cream/50">Wisuda UI</span>
                        </div>
                    </div>

                    <div
                        class="bg-surface dark:bg-night-card p-4 pb-6 rounded-2xl shadow-md border border-dark/10 dark:border-night-border rotate-[1.5deg] hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('catalog-media/lumiere series - 3/lumirere series - 3.png') }}"
                            alt="Testimoni Kevin" class="w-full aspect-square object-cover rounded-xl mb-4" />
                        <p class="font-body text-xs text-dark/80 dark:text-cream/80 italic leading-relaxed">
                            "Pesan buket custom buat anniversary istri. Florist Maja ramah banget waktu konsultasi di WA, bahkan dibantu pilihin kartu ucapan beraksara puitis. Istri terharu!"
                        </p>
                        <div
                            class="mt-3 pt-3 border-t border-dark/10 dark:border-night-border flex items-center justify-between">
                            <span class="font-heading text-sm font-bold text-primary dark:text-accent">Kevin Pratama</span>
                            <span class="font-mono text-[10px] text-dark/50 dark:text-cream/50">Anniversary 4th</span>
                        </div>
                    </div>

                    <div
                        class="bg-surface dark:bg-night-card p-4 pb-6 rounded-2xl shadow-md border border-dark/10 dark:border-night-border rotate-[-1deg] hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('catalog-media/tedy series - 1/Teddy bloom series - 1.png') }}"
                            alt="Testimoni Syifa" class="w-full aspect-square object-cover rounded-xl mb-4" />
                        <p class="font-body text-xs text-dark/80 dark:text-cream/80 italic leading-relaxed">
                            "Sunflower bouquet-nya segar banget tahan hampir 8 hari di vas! Resi live tracking-nya juga informatif, kurir sameday tiba tepat waktu sebelum acara mulai."
                        </p>
                        <div
                            class="mt-3 pt-3 border-t border-dark/10 dark:border-night-border flex items-center justify-between">
                            <span class="font-heading text-sm font-bold text-primary dark:text-accent">Syifa Aulia</span>
                            <span class="font-mono text-[10px] text-dark/50 dark:text-cream/50">Graduation ITB</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
