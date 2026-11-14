<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cetak Kartu QR Buket — {{ $story->recipient_name }} | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-area {
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
            }
            .print-card-wrapper {
                box-shadow: none !important;
                page-break-inside: avoid;
            }
            @page {
                margin: 6mm;
            }
        }
    </style>
</head>
<body
    x-data="{
        selectedSize: 'a6', // 'a6' or 'business-card'
        copies: 1,
        printCard() {
            window.print();
        }
    }"
    class="bg-[#F4F6F2] text-dark font-body antialiased min-h-screen selection:bg-primary selection:text-cream"
>
    <!-- TOP TOOLBAR (Hidden during print) -->
    <header class="no-print bg-primary text-cream shadow-md border-b border-primary-dark sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.digital-stories.index') }}"
                    class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-cream flex items-center justify-center font-bold text-sm transition"
                    title="Kembali ke Daftar Cerita"
                >
                    ←
                </a>
                <div>
                    <h1 class="font-heading text-base font-bold text-cream tracking-tight leading-none">
                        Cetak Kartu QR Buket
                    </h1>
                    <span class="font-mono text-[10px] text-accent tracking-widest uppercase">
                        {{ $story->recipient_name }} • {{ $story->slug }}
                    </span>
                </div>
            </div>

            <!-- Size Switcher & Print Action -->
            <div class="flex items-center gap-3">
                <!-- Size Selector -->
                <div class="inline-flex rounded-xl bg-primary-dark/60 p-1 border border-white/10 text-xs font-mono">
                    <button
                        @click="selectedSize = 'a6'"
                        type="button"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer"
                        :class="selectedSize === 'a6' ? 'bg-cream text-dark font-bold shadow-xs' : 'text-cream/80 hover:text-cream'"
                    >
                        Ukuran A6 (105×148 mm)
                    </button>
                    <button
                        @click="selectedSize = 'business-card'"
                        type="button"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer"
                        :class="selectedSize === 'business-card' ? 'bg-cream text-dark font-bold shadow-xs' : 'text-cream/80 hover:text-cream'"
                    >
                        Kartu Nama (90×55 mm)
                    </button>
                </div>

                <!-- Print Trigger Button -->
                <button
                    @click="printCard()"
                    type="button"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-accent text-dark font-bold text-xs font-mono uppercase tracking-wider hover:bg-cream transition shadow-md cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Sekarang (Ctrl+P)</span>
                </button>
            </div>
        </div>
    </header>

    <!-- PRINT PREVIEW SHEET CONTAINER -->
    <main class="max-w-5xl mx-auto px-4 py-8 sm:py-12 flex flex-col items-center justify-center">
        <!-- Florist Instructions Banner (Screen only) -->
        <div class="no-print max-w-xl w-full bg-white border border-primary/20 rounded-2xl p-4 mb-6 shadow-sm flex items-start gap-3">
            <span class="text-xl">✂️</span>
            <div class="text-xs">
                <strong class="font-heading text-primary block">Panduan Tim Florist Toko:</strong>
                <p class="font-body text-dark/70 mt-0.5">
                    Gunakan kertas Jasmine / Linen / Art Carton 260gsm agar hasil cetak mewah dan kaku. Gunting mengikuti garis putus-putus dan sematkan kartu menggunakan jepit kayu kecil pada buket bunga pesanan.
                </p>
            </div>
        </div>

        <!-- THE PHYSICAL PRINT PREVIEW WRAPPER -->
        <div class="print-area w-full flex items-center justify-center">
            <!-- A6 Preview -->
            <div x-show="selectedSize === 'a6'" x-cloak>
                <x-story.qr-card-print :story="$story" size="a6" />
            </div>

            <!-- Business Card (90x55mm) Preview -->
            <div x-show="selectedSize === 'business-card'" x-cloak>
                <x-story.qr-card-print :story="$story" size="business-card" />
            </div>
        </div>

        <!-- Direct Link & Public View Button -->
        <div class="no-print mt-8 flex items-center gap-3">
            <a
                href="{{ route('story.public.show', ['slug' => $story->slug]) }}"
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-night-card hover:bg-night-surface text-cream text-xs font-mono transition border border-night-border"
            >
                <span>👁️ Buka Public Viewer di Tab Baru ↗</span>
            </a>
            <a
                href="{{ route('admin.digital-stories.edit', $story) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-cream-light text-primary text-xs font-mono font-semibold transition border border-primary/20"
            >
                <span>✏️ Edit Pesan & Foto</span>
            </a>
        </div>
    </main>
</body>
</html>
