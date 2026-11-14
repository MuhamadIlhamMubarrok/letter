    <!-- SECTION: REKOMENDASI BUKET SESUAI MOMEN & EVENT SPESIAL -->
    <section id="rekomendasi-event"
        class="py-16 md:py-24 bg-surface dark:bg-night-surface text-dark dark:text-cream relative overflow-hidden border-y border-dark/10 dark:border-night-border transition-colors">
        <!-- Anchor for legacy link compatibility -->
        <span id="filosofi" class="absolute -top-24"></span>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-primary/10 dark:bg-primary/20 text-primary dark:text-accent font-mono text-xs font-bold uppercase tracking-wider mb-2">
                    <span>💡</span>
                    <span>Panduan Florist • {{ __('messages.philosophy_badge') }}</span>
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-bold text-dark dark:text-cream mt-1 tracking-tight">
                    Rekomendasi Buket untuk Momen Spesial Anda
                </h2>
                <p class="text-xs sm:text-sm text-dark/70 dark:text-cream/70 font-body mt-3 leading-relaxed max-w-2xl mx-auto">
                    Bingung memilih rangkaian yang tepat? Florist kami mengurasi buket terbaik untuk setiap momen berharga—lengkap dengan alasan rekomendasi, makna bunga, dan harga transparan.
                </p>
            </div>

            <!-- 4 Event Recommendation Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($eventRecommendations as $rec)
                    <div class="bg-cream-light/60 dark:bg-night-card rounded-3xl border border-primary/15 dark:border-night-border overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Event Image & Badges -->
                            <div class="relative aspect-[4/3] overflow-hidden bg-cream-dark/30 dark:bg-white/5">
                                <img
                                    src="{{ $rec['image'] }}"
                                    alt="{{ $rec['product_name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-dark/75 via-transparent to-transparent"></div>
                                
                                <!-- Top Event Badge -->
                                <div class="absolute top-3 left-3 bg-surface/90 dark:bg-night-surface/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono font-bold text-primary dark:text-accent shadow-xs">
                                    {{ $rec['badge'] }}
                                </div>

                                <!-- Price Badge -->
                                <div class="absolute top-3 right-3 bg-primary text-cream px-2.5 py-1 rounded-full text-[11px] font-mono font-bold shadow-md">
                                    {{ $rec['price_label'] }}
                                </div>

                                <!-- Bottom Image Overlay -->
                                <div class="absolute bottom-2.5 left-3 right-3 text-cream">
                                    <h4 class="font-heading text-base font-bold leading-tight">{{ $rec['event_name'] }}</h4>
                                    <p class="text-[10px] font-mono text-cream/80">{{ $rec['product_name'] }}</p>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 space-y-4">
                                <!-- Flowers composition -->
                                <div class="flex items-center gap-1.5 text-xs text-dark/70 dark:text-cream/70 font-mono">
                                    <span class="text-sm">🌸</span>
                                    <span class="truncate">{{ $rec['flowers'] }}</span>
                                </div>

                                <!-- Florist Reason Box -->
                                <div class="p-3.5 rounded-2xl bg-white dark:bg-white/5 border border-primary/10 dark:border-white/10 space-y-1">
                                    <span class="text-[10px] font-mono uppercase tracking-wider text-primary dark:text-accent font-bold block">
                                        ✨ Alasan Florist:
                                    </span>
                                    <p class="text-xs text-dark/80 dark:text-cream/80 font-body leading-relaxed">
                                        {{ $rec['reason'] }}
                                    </p>
                                </div>

                                <!-- Suitable For Tags -->
                                <div class="space-y-1">
                                    <span class="text-[10px] font-mono uppercase tracking-wider text-dark/50 dark:text-cream/50 block">Cocok Untuk:</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($rec['suitable_for'] as $tag)
                                            <span class="px-2 py-0.5 rounded-md bg-cream-dark/50 dark:bg-white/10 text-dark/80 dark:text-cream/80 text-[10px] font-mono">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Footer -->
                        <div class="p-5 pt-0 space-y-2">
                            <a
                                href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ rawurlencode($rec['wa_text']) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-dark text-cream text-xs font-mono font-bold flex items-center justify-center gap-2 shadow-sm transition active:scale-95"
                            >
                                <span>💬 Pesan Rekomendasi Ini</span>
                            </a>
                            <a
                                href="{{ route('catalog.show', $rec['product_slug']) }}"
                                class="w-full py-2 px-4 rounded-xl bg-transparent hover:bg-cream dark:hover:bg-white/5 text-dark/70 dark:text-cream/70 text-xs font-mono text-center block transition"
                            >
                                Lihat Spesifikasi & Foto Lain →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- SUB-SECTION: MAKNA BUNGA DI BALIK RANGKAIAN KAMI (THE LANGUAGE OF FLOWERS) -->
            <div class="mt-16 pt-12 border-t border-dark/10 dark:border-night-border">
                <div class="text-center max-w-2xl mx-auto mb-8">
                    <span class="font-mono text-xs uppercase tracking-widest text-primary dark:text-accent font-semibold">
                        Filosofi Rangkaian Bunga
                    </span>
                    <h3 class="font-heading text-2xl sm:text-3xl font-bold text-dark dark:text-cream mt-1">
                        Makna di Balik Setiap Kelopak Bunga
                    </h3>
                    <p class="text-xs text-dark/60 dark:text-cream/60 font-body mt-1.5">
                        Setiap tangkai bunga yang kami pilih memiliki simbol rasa yang mendalam untuk menyempurnakan pesan Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse ($philosophies ?? [] as $phil)
                        <div class="p-4 rounded-2xl bg-white/70 dark:bg-night-card/70 border border-primary/10 dark:border-night-border shadow-2xs hover:shadow-sm transition">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl shrink-0 p-2 rounded-xl bg-cream-light dark:bg-white/5">{{ $phil->emoji_or_icon }}</span>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-heading text-sm font-bold text-dark dark:text-cream truncate">{{ $phil->flower_name }}</h4>
                                    @if ($phil->scientific_name)
                                        <span class="font-mono text-[9px] italic text-dark/40 dark:text-cream/40 block">{{ $phil->scientific_name }}</span>
                                    @endif
                                    <span class="font-mono text-[10px] text-primary dark:text-accent font-semibold block mt-0.5">Makna: {{ $phil->meaning }}</span>
                                    <p class="mt-1 text-[11px] text-dark/70 dark:text-cream/70 font-body line-clamp-2">
                                        {{ $phil->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-6 text-dark/50 dark:text-cream/50 font-mono text-xs">
                            🌸 Filosofi rangkaian bunga sedang diperbarui oleh florist studio.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
