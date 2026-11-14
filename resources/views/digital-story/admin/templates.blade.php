<x-layouts.admin title="Katalog Template Surat & Undangan — Maja Flower">
    <x-slot:header>
        Katalog & Pratinjau Template Desain
    </x-slot:header>

    <div
        x-data="{
            previewModalOpen: false,
            currentPreviewUrl: '',
            currentPreviewTitle: '',
            copiedKey: '',
            filterTheme: 'all',
            openPreview(url, title) {
                const sep = url.includes('?') ? '&' : '?';
                this.currentPreviewUrl = url + sep + 'embed=1';
                this.currentPreviewTitle = title;
                this.previewModalOpen = true;
            },
            closePreview() {
                this.previewModalOpen = false;
                this.currentPreviewUrl = '';
                this.currentPreviewTitle = '';
            },
            copyLink(url, key) {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(() => {
                        this.copiedKey = key;
                        showToast('Link contoh template ' + key + ' berhasil disalin!');
                        setTimeout(() => this.copiedKey = '', 2500);
                    });
                }
            }
        }"
        class="space-y-6 max-w-7xl mx-auto"
    >
        <!-- WELCOME BANNER (BucketFlow Standard) -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-dark via-night-surface to-night-surface border border-primary/40 p-5 sm:p-7 shadow-2xl">
            <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-primary/25 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary/40 text-cream text-xs font-mono font-semibold border border-accent/30">
                            <i class="fa-solid fa-swatchbook text-accent text-[11px]"></i>
                            <span>CMS Template Showcase</span>
                        </span>
                        <span class="text-xs font-mono text-accent/80 flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-black/20 border border-white/5">
                            <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i>
                            <span>{{ count($loveLetterTemplates) + count($weddingTemplates) }} Template Interaktif Siap Pakai</span>
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-heading font-bold text-cream tracking-wide">Katalog & Pratinjau Template</h2>
                    <p class="text-xs sm:text-sm text-neutral-300 mt-1 max-w-xl">
                        Buka simulasi tampilan smartphone untuk melihat animasi amplop, musik romantis, rute Google Maps, dan buku tamu RSVP. Bagikan link langsung ke calon pemesan buket.
                    </p>
                </div>
                <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                    <a
                        href="{{ route('admin.digital-stories.create') }}"
                        class="touch-target flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-semibold text-xs sm:text-sm shadow-lg shadow-primary/40 transition active:scale-95"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <span>Input Pesanan Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- SHARE CALLOUT BANNER -->
        <div class="p-4 sm:p-5 rounded-2xl bg-night-surface border border-border-subtle flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl">
            <div class="flex items-start sm:items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/30 border border-primary/50 text-accent flex items-center justify-center shrink-0 text-base">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div>
                    <h3 class="font-heading text-sm font-bold text-cream">Cara Membagikan Contoh Desain ke Pelanggan Florist</h3>
                    <p class="text-xs text-neutral-300 mt-0.5 leading-relaxed">
                        Klik tombol <strong><i class="fa-brands fa-whatsapp text-emerald-400"></i> Share WA</strong> atau <strong><i class="fa-solid fa-link text-accent"></i> Salin Link</strong> pada kartu template. Pelanggan dapat membuka link tersebut di smartphone mereka untuk mencoba fitur interaktif secara live!
                    </p>
                </div>
            </div>
        </div>

        <!-- FILTER TAB BY TEMA STYLE (Tema Lucu, Tema Klasik, Tema Elegan) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            <button
                type="button"
                @click="filterTheme = 'all'"
                class="touch-target px-3.5 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center gap-1.5 cursor-pointer"
                :class="filterTheme === 'all' ? 'bg-primary text-cream shadow-md shadow-primary/30 border border-primary' : 'bg-night-surface text-neutral-400 hover:text-cream border border-border-subtle'"
            >
                <i class="fa-solid fa-shapes"></i>
                <span>Semua Desain ({{ count($loveLetterTemplates) + count($weddingTemplates) }})</span>
            </button>
            <button
                type="button"
                @click="filterTheme = 'lucu'"
                class="touch-target px-3.5 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center gap-1.5 cursor-pointer"
                :class="filterTheme === 'lucu' ? 'bg-primary text-cream shadow-md shadow-primary/30 border border-primary' : 'bg-night-surface text-neutral-400 hover:text-cream border border-border-subtle'"
            >
                <span>💌</span>
                <span>Tema Lucu &amp; Gemas</span>
            </button>
            <button
                type="button"
                @click="filterTheme = 'klasik'"
                class="touch-target px-3.5 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center gap-1.5 cursor-pointer"
                :class="filterTheme === 'klasik' ? 'bg-primary text-cream shadow-md shadow-primary/30 border border-primary' : 'bg-night-surface text-neutral-400 hover:text-cream border border-border-subtle'"
            >
                <span>📜</span>
                <span>Tema Klasik &amp; Botanical</span>
            </button>
            <button
                type="button"
                @click="filterTheme = 'elegan'"
                class="touch-target px-3.5 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center gap-1.5 cursor-pointer"
                :class="filterTheme === 'elegan' ? 'bg-primary text-cream shadow-md shadow-primary/30 border border-primary' : 'bg-night-surface text-neutral-400 hover:text-cream border border-border-subtle'"
            >
                <span>✨</span>
                <span>Tema Elegan &amp; Mewah</span>
            </button>
        </div>

        <!-- 1. KATEGORI TEMPLATE SURAT CINTA (LOVE LETTER) -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-primary/30 text-accent border border-primary/40 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <div>
                        <h2 class="font-heading text-lg font-bold text-cream">Template Surat Cinta (Love Letter)</h2>
                        <p class="text-xs text-neutral-400">Untuk anniversary, ucapan romantis hari jadian, ulang tahun, dan ungkapan isi hati.</p>
                    </div>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-primary/30 text-accent border border-primary/40 font-semibold">
                    {{ count($loveLetterTemplates) }} Tema Romantis
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                @foreach($loveLetterTemplates as $tpl)
                    @php
                        $demoUrl = route('story.public.preview', ['templateKey' => $tpl->value]);
                        $waText = "Halo kak! 🌸\n\nBerikut contoh tampilan interaktif template *" . $tpl->title() . "* dari Maja Flower:\n" . $demoUrl . "\n\nBisa langsung dibuka di HP untuk melihat animasi surat, musik romantis, dan galeri foto polaroidnya ya kak 😊";
                    @endphp
                    <div x-show="filterTheme === 'all' || filterTheme === '{{ $tpl->themeStyle() }}'" class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl hover:border-secondary/40 transition flex flex-col justify-between group">
                        <div>
                            <!-- Header Meta -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 rounded-lg bg-primary/25 text-cream border border-primary/40 font-mono text-[11px] font-semibold">
                                    {{ $tpl->badge() }}
                                </span>
                                <span class="font-mono text-[10px] text-neutral-400">Key: {{ $tpl->value }}</span>
                            </div>

                            <h3 class="font-heading text-base font-bold text-cream group-hover:text-accent transition-colors">
                                {{ $tpl->title() }}
                            </h3>
                            <p class="text-xs text-neutral-300 mt-1.5 leading-relaxed">
                                {{ $tpl->description() }}
                            </p>

                            <!-- Features List -->
                            <div class="mt-4 pt-3 border-t border-border-subtle flex flex-wrap gap-1.5">
                                @foreach($tpl->features() as $feat)
                                    <span class="px-2.5 py-1 rounded-lg bg-night-bg text-neutral-300 text-[10px] font-mono border border-border-subtle">
                                        <i class="fa-solid fa-check text-accent text-[9px] mr-1"></i> {{ $feat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Toolbar -->
                        <div class="mt-5 pt-4 border-t border-border-subtle space-y-2.5">
                            <!-- Showcase Buttons -->
                            <div class="grid grid-cols-3 gap-2">
                                <!-- Pratinjau Modal -->
                                <button
                                    type="button"
                                    @click="openPreview('{{ $demoUrl }}', '{{ $tpl->title() }}')"
                                    class="py-2 px-2.5 rounded-xl bg-night-bg hover:bg-white/10 border border-border-subtle text-neutral-300 hover:text-cream font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                                    title="Lihat simulasi smartphone"
                                >
                                    <i class="fa-solid fa-mobile-screen text-accent"></i>
                                    <span>Pratinjau</span>
                                </button>

                                <!-- Salin Link Share -->
                                <button
                                    type="button"
                                    @click="copyLink('{{ $demoUrl }}', '{{ $tpl->value }}')"
                                    class="py-2 px-2.5 rounded-xl bg-night-bg hover:bg-white/10 border border-border-subtle text-neutral-300 hover:text-cream font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                                    title="Salin link contoh untuk dibagikan ke client"
                                >
                                    <i class="fa-solid fa-link text-neutral-400" x-show="copiedKey !== '{{ $tpl->value }}'"></i>
                                    <i class="fa-solid fa-check text-accent font-bold" x-show="copiedKey === '{{ $tpl->value }}'"></i>
                                    <span x-text="copiedKey === '{{ $tpl->value }}' ? 'Tersalin' : 'Salin Link'"></span>
                                </button>

                                <!-- Share ke WhatsApp Client -->
                                <a
                                    href="https://wa.me/?text={{ rawurlencode($waText) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="py-2 px-2.5 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 border border-emerald-700/60 text-emerald-300 font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 active:scale-95"
                                    title="Kirim contoh template via WhatsApp"
                                >
                                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                    <span>Share WA</span>
                                </a>
                            </div>

                            <!-- Primary CTA: Gunakan Template Ini di CMS -->
                            <div class="flex items-center justify-between gap-2 pt-1">
                                <a
                                    href="{{ $demoUrl }}"
                                    target="_blank"
                                    class="text-[11px] font-mono text-neutral-400 hover:text-accent transition flex items-center gap-1"
                                    title="Buka pratinjau penuh di tab baru"
                                >
                                    <span>Buka Tab Baru</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>

                                <a
                                    href="{{ route('admin.digital-stories.create', ['template_key' => $tpl->value, 'story_type' => 'love_letter']) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-semibold transition shadow-xs active:scale-95"
                                >
                                    <span>Pilih Template</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 2. KATEGORI TEMPLATE UNDANGAN PERNIKAHAN (WEDDING INVITATION) -->
        <section class="space-y-4 pt-6 border-t border-border-subtle">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-secondary/20 text-accent border border-secondary/40 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-ring"></i>
                    </div>
                    <div>
                        <h2 class="font-heading text-lg font-bold text-cream">Template Undangan Pernikahan (Wedding Invitation)</h2>
                        <p class="text-xs text-neutral-400">Dilengkapi countdown akad & resepsi, Google Maps rute, galeri pre-wedding, dan buku tamu RSVP.</p>
                    </div>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-secondary/20 text-accent border border-secondary/40 font-semibold">
                    {{ count($weddingTemplates) }} Tema Undangan Pernikahan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                @foreach($weddingTemplates as $tpl)
                    @php
                        $demoUrl = route('story.public.preview', ['templateKey' => $tpl->value]);
                        $waText = "Halo kak! 💍\n\nBerikut contoh tampilan interaktif undangan nikah online *" . $tpl->title() . "* dari Maja Flower:\n" . $demoUrl . "\n\nBisa langsung dibuka di HP untuk melihat hitung mundur akad, rute Google Maps, galeri foto, alunan musik, dan buku tamu RSVP ya kak 😊";
                    @endphp
                    <div x-show="filterTheme === 'all' || filterTheme === '{{ $tpl->themeStyle() }}'" class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl hover:border-secondary/40 transition flex flex-col justify-between group">
                        <div>
                            <!-- Header Meta -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 rounded-lg bg-secondary/20 text-accent border border-secondary/40 font-mono text-[11px] font-semibold">
                                    {{ $tpl->badge() }}
                                </span>
                                <span class="font-mono text-[10px] text-neutral-400">Key: {{ $tpl->value }}</span>
                            </div>

                            <h3 class="font-heading text-base font-bold text-cream group-hover:text-accent transition-colors">
                                {{ $tpl->title() }}
                            </h3>
                            <p class="text-xs text-neutral-300 mt-1.5 leading-relaxed">
                                {{ $tpl->description() }}
                            </p>

                            <!-- Features List -->
                            <div class="mt-4 pt-3 border-t border-border-subtle flex flex-wrap gap-1.5">
                                @foreach($tpl->features() as $feat)
                                    <span class="px-2.5 py-1 rounded-lg bg-night-bg text-neutral-300 text-[10px] font-mono border border-border-subtle">
                                        <i class="fa-solid fa-check text-accent text-[9px] mr-1"></i> {{ $feat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Toolbar -->
                        <div class="mt-5 pt-4 border-t border-border-subtle space-y-2.5">
                            <!-- Showcase Buttons -->
                            <div class="grid grid-cols-3 gap-2">
                                <!-- Pratinjau Modal -->
                                <button
                                    type="button"
                                    @click="openPreview('{{ $demoUrl }}', '{{ $tpl->title() }}')"
                                    class="py-2 px-2.5 rounded-xl bg-night-bg hover:bg-white/10 border border-border-subtle text-neutral-300 hover:text-cream font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                                    title="Lihat simulasi smartphone"
                                >
                                    <i class="fa-solid fa-mobile-screen text-accent"></i>
                                    <span>Pratinjau</span>
                                </button>

                                <!-- Salin Link Share -->
                                <button
                                    type="button"
                                    @click="copyLink('{{ $demoUrl }}', '{{ $tpl->value }}')"
                                    class="py-2 px-2.5 rounded-xl bg-night-bg hover:bg-white/10 border border-border-subtle text-neutral-300 hover:text-cream font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                                    title="Salin link contoh untuk dibagikan ke client"
                                >
                                    <i class="fa-solid fa-link text-neutral-400" x-show="copiedKey !== '{{ $tpl->value }}'"></i>
                                    <i class="fa-solid fa-check text-accent font-bold" x-show="copiedKey === '{{ $tpl->value }}'"></i>
                                    <span x-text="copiedKey === '{{ $tpl->value }}' ? 'Tersalin' : 'Salin Link'"></span>
                                </button>

                                <!-- Share ke WhatsApp Client -->
                                <a
                                    href="https://wa.me/?text={{ rawurlencode($waText) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="py-2 px-2.5 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 border border-emerald-700/60 text-emerald-300 font-mono text-xs font-semibold transition flex items-center justify-center gap-1.5 active:scale-95"
                                    title="Kirim contoh template via WhatsApp"
                                >
                                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                    <span>Share WA</span>
                                </a>
                            </div>

                            <!-- Primary CTA: Gunakan Template Ini di CMS -->
                            <div class="flex items-center justify-between gap-2 pt-1">
                                <a
                                    href="{{ $demoUrl }}"
                                    target="_blank"
                                    class="text-[11px] font-mono text-neutral-400 hover:text-accent transition flex items-center gap-1"
                                    title="Buka pratinjau penuh di tab baru"
                                >
                                    <span>Buka Tab Baru</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>

                                <a
                                    href="{{ route('admin.digital-stories.create', ['template_key' => $tpl->value, 'story_type' => 'wedding_invitation']) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-semibold transition shadow-xs active:scale-95"
                                >
                                    <span>Pilih Template</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 3. INTERACTIVE FLAGSHIP SMARTPHONE PREVIEW MODAL -->
        <div
            x-show="previewModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/85 backdrop-blur-md"
            role="dialog"
            aria-modal="true"
            @keydown.escape.window="closePreview()"
        >
            <!-- Phone Wrapper & Floating Bar -->
            <div
                @click.away="closePreview()"
                x-show="previewModalOpen"
                x-transition:enter="transition duration-300 ease-out transform"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition duration-200 ease-in transform"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-95 opacity-0"
                class="relative flex flex-col items-center justify-center max-h-[96vh] select-none"
            >
                <!-- External Floating Header Above Phone -->
                <div class="flex items-center justify-between w-full max-w-[390px] mb-2 px-2 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                        <span class="font-heading font-bold text-cream truncate max-w-[200px]" x-text="currentPreviewTitle"></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <a
                            :href="currentPreviewUrl.replace('&embed=1','').replace('?embed=1','')"
                            target="_blank"
                            class="px-2.5 py-1 rounded-full bg-night-surface hover:bg-white/15 text-cream border border-border-subtle text-[11px] font-mono transition flex items-center gap-1"
                            title="Buka di tab browser baru"
                        >
                            <span>Tab Baru</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                        <button
                            @click="closePreview()"
                            type="button"
                            class="w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 text-cream flex items-center justify-center font-bold transition cursor-pointer"
                            title="Tutup (ESC)"
                        >
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Flagship Smartphone Chassis (iPhone 15 Pro Ratio) -->
                <div class="relative w-[340px] sm:w-[385px] h-[680px] sm:h-[720px] max-h-[82vh] bg-[#0d140d] border-[6px] border-[#223322] rounded-[3.2rem] shadow-[0_25px_80px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.08)] p-2.5 flex flex-col shrink-0">
                    <!-- Dynamic Island Notch -->
                    <div class="absolute top-3.5 inset-x-0 mx-auto w-24 h-4 bg-black rounded-full z-20 flex items-center justify-between px-3 pointer-events-none shadow-sm">
                        <div class="w-2 h-2 rounded-full bg-[#1c241c] border border-white/10"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-[#111] ring-1 ring-white/10"></div>
                    </div>

                    <!-- Screen Viewport -->
                    <div class="relative flex-1 w-full bg-[#FAF7F2] rounded-[2.6rem] overflow-hidden shadow-inner">
                        <template x-if="previewModalOpen">
                            <iframe
                                :src="currentPreviewUrl"
                                class="w-full h-full border-0 block bg-[#FAF7F2]"
                                loading="eager"
                            ></iframe>
                        </template>
                    </div>

                    <!-- Phone Home Indicator Bar -->
                    <div class="w-28 h-1 rounded-full bg-white/30 mx-auto mt-2 shrink-0"></div>
                </div>

                <!-- External Floating Footer Below Phone -->
                <div class="flex items-center justify-between w-full max-w-[390px] mt-2 px-2 text-[11px] font-mono text-neutral-400">
                    <button
                        type="button"
                        @click="copyLink(currentPreviewUrl.replace('&embed=1','').replace('?embed=1',''), currentPreviewTitle)"
                        class="text-accent hover:text-cream transition flex items-center gap-1.5 cursor-pointer"
                    >
                        <i class="fa-solid fa-link text-[10px]"></i>
                        <span>Salin Link Preview</span>
                    </button>
                    <span class="text-neutral-500">Simulasi Smartphone</span>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>
