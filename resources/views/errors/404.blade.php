<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | Maja Flower</title>

    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-night-bg text-cream font-body antialiased min-h-screen flex items-center justify-center p-4 selection:bg-primary selection:text-cream">
    <div class="max-w-md w-full bg-night-surface rounded-3xl border border-white/10 shadow-2xl p-8 text-center space-y-6">
        <div class="w-20 h-20 rounded-full bg-cream-light p-3 mx-auto shadow-xl border-2 border-primary/20 flex items-center justify-center">
            <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo" class="h-full w-auto object-contain">
        </div>

        <div>
            <span class="px-3 py-1 rounded-full bg-brand-rose/20 text-brand-rose font-mono text-xs font-bold">
                Galat 404 • Halaman Tidak Ditemukan
            </span>
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-cream mt-3">
                Halaman Belum Terdaftar
            </h1>
            <p class="font-body text-xs text-cream/70 mt-2 leading-relaxed">
                Tautan yang Anda tuju mungkin salah ketik, telah berakhir masa aktifnya, atau template belum terdaftar dalam sistem.
            </p>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a
                href="{{ route('home') }}"
                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream text-xs font-semibold font-mono transition shadow-md"
            >
                ← Kembali ke Halaman Utama
            </a>
            <a
                href="https://wa.me/6281234567890"
                target="_blank"
                rel="noopener noreferrer"
                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-cream text-xs font-semibold font-mono transition"
            >
                💬 Bantuan WhatsApp
            </a>
        </div>
    </div>
</body>
</html>
