<header x-data="{
    isScrolled: false,
    mobileMenuOpen: false,
    catalogDropdown: false,
    quickResiOpen: false,
    mobileCatalogOpen: false,
    resiInput: '',
    submitResi() {
        if (this.resiInput.trim()) {
            window.location.href = '{{ route('tracking.index') }}?code=' + encodeURIComponent(this.resiInput.trim());
        }
    }
}" @scroll.window="isScrolled = (window.pageYOffset > 15)"
    @keydown.escape="mobileMenuOpen = false; catalogDropdown = false; quickResiOpen = false"
    class="sticky top-0 z-40 w-full transition-all duration-300 pointer-events-none">
    <!-- TOP ANNOUNCEMENT STRIP (Collapsible on deep scroll) -->
    @if (setting('announcement_active', '1') == '1')
    <div x-show="!isScrolled" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="pointer-events-auto bg-primary dark:bg-night-surface text-cream py-1.5 px-4 text-center text-[11px] font-mono tracking-wide border-b border-primary-dark/30 dark:border-night-border transition-colors flex items-center justify-center gap-2.5 sm:gap-4 flex-wrap">
        <div class="flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-accent animate-ping"></span>
            <span class="font-semibold">{{ setting('announcement_text', __('messages.announcement')) }}</span>
        </div>
        <div class="hidden md:flex items-center gap-3 text-cream/80">
            <span>•</span>
            <span class="flex items-center gap-1">
                <span>⏱️</span>
                <span>{{ setting('operating_hours', __('messages.nav_operating_hours')) }}</span>
            </span>
            <span>•</span>
            <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Florist Maja Flower, saya ingin bertanya ketersediaan buket hari ini.')) }}"
                target="_blank" class="font-bold underline hover:text-accent transition inline-flex items-center gap-1">
                <span>{{ __('messages.contact_florist') }}</span>
            </a>
        </div>
    </div>
    @endif

    <!-- MAIN RESPONSIVE NAVBAR: FLUSH & GROUNDED ON MOBILE, FLOATING BOTANICAL ISLAND ON DESKTOP -->
    <div
        class="pointer-events-auto w-full sm:max-w-7xl sm:mx-auto px-0 sm:px-6 lg:px-8 pt-0 sm:pt-3.5 pb-0 sm:pb-2 transition-all duration-300">
        <div :class="isScrolled
            ?
            'bg-white/95 dark:bg-night-surface/95 backdrop-blur-2xl border-b sm:border border-primary/20 dark:border-accent/25 shadow-md sm:shadow-xl shadow-primary/10 py-2.5 sm:py-2.5 sm:ring-1 sm:ring-primary/10 dark:sm:ring-accent/15' :
            'bg-cream/95 dark:bg-night-surface/95 backdrop-blur-xl border-b sm:border border-dark/10 dark:border-white/10 shadow-xs sm:shadow-lg shadow-primary/5 py-2.5 sm:py-3.5'"
            class="w-full rounded-none sm:rounded-full px-4 sm:px-6 transition-all duration-300 flex items-center justify-between gap-3 sm:gap-4 relative">
            <!-- 1. LEFT ZONE: ATELIER BRAND IDENTITY & LIVE STATUS -->
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" title="Maja Flower - Beranda">
                    <!-- Botanical Flower Logo with Hover Micro-Spin -->
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-cream-light/95 dark:bg-night-card p-1.5 flex items-center justify-center shadow-xs group-hover:rotate-12 group-hover:scale-105 transition-all duration-300 border border-primary/20 dark:border-accent/30 shrink-0">
                        <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo"
                            class="h-full w-auto object-contain">
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-heading text-xl sm:text-2xl font-bold tracking-tight text-primary dark:text-accent leading-none group-hover:text-primary-dark transition-colors">
                                maja flower
                            </span>
                            <!-- Live Status Indicator Pill (Desktop) -->
                            {{-- <span
                                class="hidden xl:inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-[10px] font-mono text-emerald-800 dark:text-emerald-300 font-semibold"
                                title="Atelier beroperasi sekarang">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>{{ __('messages.nav_atelier_open') }}</span>
                            </span> --}}
                        </div>
                        <span
                            class="font-mono text-[9px] sm:text-[10px] tracking-widest uppercase text-secondary-dark dark:text-accent/90 mt-0.5 font-medium">
                            Buket No 1 di Maja
                        </span>
                    </div>
                </a>
            </div>

            <!-- 2. CENTER ZONE: CURATED FLOATING PILL NAVIGATION DECK (Desktop) -->
            <nav
                class="hidden lg:flex items-center bg-cream-dark/30 dark:bg-night-card/80 border border-dark/10 dark:border-white/10 p-1 rounded-full text-xs font-medium shadow-2xs backdrop-blur-md">
                <!-- Beranda -->
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-full transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('home') && !request()->has('code') ? 'bg-primary text-cream font-semibold shadow-xs' : 'text-dark/80 dark:text-cream/80 hover:text-primary dark:hover:text-accent hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <span>{{ __('messages.nav_home') }}</span>
                </a>

                <!-- Katalog Buket with Interactive Mega-Flyout -->
                <div class="relative" @mouseleave="catalogDropdown = false">
                    <button type="button" @click="catalogDropdown = !catalogDropdown"
                        @mouseenter="catalogDropdown = true"
                        class="px-4 py-2 rounded-full transition-all duration-200 flex items-center gap-1.5 cursor-pointer {{ request()->routeIs('catalog.*') ? 'bg-primary text-cream font-semibold shadow-xs' : 'text-dark/80 dark:text-cream/80 hover:text-primary dark:hover:text-accent hover:bg-black/5 dark:hover:bg-white/5' }}"
                        :aria-expanded="catalogDropdown">
                        <span>{{ __('messages.nav_catalog') }}</span>
                        <svg :class="{ 'rotate-180': catalogDropdown }"
                            class="w-3.5 h-3.5 transition-transform duration-200 opacity-70" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Mega Flyout Dropdown -->
                    <div x-show="catalogDropdown" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-[560px] rounded-3xl bg-cream/95 dark:bg-night-surface/95 backdrop-blur-2xl border border-primary/20 dark:border-night-border shadow-2xl p-5 z-50 overflow-hidden">
                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-dark/10 dark:border-night-border">
                            <span
                                class="font-mono text-[11px] uppercase tracking-wider text-secondary-dark dark:text-accent font-semibold">
                                {{ __('messages.nav_featured_categories') }}
                            </span>
                            <a href="{{ route('catalog.index') }}"
                                class="text-xs font-semibold text-primary dark:text-accent hover:underline flex items-center gap-1">
                                <span>{{ __('messages.nav_all_bouquets') }}</span>
                                <span class="font-serif">→</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            @php
                                $seriesIcons = [
                                    'teddy-series' => [
                                        'icon' => '🧸',
                                        'bg' => 'bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300',
                                    ],
                                    'lumiere-series' => [
                                        'icon' => '✨',
                                        'bg' => 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300',
                                    ],
                                    'bespoke-custom-series' => [
                                        'icon' => '🎨',
                                        'bg' =>
                                            'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300',
                                    ],
                                    'fresh-flower-series' => [
                                        'icon' => '🌸',
                                        'bg' => 'bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300',
                                    ],
                                    'dried-preserved-series' => [
                                        'icon' => '🌾',
                                        'bg' => 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300',
                                    ],
                                    'artificial-bloom-series' => [
                                        'icon' => '🌺',
                                        'bg' =>
                                            'bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300',
                                    ],
                                ];
                                $navCats = $navbarCategories ?? \App\Models\Category::all();
                            @endphp

                            @foreach ($navCats->take(4) as $cat)
                                @php
                                    $style = $seriesIcons[$cat->slug] ?? [
                                        'icon' => '💐',
                                        'bg' => 'bg-primary/10 text-primary dark:text-accent',
                                    ];
                                @endphp
                                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                                    class="p-3 rounded-2xl bg-white/60 dark:bg-night-card hover:bg-white dark:hover:bg-white/10 border border-dark/10 dark:border-night-border transition-all duration-200 group flex items-start gap-3">
                                    <span
                                        class="w-9 h-9 rounded-xl {{ $style['bg'] }} flex items-center justify-center text-base shrink-0 group-hover:scale-110 transition-transform">
                                        {{ $style['icon'] }}
                                    </span>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <h4
                                                class="text-xs font-bold text-dark dark:text-cream group-hover:text-primary dark:group-hover:text-accent">
                                                {{ $cat->name }}
                                            </h4>
                                            @if ($cat->products_count > 0)
                                                <span
                                                    class="px-1.5 py-0.2 rounded-full text-[9px] font-mono bg-cream dark:bg-night-surface text-secondary-dark dark:text-accent">
                                                    {{ $cat->products_count }} item
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-dark/60 dark:text-cream/60 mt-0.5 line-clamp-1">
                                            {{ $cat->description ?: 'Koleksi buket series eksklusif Maja Flower' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Bottom Highlight Banner in Flyout -->
                        <div
                            class="mt-4 pt-3 border-t border-dark/10 dark:border-night-border flex items-center justify-between bg-primary/5 dark:bg-white/5 rounded-2xl p-3">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base">📸</span>
                                <div>
                                    <p class="text-xs font-bold text-primary dark:text-accent">
                                        {{ __('messages.nav_photo_approval') }}</p>
                                    <p class="text-[10px] text-dark/60 dark:text-cream/60">
                                        {{ __('messages.nav_photo_approval_desc') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('tracking.index') }}"
                                class="px-3 py-1.5 rounded-full bg-primary text-cream hover:bg-primary-dark text-[11px] font-mono font-medium shrink-0 transition">
                                Lacak Pesanan →
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Lacak Pesanan Live Radar -->
                <a href="{{ route('tracking.index') }}"
                    class="px-4 py-2 rounded-full transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('tracking.*') ? 'bg-primary text-cream font-semibold shadow-xs' : 'text-dark/80 dark:text-cream/80 hover:text-primary dark:hover:text-accent hover:bg-black/5 dark:hover:bg-white/5' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>{{ __('messages.nav_tracking') }}</span>
                </a>
            </nav>

            <!-- 3. RIGHT ZONE: UTILITY SUITE & CTA (Desktop & Mobile) -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <!-- QUICK RESI TRACKING BUTTON & POPOVER (Desktop) -->
                <div class="hidden sm:block relative">
                    <button type="button" @click="quickResiOpen = !quickResiOpen"
                        class="px-3.5 py-2 rounded-full text-xs font-mono font-medium text-dark dark:text-cream bg-white/80 dark:bg-night-card hover:bg-white dark:hover:bg-white/15 border border-dark/15 dark:border-night-border shadow-2xs transition flex items-center gap-1.5 cursor-pointer"
                        title="{{ __('messages.nav_quick_track') }}" :aria-expanded="quickResiOpen">
                        <svg class="w-3.5 h-3.5 text-primary dark:text-accent" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="hidden md:inline">{{ __('messages.check_resi') }}</span>
                        <span class="md:hidden">Resi</span>
                    </button>

                    <!-- Quick Resi Popover Card -->
                    <div x-show="quickResiOpen" x-cloak @click.outside="quickResiOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute right-0 top-full mt-3 w-80 rounded-3xl bg-cream/95 dark:bg-night-surface/95 backdrop-blur-2xl border border-primary/20 dark:border-night-border shadow-2xl p-4 z-50 text-left">
                        <div
                            class="flex items-center justify-between pb-2 mb-3 border-b border-dark/10 dark:border-night-border">
                            <span
                                class="font-heading text-sm font-semibold text-primary dark:text-accent flex items-center gap-1.5">
                                <span>📦</span>
                                <span>{{ __('messages.nav_quick_track') }}</span>
                            </span>
                            <button @click="quickResiOpen = false"
                                class="text-xs text-dark/40 dark:text-cream/40 hover:text-dark dark:hover:text-cream p-1">
                                ✕
                            </button>
                        </div>
                        <form @submit.prevent="submitResi()" class="space-y-2.5">
                            <div class="relative">
                                <input type="text" x-model="resiInput"
                                    placeholder="{{ __('messages.nav_enter_resi') }}"
                                    class="w-full rounded-2xl bg-white dark:bg-night-card border border-dark/15 dark:border-night-border px-3.5 py-2 text-xs text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 font-mono focus:outline-none focus:border-primary dark:focus:border-accent"
                                    autofocus />
                            </div>
                            <button type="submit"
                                class="w-full py-2 px-3 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-medium text-xs font-body transition shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>{{ __('messages.nav_track_now') }}</span>
                                <span class="font-serif">→</span>
                            </button>
                        </form>
                        <div
                            class="mt-3 pt-2 border-t border-dark/10 dark:border-night-border flex items-center justify-between text-[10px] font-mono text-dark/60 dark:text-cream/60">
                            <span class="flex items-center gap-1">
                                <span>🔒</span>
                                <span>Privasi Terlindungi</span>
                            </span>
                            <span class="text-secondary-dark dark:text-accent font-semibold">
                                Format: MJ-XXXX-XXXX
                            </span>
                        </div>
                    </div>
                </div>

                <!-- BILINGUAL SWITCHER (ID / EN) -->
                <div
                    class="hidden sm:flex items-center bg-white/80 dark:bg-night-card p-1 rounded-full border border-dark/15 dark:border-night-border text-[11px] font-mono shadow-2xs">
                    <a href="{{ route('lang.switch', 'id') }}"
                        class="px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'id' ? 'bg-primary text-cream font-bold shadow-2xs' : 'text-dark/60 dark:text-cream/60 hover:text-dark dark:hover:text-cream' }}"
                        title="Bahasa Indonesia">
                        ID
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="px-2.5 py-1 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-primary text-cream font-bold shadow-2xs' : 'text-dark/60 dark:text-cream/60 hover:text-dark dark:hover:text-cream' }}"
                        title="English">
                        EN
                    </a>
                </div>

                <!-- BOTANICAL DARK MODE TOGGLE BUTTON -->
                <button type="button" @click="toggleTheme()"
                    class="p-2 sm:p-2.5 rounded-full bg-white/80 dark:bg-night-card border border-dark/15 dark:border-night-border text-dark dark:text-cream hover:bg-cream dark:hover:bg-white/10 transition shadow-2xs cursor-pointer group"
                    :title="darkMode ? 'Ubah ke Mode Terang' : 'Ubah ke Mode Gelap'" aria-label="Toggle theme">
                    <!-- Sun Icon for Dark Mode -->
                    <svg x-show="darkMode" class="w-4 h-4 text-amber-300 group-hover:rotate-45 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon for Light Mode -->
                    <svg x-show="!darkMode" class="w-4 h-4 text-dark group-hover:-rotate-12 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- DIRECT WHATSAPP CONSULTATION CTA (Desktop) -->
                <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Maja Flower, saya ingin berkonsultasi pemesanan buket no 1 di maja.')) }}"
                    target="_blank"
                    class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 sm:py-2.5 rounded-full text-xs font-medium text-cream bg-primary hover:bg-primary-dark transition shadow-sm hover:shadow-md cursor-pointer group">
                    <span>{{ __('messages.consult_wa') }}</span>
                    <span class="font-serif text-sm group-hover:translate-x-0.5 transition-transform">→</span>
                </a>

                <!-- MOBILE CONTROLS & HAMBURGER (Mobile & Tablet) -->
                <div class="flex items-center gap-1.5 lg:hidden">
                    <!-- Quick WA shortcut on mobile -->
                    <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Maja Flower, saya ingin memesan buket bunga.')) }}"
                        target="_blank"
                        class="p-2 rounded-xl bg-primary text-cream text-xs flex items-center justify-center shadow-xs"
                        title="Chat WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.477-.15-.678.15-.2.301-.778.98-.954 1.18-.176.2-.351.226-.653.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.2-.301.301-.502.1-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.508-.678-.517-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.482 1.079 2.912 1.23 3.113.15.201 2.124 3.243 5.145 4.549.718.311 1.279.497 1.716.636.721.229 1.377.197 1.895.12.578-.087 1.78-.728 2.031-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z" />
                            <path
                                d="M12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.66 1.433 5.174L2 22l4.981-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.2c-1.577 0-3.056-.441-4.323-1.209l-.31-.188-3.208.899.914-3.123-.206-.328A8.163 8.163 0 013.8 12c0-4.521 3.679-8.2 8.2-8.2 4.521 0 8.2 3.679 8.2 8.2 0 4.521-3.679 8.2-8.2 8.2z" />
                        </svg>
                    </a>

                    <!-- Animated Hamburger Toggle -->
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 sm:p-2.5 rounded-xl bg-white/70 dark:bg-night-card border border-dark/15 dark:border-night-border text-dark dark:text-cream hover:bg-white focus:outline-none transition-all shadow-2xs cursor-pointer"
                        :aria-expanded="mobileMenuOpen" aria-label="Toggle navigation menu">
                        <div class="w-5 h-4 flex flex-col justify-between relative">
                            <span :class="{ 'rotate-45 translate-y-1.5': mobileMenuOpen }"
                                class="w-full h-0.5 bg-dark dark:bg-cream rounded-full transition-all duration-300 transform origin-center"></span>
                            <span :class="{ 'opacity-0 scale-0': mobileMenuOpen }"
                                class="w-full h-0.5 bg-dark dark:bg-cream rounded-full transition-all duration-300"></span>
                            <span :class="{ '-rotate-45 -translate-y-2': mobileMenuOpen }"
                                class="w-full h-0.5 bg-dark dark:bg-cream rounded-full transition-all duration-300 transform origin-center"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. UNIQUE MOBILE SLIDE-DOWN BOTANICAL DRAWER -->
    <!-- Dimmed Backdrop Overlay -->
    <div x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileMenuOpen = false"
        class="pointer-events-auto fixed inset-0 bg-dark/60 backdrop-blur-xs z-40 lg:hidden">
    </div>

    <!-- Drawer Panel: Drops Down Flush from Top with Smooth Rounded Bottom -->
    <div x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="pointer-events-auto lg:hidden fixed inset-x-0 sm:inset-x-4 top-0 sm:top-20 z-50 max-h-[92vh] sm:max-h-[85vh] overflow-y-auto rounded-b-[2rem] sm:rounded-3xl bg-cream/98 dark:bg-night-surface/98 backdrop-blur-2xl border-b-2 sm:border-2 border-primary/25 dark:border-night-border shadow-2xl p-5 sm:p-6 space-y-4">
        <!-- Mobile Drawer Header with Logo & Live Badge -->
        <div class="flex items-center justify-between pb-3 border-b border-dark/10 dark:border-night-border">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full bg-cream-light dark:bg-night-card p-1 border border-primary/20 dark:border-night-border flex items-center justify-center shrink-0">
                    <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo"
                        class="h-full w-auto object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-heading text-base font-bold text-primary dark:text-accent leading-none">maja
                            flower</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    </div>
                    <span
                        class="font-mono text-[9px] uppercase tracking-wider text-secondary-dark dark:text-accent/80 block mt-0.5 font-medium">
                        {{ __('messages.nav_atelier_open') }} • {{ __('messages.nav_sameday_active') }}
                    </span>
                </div>
            </a>
            <button @click="mobileMenuOpen = false"
                class="w-7 h-7 rounded-full bg-white/80 dark:bg-night-card border border-dark/15 dark:border-night-border flex items-center justify-center text-xs text-dark dark:text-cream hover:bg-white"
                aria-label="Tutup menu">
                ✕
            </button>
        </div>

        <!-- In-Menu Quick Resi Tracking Bar -->
        <div
            class="p-3 rounded-2xl bg-white/70 dark:bg-night-card border border-dark/10 dark:border-night-border space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-primary dark:text-accent flex items-center gap-1.5">
                    <span>🔍</span>
                    <span>{{ __('messages.check_resi') }}</span>
                </span>
                <span class="text-[10px] font-mono text-dark/50 dark:text-cream/50">Live Approval</span>
            </div>
            <form @submit.prevent="submitResi()" class="flex gap-2">
                <input type="text" x-model="resiInput" placeholder="Contoh: MJ-XXXX-XXXX"
                    class="flex-1 rounded-xl bg-cream-light/60 dark:bg-night-bg border border-dark/15 dark:border-night-border px-3 py-2 text-xs font-mono text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 focus:outline-none focus:border-primary" />
                <button type="submit"
                    class="px-3.5 py-2 rounded-xl bg-primary text-cream font-medium text-xs font-body hover:bg-primary-dark transition shrink-0">
                    Lacak
                </button>
            </form>
        </div>

        <!-- Visual Navigation Cards -->
        <div class="space-y-1.5 font-medium text-sm">
            <!-- Beranda -->
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="flex items-center justify-between p-3 rounded-2xl transition {{ request()->routeIs('home') && !request()->has('code') ? 'bg-primary text-cream font-bold' : 'hover:bg-primary/10 text-dark dark:text-cream' }}">
                <span class="flex items-center gap-2.5">
                    <img src="{{ asset('general/logo.png') }}" alt="Logo"
                        class="w-4 h-4 object-contain inline-block">
                    <span>{{ __('messages.nav_home') }}</span>
                </span>
                <span class="text-xs opacity-60">→</span>
            </a>

            <!-- Katalog with Category Accordion -->
            <div
                class="rounded-2xl border border-dark/10 dark:border-night-border overflow-hidden bg-white/40 dark:bg-night-card/40">
                <div class="flex items-center justify-between p-3">
                    <a href="{{ route('catalog.index') }}" @click="mobileMenuOpen = false"
                        class="flex items-center gap-2.5 text-dark dark:text-cream font-medium">
                        <span>💐</span>
                        <span>{{ __('messages.nav_catalog') }}</span>
                    </a>
                    <button type="button" @click="mobileCatalogOpen = !mobileCatalogOpen"
                        class="p-1 rounded-lg text-dark/60 dark:text-cream/60 hover:text-dark">
                        <svg :class="{ 'rotate-180': mobileCatalogOpen }" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <!-- Accordion Sub-categories -->
                <div x-show="mobileCatalogOpen"
                    class="px-3 pb-3 pt-1 grid grid-cols-2 gap-2 border-t border-dark/10 dark:border-night-border text-xs">
                    @foreach ($navCats->take(6) as $cat)
                        @php
                            $style = $seriesIcons[$cat->slug] ?? ['icon' => '💐'];
                        @endphp
                        <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
                            @click="mobileMenuOpen = false"
                            class="p-2 rounded-xl bg-white/70 dark:bg-night-card text-dark dark:text-cream hover:bg-primary hover:text-cream transition flex items-center gap-1.5">
                            <span>{{ $style['icon'] }}</span>
                            <span class="truncate">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Filosofi Bunga -->
            <a href="{{ route('home') }}#filosofi" @click="mobileMenuOpen = false"
                class="flex items-center justify-between p-3 rounded-2xl hover:bg-primary/10 text-dark dark:text-cream transition">
                <span class="flex items-center gap-2.5">
                    <span>🌿</span>
                    <span>{{ __('messages.nav_philosophy') }}</span>
                </span>
                <span class="text-xs opacity-60">→</span>
            </a>

            <!-- Lacak Pesanan Live -->
            <a href="{{ route('tracking.index') }}" @click="mobileMenuOpen = false"
                class="flex items-center justify-between p-3 rounded-2xl transition {{ request()->routeIs('tracking.*') ? 'bg-primary text-cream font-bold' : 'hover:bg-primary/10 text-primary dark:text-accent font-semibold' }}">
                <span class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>{{ __('messages.nav_tracking') }}</span>
                </span>
                <span class="text-xs font-mono">Live Photo Approval</span>
            </a>
        </div>

        <!-- Drawer Footer: Language & Contact Direct -->
        <div class="pt-3 border-t border-dark/10 dark:border-night-border space-y-3">
            <div class="flex items-center justify-between">
                <!-- Mobile Language Selector -->
                <div
                    class="flex items-center bg-white/70 dark:bg-night-card p-1 rounded-xl border border-dark/15 dark:border-night-border text-xs font-mono">
                    <a href="{{ route('lang.switch', 'id') }}"
                        class="px-3 py-1 rounded-lg transition {{ app()->getLocale() === 'id' ? 'bg-primary text-cream font-bold' : 'text-dark/60 dark:text-cream/60' }}">
                        ID (Bahasa)
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="px-3 py-1 rounded-lg transition {{ app()->getLocale() === 'en' ? 'bg-primary text-cream font-bold' : 'text-dark/60 dark:text-cream/60' }}">
                        EN (English)
                    </a>
                </div>

                <!-- Mobile Dark Mode Button -->
                <button type="button" @click="toggleTheme()"
                    class="p-2 rounded-xl bg-white/70 dark:bg-night-card border border-dark/15 dark:border-night-border text-dark dark:text-cream flex items-center gap-1.5 text-xs font-mono">
                    <span x-show="darkMode">☀️ Mode Terang</span>
                    <span x-show="!darkMode">🌙 Mode Gelap</span>
                </button>
            </div>

            <!-- WhatsApp Big Consultation Button -->
            <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Florist Maja Flower, saya ingin berkonsultasi pemesanan buket no 1 di maja.')) }}"
                target="_blank"
                class="w-full text-center py-3 rounded-2xl text-xs font-bold text-cream bg-primary hover:bg-primary-dark transition shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.477-.15-.678.15-.2.301-.778.98-.954 1.18-.176.2-.351.226-.653.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.2-.301.301-.502.1-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.508-.678-.517-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.482 1.079 2.912 1.23 3.113.15.201 2.124 3.243 5.145 4.549.718.311 1.279.497 1.716.636.721.229 1.377.197 1.895.12.578-.087 1.78-.728 2.031-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z" />
                    <path
                        d="M12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.66 1.433 5.174L2 22l4.981-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.2c-1.577 0-3.056-.441-4.323-1.209l-.31-.188-3.208.899.914-3.123-.206-.328A8.163 8.163 0 013.8 12c0-4.521 3.679-8.2 8.2-8.2 4.521 0 8.2 3.679 8.2 8.2 0 4.521-3.679 8.2-8.2 8.2z" />
                </svg>
                <span>{{ __('messages.consult_wa') }}</span>
            </a>
        </div>
    </div>
</header>
