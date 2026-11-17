@if(isset($isDemo) && $isDemo && !request()->has('embed') && !request()->has('preview_modal') && !request()->has('iframe'))
    <!-- FLOATING DEMO PREVIEW BAR (Ultra-Clean, Responsive & Modern) -->
    <div class="fixed top-2.5 sm:top-3 inset-x-0 z-[70] flex justify-center pointer-events-none px-2.5 sm:px-4 select-none">
        <aside
            x-data="{
                bannerCopied: false,
                copyDemoLink() {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            this.bannerCopied = true;
                            setTimeout(() => this.bannerCopied = false, 2500);
                        });
                    }
                }
            }"
            class="pointer-events-auto inline-flex items-center gap-1.5 sm:gap-2.5 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-full bg-night-surface/95 backdrop-blur-xl border border-night-border text-cream shadow-xl shadow-black/40"
            role="complementary"
            aria-label="Demo Preview Toolbar"
        >
            <!-- 1. Live Indicator & Badge -->
            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-emerald opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-emerald"></span>
                </span>
                <span class="font-mono text-[9px] sm:text-[10px] font-bold text-brand-emerald tracking-wider uppercase whitespace-nowrap">
                    <span class="hidden sm:inline">Contoh Template Live</span>
                    <span class="sm:hidden">Live Demo</span>
                </span>
                <span class="sr-only">Contoh Template Live</span>

                @if(isset($template))
                    <span class="hidden lg:inline text-cream/70 font-sans text-xs font-normal pl-1 max-w-[180px] truncate" title="{{ $template->title() }}">
                        • {{ $template->title() }}
                    </span>
                @endif
            </div>

            <!-- Vertical Separator -->
            <div class="w-px h-3.5 bg-white/15 shrink-0 mx-0.5"></div>

            <!-- 2. Actions -->
            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                <!-- Salin Link -->
                <button
                    type="button"
                    @click="copyDemoLink()"
                    class="px-2 sm:px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/15 active:bg-white/20 font-mono text-[10px] sm:text-[11px] font-medium transition flex items-center gap-1 cursor-pointer border border-white/10 active:scale-95 shrink-0 shadow-xs text-cream hover:text-white"
                    :class="bannerCopied ? 'bg-brand-emerald/20 border-brand-emerald/40 text-brand-emerald' : 'text-cream hover:text-white'"
                    title="Salin Link Contoh"
                >
                    <span x-show="!bannerCopied" class="text-xs">🔗</span>
                    <span x-show="bannerCopied" class="text-brand-emerald font-bold" x-cloak>✓</span>
                    <span x-show="!bannerCopied" class="hidden sm:inline">Salin Link Contoh</span>
                    <span x-show="!bannerCopied" class="sm:hidden">Salin</span>
                    <span x-show="bannerCopied" x-cloak>Tersalin</span>
                    <span class="sr-only">Salin Link Contoh</span>
                </button>

                <!-- Share WA -->
                @php
                    $templateTitle = isset($template) ? $template->title() : 'Maja Flower';
                    $waText = "Halo kak! 🌸\n\nBerikut contoh tampilan interaktif template *" . $templateTitle . "* dari Maja Flower:\n" . url()->current() . "\n\nBisa langsung dibuka di HP untuk mencoba fiturnya ya kak 😊";
                @endphp
                <a
                    href="https://wa.me/?text={{ rawurlencode($waText) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="px-2 sm:px-2.5 py-1 rounded-full bg-brand-emerald hover:brightness-110 active:brightness-95 text-dark font-mono text-[10px] sm:text-[11px] font-bold transition flex items-center gap-1 shadow-sm active:scale-95 shrink-0"
                    title="Bagikan ke WhatsApp"
                >
                    <i class="fa-brands fa-whatsapp text-xs"></i>
                    <span class="hidden sm:inline">Share WA</span>
                    <span class="sm:hidden">WA</span>
                    <span class="sr-only">Share WA</span>
                </a>

                @if(isset($template))
                    @auth
                        <a
                            href="{{ route('admin.digital-stories.create', ['template_key' => $template->value, 'story_type' => $template->storyType()->value]) }}"
                            class="px-2 sm:px-2.5 py-1 rounded-full bg-primary hover:bg-primary-dark text-cream font-mono text-[10px] sm:text-[11px] font-bold transition flex items-center gap-1 shadow-sm border border-white/20 active:scale-95 shrink-0"
                            title="Pilih dan gunakan template ini"
                        >
                            <i class="fa-solid fa-plus text-[9px]"></i>
                            <span>Pilih</span>
                        </a>
                    @endauth
                @endif
            </div>
        </aside>
    </div>
    <!-- Spacer so page content has breathing room -->
    <div class="h-14 sm:h-16 w-full pointer-events-none" aria-hidden="true"></div>
@endif
