<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags: Buket No 1 di Maja, Maja Buket, Buket Maja -->
    <title>{{ $title ?? 'Buket No 1 di Maja — Maja Buket & Boutique Florist Pilihan (Buket Maja)' }}</title>
    <meta name="description"
        content="{{ $metaDescription ?? 'Maja Flower adalah buket no 1 di Maja. Toko bunga boutique artisanal penyedia maja buket segar dan buket maja premium untuk wisuda, pernikahan, ulang tahun, dengan garansi sameday delivery & live photo approval.' }}">
    <meta name="keywords"
        content="buket no 1 di maja, maja buket, buket maja, florist maja, toko bunga maja, buket wisuda maja, buket bunga segar maja, custom bouquet maja, florist jakarta selatan, florist artisanal">
    <meta name="author" content="Maja Flower Boutique Florist">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('general/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('general/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Maja Flower — Buket No 1 di Maja">
    <meta property="og:title" content="{{ $title ?? 'Buket No 1 di Maja — Maja Buket & Boutique Florist Pilihan' }}">
    <meta property="og:description"
        content="{{ $metaDescription ?? 'Pusat buket no 1 di Maja. Koleksi maja buket segar dan buket maja berkualitas premium dengan sistem live photo approval.' }}">
    <meta property="og:image" content="{{ asset('catalog-media/lumiere series - 1/lumirere series - 1.png') }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'en' ? 'en_US' : 'id_ID' }}">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Buket No 1 di Maja — Maja Buket & Boutique Florist Pilihan' }}">
    <meta name="twitter:description"
        content="{{ $metaDescription ?? 'Pusat buket no 1 di Maja. Koleksi maja buket segar dan buket maja berkualitas premium.' }}">
    <meta name="twitter:image" content="{{ asset('catalog-media/lumiere series - 1/lumirere series - 1.png') }}">

    <!-- Schema.org JSON-LD Structured Data: LocalBusiness / Florist -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Florist",
      "name": "Maja Flower - Buket No 1 di Maja",
      "alternateName": ["Maja Buket", "Buket Maja", "Maja Flower Studio", "Buket No 1 di Maja"],
      "description": "Pusat kreasi buket no 1 di Maja. Toko florist artisanal terpercaya menyediakan maja buket segar, buket wisuda, wedding bridal bouquet, dan buket maja bespoke custom dengan pengiriman sameday serta persetujuan foto buket sebelum kirim.",
      "url": "{{ url('/') }}",
      "telephone": "+{{ ltrim(setting('whatsapp_number', '6285882119900'), '+') }}",
      "priceRange": "Rp 150.000 - Rp 650.000",
      "currenciesAccepted": "IDR",
      "paymentAccepted": "Cash, Bank Transfer, QRIS",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ addslashes(setting('address', 'Jl. Maja Botanical No. 18, Kebayoran Baru')) }}",
        "addressLocality": "Jakarta Selatan",
        "postalCode": "12180",
        "addressCountry": "ID"
      },
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": -6.242337,
        "longitude": 106.793748
      },
      "openingHoursSpecification": [
        {
          "@@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
          "opens": "08:00",
          "closes": "20:00"
        }
      ],
      "sameAs": [
        "https://www.instagram.com/maja.flwr/",
        "https://www.threads.com/@maja.flwr?hl=id",
        "https://www.tiktok.com/@maja_flowers",
        "https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID"
      ]
    }
    </script>

    <!-- Zero-Flicker Dark Mode Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts: Hedvig Letters Serif, Roboto Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-cream dark:bg-night-bg text-dark dark:text-cream font-body antialiased min-h-screen flex flex-col selection:bg-secondary selection:text-white transition-colors duration-300">

    <!-- Botanical Opening & Inter-Page Transition Screen -->
    <x-client.page-preloader />

    <!-- Unique Responsive Floating Botanical Island Navbar -->
    <x-client.navbar />

    <!-- Main Content Container -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer: Deep Forest Green (#346739) & Warm Cream (#F2EDC2) -->
    <footer
        class="bg-primary dark:bg-night-surface text-cream pt-16 pb-12 mt-20 border-t border-primary-dark dark:border-night-border transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
                <!-- Column 1: Brand & SEO Authority -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-cream-light p-1.5 flex items-center justify-center border border-accent/40 shadow-xs shrink-0">
                            <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo"
                                class="h-full w-auto object-contain">
                        </div>
                        <span class="font-heading text-2xl font-bold tracking-tight text-cream">maja flower</span>
                    </div>
                    <p class="text-xs text-cream/80 font-body leading-relaxed">
                        Pusat <strong>buket no 1 di Maja</strong>. Florist boutique artisanal yang mendedikasikan seni
                        merangkai <strong>maja buket</strong> segar dan <strong>buket maja</strong> kustom untuk setiap
                        babak cerita berharga Anda.
                    </p>
                    <div class="pt-2">
                        <span
                            class="inline-block px-3 py-1 rounded-full text-[10px] font-mono bg-cream/15 text-accent border border-accent/20">
                            Buket No 1 di Maja • Botanical Atelier
                        </span>
                    </div>

                    <!-- Official Social Media Channels -->
                    <div class="pt-1">
                        <span class="text-[10px] font-mono text-cream/60 block mb-2 uppercase tracking-wider">Social
                            Media Resmi</span>
                        <div class="flex items-center gap-2">
                            <!-- Instagram -->
                            <a href="{{ setting('instagram_url', 'https://www.instagram.com/maja.flwr/') }}" target="_blank" rel="noopener noreferrer"
                                title="Instagram: @maja.flwr"
                                class="w-8 h-8 rounded-full bg-cream/15 hover:bg-cream hover:text-primary text-cream flex items-center justify-center transition-all duration-300">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <!-- TikTok -->
                            <a href="{{ setting('tiktok_url', 'https://www.tiktok.com/@maja_flowers') }}" target="_blank" rel="noopener noreferrer"
                                title="TikTok: @maja_flowers"
                                class="w-8 h-8 rounded-full bg-cream/15 hover:bg-cream hover:text-primary text-cream flex items-center justify-center transition-all duration-300">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                </svg>
                            </a>
                            <!-- Facebook -->
                            <a href="{{ setting('facebook_url', 'https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID') }}"
                                target="_blank" rel="noopener noreferrer" title="Facebook: Maja Flower"
                                class="w-8 h-8 rounded-full bg-cream/15 hover:bg-cream hover:text-primary text-cream flex items-center justify-center transition-all duration-300">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z" />
                                </svg>
                            </a>
                            <!-- Threads -->
                            <a href="{{ setting('threads_url', 'https://www.threads.com/@maja.flwr?hl=id') }}" target="_blank" rel="noopener noreferrer"
                                title="Threads: @maja.flwr"
                                class="w-8 h-8 rounded-full bg-cream/15 hover:bg-cream hover:text-primary text-cream flex items-center justify-center transition-all duration-300">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 192 192">
                                    <path
                                        d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.788C154.894 45.8136 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 27.974C147.036 9.60668 125.202 0.195148 97.0695 0H96.9569C68.8816 0.19447 47.2921 9.6418 32.7883 28.0793C19.8819 44.4864 13.2244 67.3157 13.0007 95.9325L13 96L13.0007 96.0675C13.2244 124.684 19.8819 147.514 32.7883 163.921C47.2921 182.358 68.8816 191.806 96.9569 192H97.0695C122.03 191.827 139.624 185.292 154.118 170.811C173.081 151.866 172.51 128.119 166.26 113.541C161.776 103.087 153.227 94.5962 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6196 115.372C76.2232 107.93 81.9158 99.626 99.0812 98.6368C101.047 98.5234 102.976 98.468 104.871 98.468C111.106 98.468 116.939 99.0737 122.242 100.233C120.264 124.935 108.662 128.946 98.4405 129.507Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="space-y-3">
                    <h4 class="font-heading text-lg font-semibold text-cream">{{ __('messages.nav_catalog') }}</h4>
                    <ul class="space-y-2 text-xs text-cream/80 font-body">
                        <li><a href="{{ route('home') }}"
                                class="hover:text-accent transition">{{ __('messages.nav_home') }}</a></li>
                        <li><a href="{{ route('catalog.index') }}"
                                class="hover:text-accent transition">{{ __('messages.nav_catalog') }}</a></li>
                        <li><a href="{{ route('home') }}#filosofi"
                                class="hover:text-accent transition">{{ __('messages.nav_philosophy') }}</a></li>
                        <li><a href="{{ route('home') }}#custom-studio"
                                class="hover:text-accent transition">{{ __('messages.nav_bespoke') }}</a></li>
                        <li><a href="{{ route('tracking.index') }}"
                                class="hover:text-accent transition">{{ __('messages.nav_tracking') }}</a></li>
                    </ul>
                </div>

                <!-- Column 3: Studio & Operational -->
                <div class="space-y-3">
                    <h4 class="font-heading text-lg font-semibold text-cream">Studio Buket Maja</h4>
                    <div class="text-xs text-cream/80 space-y-2 font-body">
                        <p class="flex items-start gap-2">
                            <span class="font-mono text-accent">📍</span>
                            <span>{{ setting('address', 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan, 12180') }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="font-mono text-accent">⏰</span>
                            <span>{{ setting('operating_hours', 'Senin - Minggu: 08.00 - 20.00 WIB') }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="font-mono text-accent">📞</span>
                            <span class="font-mono">+{{ setting('whatsapp_number', '6285882119900') }}</span>
                        </p>
                    </div>
                </div>

                <!-- Column 4: Newsletter & Story -->
                <div class="space-y-3">
                    <h4 class="font-heading text-lg font-semibold text-cream">Kisah & Penawaran Spesial</h4>
                    <p class="text-xs text-cream/80 font-body leading-relaxed">
                        Dapatkan inspirasi rangkaian buket maja bulanan, panduan botani, dan promo hari raya eksklusif.
                    </p>
                    <form
                        @submit.prevent="alert('Terima kasih telah bergabung dengan lingkar kabar botani Maja Flower!')"
                        class="flex gap-2 pt-1">
                        <input type="email" required placeholder="Email Anda..."
                            class="flex-1 rounded-xl bg-cream/15 border border-cream/25 px-3 py-2 text-xs text-cream placeholder:text-cream/50 focus:outline-none focus:border-accent" />
                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-accent text-dark font-semibold text-xs hover:bg-accent-light transition cursor-pointer">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright & SEO Badges -->
            <div
                class="mt-12 pt-6 border-t border-cream/15 flex flex-col sm:flex-row items-center justify-between text-xs text-cream/60 font-mono gap-3">
                <p>© 2026 Maja Flower — Buket No 1 di Maja. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-4">
                    <span>Maja Buket Segar</span>
                    <span>•</span>
                    <span>Buket Maja Sameday</span>
                    <span>•</span>
                    <span>Fresh Flowers Guaranteed</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- FLOATING ACTIONS: WHATSAPP DIRECT & AI CHATBOT WIDGET -->
    <!-- 1. Floating WhatsApp Button -->
    <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Florist Maja Flower, saya ingin bertanya seputar pemesanan buket no 1 di maja.')) }}"
        target="_blank" rel="noopener noreferrer"
        class="fixed bottom-6 left-6 z-40 flex items-center gap-2 px-4 py-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 group"
        title="Direct WhatsApp Florist">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.477-.15-.678.15-.2.301-.778.98-.954 1.18-.176.2-.351.226-.653.075-.301-.15-1.272-.469-2.423-1.496-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.176.2-.301.301-.502.1-.2.05-.376-.025-.527-.075-.15-.678-1.634-.929-2.238-.244-.588-.493-.508-.678-.517-.176-.009-.376-.011-.577-.011-.201 0-.527.075-.803.376-.276.301-1.054 1.03-1.054 2.511 0 1.482 1.079 2.912 1.23 3.113.15.201 2.124 3.243 5.145 4.549.718.311 1.279.497 1.716.636.721.229 1.377.197 1.895.12.578-.087 1.78-.728 2.031-1.431.251-.703.251-1.305.176-1.431-.075-.126-.276-.201-.577-.351z" />
            <path
                d="M12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.66 1.433 5.174L2 22l4.981-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.2c-1.577 0-3.056-.441-4.323-1.209l-.31-.188-3.208.899.914-3.123-.206-.328A8.163 8.163 0 013.8 12c0-4.521 3.679-8.2 8.2-8.2 4.521 0 8.2 3.679 8.2 8.2 0 4.521-3.679 8.2-8.2 8.2z" />
        </svg>
        <span class="text-xs font-semibold font-body hidden sm:inline">WhatsApp Florist</span>
    </a>

    <!-- 2. Floating AI Chatbot Widget: "Maja Assistant" -->
    <div x-data="initMajaChatbot()" class="fixed bottom-6 right-6 z-50">
        <!-- Floating Trigger Button -->
        <button @click="chatOpen = !chatOpen"
            class="flex items-center gap-2.5 px-4 py-3 rounded-full bg-primary hover:bg-primary-dark text-cream shadow-2xl hover:scale-105 transition-all duration-300 border border-cream/20 group cursor-pointer">
            <span class="text-xl group-hover:rotate-12 transition-transform">🌿</span>
            <span class="text-xs font-semibold font-body tracking-wide">{{ __('messages.chatbot_btn') }}</span>
            <span class="w-2.5 h-2.5 rounded-full bg-accent animate-ping"></span>
        </button>

        <!-- Popup Chat Modal -->
        <div x-show="chatOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="absolute bottom-16 right-0 w-[92vw] sm:w-[410px] max-h-[85vh] h-[560px] flex flex-col rounded-3xl bg-cream dark:bg-night-surface shadow-2xl border-2 border-primary/20 dark:border-night-border overflow-hidden z-50">
            <!-- Chat Header -->
            <div
                class="bg-primary text-cream p-4 flex items-center justify-between border-b border-primary-dark shadow-xs">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-cream-light p-1.5 flex items-center justify-center shadow-xs shrink-0 border border-accent/30">
                        <img src="{{ asset('general/logo.png') }}" alt="Maja Assistant Logo"
                            class="h-full w-auto object-contain">
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <h4 class="font-heading text-sm font-bold text-cream">{{ __('messages.chatbot_title') }}
                            </h4>
                            <span
                                :class="isLiveAi ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/30' :
                                    'bg-accent/20 text-accent border-accent/30'"
                                class="text-[9px] font-mono px-2 py-0.5 rounded-full border flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span x-text="isLiveAi ? 'Gemini AI' : 'Active'"></span>
                            </span>
                        </div>
                        <p class="text-[10px] font-mono text-cream/70">{{ __('messages.chatbot_subtitle') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode(setting('whatsapp_default_message', 'Halo Florist Maja Flower, saya ingin konsultasi custom buket.')) }}"
                        target="_blank" rel="noopener noreferrer" title="Chat WhatsApp Florist"
                        class="text-cream/80 hover:text-white p-1.5 rounded-lg hover:bg-cream/10 transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                        </svg>
                    </a>
                    <button @click="chatOpen = false"
                        class="text-cream/70 hover:text-cream text-lg font-bold p-1 hover:bg-cream/10 rounded-lg transition cursor-pointer">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Chat Messages Scroll Area -->
            <div id="chat-scroll-area"
                class="flex-1 overflow-y-auto p-4 space-y-3.5 bg-cream-light/60 dark:bg-night-bg/80">
                <template x-for="(msg, idx) in messages" :key="idx">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="msg.role === 'user' ?
                            'bg-primary text-cream rounded-2xl rounded-tr-xs' :
                            'bg-surface dark:bg-night-card text-dark dark:text-cream border border-dark/10 dark:border-night-border rounded-2xl rounded-tl-xs shadow-xs'"
                            class="max-w-[88%] p-3 text-xs leading-relaxed">
                            <div class="font-body space-y-1" x-html="formatMessage(msg.content)"></div>
                            <span
                                :class="msg.role === 'user' ? 'text-cream/60' : 'text-dark/40 dark:text-cream/40'"
                                class="block text-[9px] font-mono mt-1 text-right" x-text="msg.time"></span>
                        </div>
                    </div>
                </template>

                <!-- Loading Bubble -->
                <div x-show="loading" class="flex justify-start">
                    <div
                        class="bg-surface dark:bg-night-card text-dark dark:text-cream border border-dark/10 dark:border-night-border rounded-2xl rounded-tl-xs p-3 text-xs flex items-center gap-1.5 shadow-xs">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce [animation-delay:0.4s]"></span>
                        <span class="text-[11px] font-mono text-dark/60 dark:text-cream/60 ml-1">Maja sedang merangkai
                            jawaban...</span>
                    </div>
                </div>
            </div>

            <!-- Quick Chips -->
            <div
                class="px-3 py-2 bg-cream dark:bg-night-surface border-t border-dark/10 dark:border-night-border overflow-x-auto flex gap-1.5 no-scrollbar">
                <template x-for="chip in quickChips" :key="chip">
                    <button type="button" @click="sendQuickChip(chip)"
                        class="flex-shrink-0 text-[10px] font-mono py-1 px-2.5 rounded-full bg-white/80 dark:bg-night-card hover:bg-white hover:border-primary text-primary dark:text-accent border border-primary/20 dark:border-night-border transition cursor-pointer shadow-2xs"
                        x-text="chip"></button>
                </template>
            </div>

            <!-- Input Form -->
            <form @submit.prevent="sendMessage()"
                class="p-3 bg-cream dark:bg-night-surface border-t border-dark/10 dark:border-night-border flex items-center gap-2">
                <input type="text" x-model="userMessage" :placeholder="'{{ __('messages.chatbot_placeholder') }}'"
                    class="flex-1 rounded-full bg-white dark:bg-night-card px-4 py-2 text-xs text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 border border-dark/15 dark:border-night-border focus:outline-none focus:border-primary font-body" />
                <button type="submit" :disabled="!userMessage.trim() || loading"
                    class="w-9 h-9 rounded-full bg-primary hover:bg-primary-dark text-cream flex items-center justify-center text-xs font-bold disabled:opacity-40 transition shadow-xs cursor-pointer"
                    title="Kirim Pesan">
                    ➤
                </button>
            </form>
        </div>
    </div>

    <!-- Maja Assistant Chatbot Script -->
    <script>
        function initMajaChatbot() {
            return {
                chatOpen: false,
                userMessage: '',
                loading: false,
                isLiveAi: false,
                messages: [{
                    role: 'model',
                    content: 'Halo! Saya **Maja Assistant**, asisten florist resmi di Maja Flower 🌸 Ada momen istimewa atau cerita yang ingin Anda ungkapkan lewat keindahan bunga hari ini?',
                    time: 'Sekarang'
                }],
                quickChips: [
                    '🌸 Alur custom buket',
                    '🎓 Rekomendasi buket wisuda',
                    '🧸 Berapa harga Teddy Series?',
                    '🌿 Kuota bunga segar hari ini'
                ],
                formatMessage(text) {
                    if (!text) return '';
                    let safe = text
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');

                    safe = safe.replace(/\[(.*?)\]\((https?:\/\/[^\s)]+)\)/g,
                        '<a href="$2" target="_blank" rel="noopener noreferrer" class="underline font-semibold text-accent hover:opacity-80">$1</a>'
                    );
                    safe = safe.replace(/\*\*(.*?)\*\*/g,
                        '<strong class="font-semibold text-primary dark:text-accent">$1</strong>');
                    safe = safe.replace(/\*(.*?)\*/g, '<em class="italic">$1</em>');
                    safe = safe.replace(/(?:^|\n)[-•]\s+(.+)/g,
                        '<div class="flex items-start gap-1.5 ml-1 my-0.5"><span class="text-accent shrink-0">•</span><span>$1</span></div>'
                    );
                    safe = safe.replace(/(?:^|\n)(\d+)\.\s+(.+)/g,
                        '<div class="flex items-start gap-1.5 ml-1 my-0.5"><span class="font-mono text-accent shrink-0">$1.</span><span>$2</span></div>'
                    );
                    safe = safe.replace(/\n/g, '<br>');
                    return safe;
                },
                async sendQuickChip(chip) {
                    this.userMessage = chip.replace(/^[^\w\s]+\s*/, '');
                    await this.sendMessage();
                },
                async sendMessage() {
                    const text = this.userMessage.trim();
                    if (!text || this.loading) return;

                    const now = new Date();
                    const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString()
                        .padStart(2, '0');

                    this.messages.push({
                        role: 'user',
                        content: text,
                        time: timeStr
                    });

                    this.userMessage = '';
                    this.loading = true;

                    this.$nextTick(() => {
                        const box = document.getElementById('chat-scroll-area');
                        if (box) box.scrollTop = box.scrollHeight;
                    });

                    try {
                        const tokenMeta = document.querySelector('meta[name=csrf-token]');
                        const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
                        const response = await fetch('{{ route('chatbot.ask') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                message: text,
                                history: this.messages.slice(-8).map(m => ({
                                    role: m.role,
                                    content: m.content
                                }))
                            })
                        });

                        const data = await response.json();
                        if (data.is_live_ai !== undefined) {
                            this.isLiveAi = data.is_live_ai;
                        }

                        this.messages.push({
                            role: 'model',
                            content: data.reply ||
                                'Mohon maaf, sistem sedang meninjau permintaan Anda. Silakan hubungi WhatsApp florist kami.',
                            time: data.timestamp || timeStr
                        });
                    } catch (err) {
                        this.messages.push({
                            role: 'model',
                            content: 'Terima kasih telah bertanya! Bila ada kendala jaringan, Anda juga bisa langsung berkonsultasi via WhatsApp Florist kami di **0812-3456-7890** 🌸',
                            time: timeStr
                        });
                    } finally {
                        this.loading = false;
                        this.$nextTick(() => {
                            const box = document.getElementById('chat-scroll-area');
                            if (box) box.scrollTop = box.scrollHeight;
                        });
                    }
                }
            };
        }
    </script>
</body>

</html>
