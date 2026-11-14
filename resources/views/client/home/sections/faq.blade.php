    <!-- SECTION: FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section id="faq" x-data="{ activeFaq: 0 }" class="py-16 md:py-24 bg-cream-light/40 dark:bg-night-surface/40 border-t border-dark/10 dark:border-night-border">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="font-mono text-xs uppercase tracking-widest text-primary dark:text-accent font-semibold">Tanya Jawab Botani</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-normal text-dark dark:text-cream mt-1">
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h2>
                <p class="text-xs sm:text-sm text-dark/70 dark:text-cream/70 font-body mt-2 leading-relaxed">
                    Jawaban transparan seputar jaminan kesegaran bunga, sameday delivery se-Jabodetabek, dan sistem live photo approval sebelum buket diberangkatkan.
                </p>
            </div>

            <!-- Accordion List -->
            <div class="space-y-3.5">
                @forelse ($faqs ?? [] as $index => $faq)
                    <div
                        class="rounded-3xl border border-primary/15 dark:border-night-border bg-white/80 dark:bg-night-card/80 backdrop-blur-md overflow-hidden transition shadow-2xs"
                    >
                        <!-- Question Header -->
                        <button
                            type="button"
                            @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})"
                            class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 cursor-pointer hover:bg-primary/5 dark:hover:bg-white/5 transition"
                            :aria-expanded="activeFaq === {{ $index }}"
                        >
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-primary/10 text-primary dark:text-accent shrink-0">
                                    {{ $faq->category }}
                                </span>
                                <h3 class="font-heading text-sm sm:text-base font-semibold text-dark dark:text-cream truncate">
                                    {{ $faq->question }}
                                </h3>
                            </div>

                            <span
                                :class="{ 'rotate-180': activeFaq === {{ $index }} }"
                                class="w-8 h-8 rounded-full bg-cream-light dark:bg-night-surface border border-dark/10 dark:border-night-border flex items-center justify-center shrink-0 text-dark dark:text-cream transition-transform duration-200"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>

                        <!-- Answer Body -->
                        <div
                            x-show="activeFaq === {{ $index }}"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="px-5 sm:px-6 pb-6 pt-1 border-t border-dark/5 dark:border-night-border/40"
                        >
                            <p class="text-xs sm:text-sm text-dark/75 dark:text-cream/80 font-body leading-relaxed">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs font-mono text-dark/50">
                        Pertanyaan FAQ sedang disiapkan oleh atelier.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
