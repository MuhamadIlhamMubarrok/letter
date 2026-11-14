<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Masa Aktif Berakhir — {{ $story->title }} | Maja Flower</title>

    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-night-bg text-cream font-body antialiased min-h-screen flex items-center justify-center p-4 selection:bg-primary selection:text-cream">
    <!-- Background Subtle Botanical Glow -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-brand-rose/10 blur-3xl"></div>
    </div>

    <main class="relative z-10 max-w-lg w-full bg-night-surface/90 border border-night-border rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl text-center">
        <!-- Botanical Atelier Seal -->
        <div class="w-16 h-16 mx-auto rounded-full bg-night-card border border-primary/30 flex items-center justify-center shadow-inner mb-5">
            <span class="text-2xl">⏳</span>
        </div>

        <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block mb-2">
            Maja Flower Digital Archive
        </span>

        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-cream mb-3 leading-tight">
            Masa Aktif Kenangan Ini Telah Berakhir
        </h1>

        <p class="font-body text-cream/70 text-sm leading-relaxed mb-6">
            Surat digital & kenangan manis <strong class="text-cream">"{{ $story->title }}"</strong> untuk <span class="text-accent">{{ $story->recipient_name }}</span> telah melewati batas masa aktif hosting paket <span class="font-mono text-cream-light font-semibold">({{ $story->duration_plan->label() }})</span>.
        </p>

        <!-- Story Memory Card Snapshot -->
        <div class="bg-night-card border border-white/10 rounded-2xl p-4 mb-6 text-left">
            <div class="flex items-center justify-between text-xs font-mono text-cream/60 border-b border-white/5 pb-2 mb-2">
                <span>ID Kenangan: {{ $story->slug }}</span>
                <span class="px-2 py-0.5 rounded-full bg-brand-danger/20 text-brand-danger font-semibold">Expired</span>
            </div>
            <p class="font-body text-xs text-cream/80">
                <span class="text-cream/50">Pengirim:</span> {{ $story->sender_name }}<br>
                <span class="text-cream/50">Penerima:</span> {{ $story->recipient_name }}<br>
                @if($story->event_date)
                    <span class="text-cream/50">Tanggal Spesial:</span> {{ $story->event_date->translatedFormat('d F Y') }}
                @endif
            </p>
        </div>

        <!-- WhatsApp Extension Action -->
        @php
            $waMessage = urlencode("Halo Atelier Maja Flower, saya ingin memperpanjang masa aktif Surat Digital / Undangan Buket dengan ID: {$story->slug} ({$story->title}). Mohon bantuannya.");
            $waUrl = "https://wa.me/6281234567890?text={$waMessage}";
        @endphp

        <div class="space-y-3">
            <a
                href="{{ $waUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-2 w-full py-3.5 px-6 rounded-2xl bg-primary hover:bg-primary-light text-cream font-semibold text-sm transition duration-200 shadow-lg shadow-primary/25 border border-accent/30"
            >
                <span class="text-base">💬</span>
                <span>Perpanjang Masa Aktif via WhatsApp</span>
            </a>

            <a
                href="{{ url('/') }}"
                class="inline-block text-xs font-mono text-cream/50 hover:text-cream transition pt-2"
            >
                ← Kembali ke Beranda Maja Flower
            </a>
        </div>

        <!-- Watermark Footer -->
        <div class="mt-8 pt-4 border-t border-white/5 flex items-center justify-center gap-2">
            <div class="w-1.5 h-1.5 rounded-full bg-accent"></div>
            <span class="font-heading text-xs text-cream/40">Setiap kelopak menyimpan cerita abadi</span>
            <div class="w-1.5 h-1.5 rounded-full bg-accent"></div>
        </div>
    </main>
</body>
</html>
