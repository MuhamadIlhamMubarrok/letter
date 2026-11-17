<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — Undangan Lucu & Pastel Romance | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fredoka:wght@400;500;600;700&family=Sacramento&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-cute-heading { font-family: 'Fredoka', 'Plus Jakarta Sans', sans-serif; }
        .font-script { font-family: 'Sacramento', cursive; }

        /* Strict Pre-Open Scroll Lock */
        html.scroll-locked, body.scroll-locked {
            overflow: hidden !important;
            height: 100% !important;
            max-height: 100vh !important;
            max-height: 100dvh !important;
            touch-action: none !important;
            overscroll-behavior: none !important;
            -webkit-overflow-scrolling: auto !important;
        }

        /* Vinyl rotation keyframe */
        @keyframes vinyl-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-vinyl {
            animation: vinyl-spin 7s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Float animation */
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(2deg); }
        }
        .animate-float {
            animation: float-gentle 4s ease-in-out infinite;
        }

        /* Heartbeat */
        @keyframes pulse-heart {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }
        .animate-heart {
            animation: pulse-heart 1.6s ease-in-out infinite;
        }

        /* Sleek Pastel Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 77, 109, 0.35); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 77, 109, 0.7); }
        * { scrollbar-width: thin; scrollbar-color: rgba(255, 77, 109, 0.35) transparent; }
    </style>

    <script>
        if (window.location.hash) {
            window.history.replaceState(null, null, window.location.pathname + window.location.search);
        }
        window.scrollTo(0, 0);
    </script>
</head>

@php
    $guestName = request()->query('to', request()->query('guest', request()->query('u', request()->query('nama'))));
    $displayGuest = $guestName ? trim($guestName) : 'Sahabat & Teman Tercinta';

    $meta = is_array($story->metadata) ? $story->metadata : [];

    $groomNickname = $story->getGroomNickname();
    $brideNickname = $story->getBrideNickname();

    $groomFullName = $story->getGroomFullName();
    $groomParents = $story->getGroomParents();
    $groomInstagram = $meta['groom_instagram'] ?? '@daffarmdhn';
    $groomBio = $meta['groom_bio'] ?? 'Pencinta kopi dan sosok paling sabar yang siap menemani setiap langkah bahagia.';
    $groomPhoto = $story->getGroomPhotoUrl();

    $brideFullName = $story->getBrideFullName();
    $brideParents = $story->getBrideParents();
    $brideInstagram = $meta['bride_instagram'] ?? '@clarissaptr';
    $brideBio = $meta['bride_bio'] ?? 'Pecinta bunga manis, pencipta keceriaan, dan alasan utama Daffa tersenyum setiap hari.';
    $bridePhoto = $story->getBridePhotoUrl();

    $eventDate = $story->event_date ?? \Carbon\Carbon::now()->addDays(28)->setHour(9)->setMinute(0);
    $eventDateIso = $eventDate->toIso8601String();
    $eventFormattedDate = $eventDate->translatedFormat('l, d F Y');

    $ceremonyTime = $story->getCeremonyTime();
    $ceremonyVenue = $story->getCeremonyVenue();
    $ceremonyAddress = $story->getCeremonyAddress();
    $ceremonyMapsUrl = $story->getCeremonyMapsUrl();

    $receptionTime = $story->getReceptionTime();
    $receptionVenue = $story->getReceptionVenue();
    $receptionAddress = $story->getReceptionAddress();
    $receptionMapsUrl = $story->getReceptionMapsUrl();

    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-romantic-moment-1144.mp3');
    $audioTitle = $story->audio_title ?: 'Sweet Pastel Romance (Acoustic Joy)';

    $bcaName = $meta['bank_1_name'] ?? 'BCA';
    $bcaNumber = $meta['bank_1_number'] ?? ($meta['bank_bca_number'] ?? '8020 9988 12');
    $bcaHolder = $meta['bank_1_holder'] ?? ($meta['bank_bca_holder'] ?? 'Clarissa Putri');

    $mandiriName = $meta['bank_2_name'] ?? 'Mandiri';
    $mandiriNumber = $meta['bank_2_number'] ?? ($meta['bank_mandiri_number'] ?? '137 00 1928 382');
    $mandiriHolder = $meta['bank_2_holder'] ?? ($meta['bank_mandiri_holder'] ?? 'Daffa Ramadhan');

    $giftAddress = $meta['gift_delivery_address'] ?? 'Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan (Penerima: Caca & Daffa)';
    $holyVerse = $meta['holy_verse_text'] ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.';
    $holyVerseSource = $meta['holy_verse_source'] ?? '(QS. Ar-Rum: 21)';
@endphp

<body
    x-data="weddingCuteApp({
        eventDate: '{{ $eventDateIso }}',
        audioUrl: '{{ $audioTrack }}',
        audioTitle: '{{ addslashes($audioTitle) }}',
        slug: '{{ $story->slug }}',
        isDemo: {{ isset($isDemo) && $isDemo ? 'true' : 'false' }}
    })"
    class="{{ request()->has('embed') ? 'bg-[#FFF5F8]' : 'bg-[#2A1D20]' }} text-[#3D2A2E] font-sans antialiased min-h-screen selection:bg-[#FF4D6D] selection:text-white relative overflow-x-hidden scroll-locked"
>
    {{-- DEMO PREVIEW BANNER --}}
    @if(isset($isDemo) && $isDemo)
        @include('digital-story.components.demo-banner', ['template' => $template, 'isDemo' => true])
    @endif

    {{-- AUDIO ELEMENT --}}
    <audio
        x-ref="audioPlayer"
        src="{{ $audioTrack }}"
        preload="auto"
        loop
    ></audio>

    {{-- TOAST NOTIFICATION --}}
    <div
        x-show="toastOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed top-5 inset-x-0 mx-auto z-50 w-max max-w-sm px-4 py-2.5 rounded-2xl bg-white border-2 border-[#FFCCD5] text-[#FF4D6D] shadow-2xl flex items-center gap-2.5 font-cute-heading text-xs font-semibold"
    >
        <span class="text-base animate-bounce">💕</span>
        <span x-text="toastMessage"></span>
    </div>

    {{-- ======================================================== --}}
    {{-- 1. FULLSCREEN OPENING COVER (Full Edge-to-Edge, No Photo) --}}
    {{-- ======================================================== --}}
    <section
        x-ref="coverSection"
        x-show="isCoverVisible"
        x-transition:leave="transition-all duration-700 ease-in-out transform"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full pointer-events-none"
        class="fixed inset-0 z-50 w-full min-h-screen min-h-[100dvh] h-full flex flex-col justify-between items-center text-center p-6 bg-gradient-to-b from-[#FFF5F8] via-[#FFE3E8] to-[#FFF0F3] overflow-hidden select-none"
    >
        {{-- Cute floating background stickers --}}
        <div class="absolute -top-6 -right-6 text-6xl opacity-35 animate-float pointer-events-none">🌸</div>
        <div class="absolute -bottom-6 -left-6 text-6xl opacity-35 animate-float pointer-events-none" style="animation-delay: 1.5s;">🧸</div>
        <div class="absolute top-1/4 -left-4 text-4xl opacity-25 animate-pulse pointer-events-none">✨</div>
        <div class="absolute bottom-1/3 -right-3 text-4xl opacity-25 animate-pulse pointer-events-none">💖</div>

        {{-- Top Ribbon Badge --}}
        <div class="relative z-10 {{ isset($isDemo) && $isDemo ? 'pt-16 sm:pt-20' : 'pt-4 sm:pt-6' }}">
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/95 border border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-xs font-bold uppercase tracking-wider shadow-sm">
                <span>🌸</span>
                <span>The Wedding Invitation</span>
                <span>🌸</span>
            </div>
        </div>

        {{-- Couple Nicknames with Romantic Script (Clean, Centered, Elegant) --}}
        <div class="relative z-10 my-auto py-6 space-y-2 max-w-sm w-full">
            <div class="w-16 h-16 mx-auto rounded-full bg-white/95 border-2 border-[#FFD1DC] shadow-md flex items-center justify-center text-2xl text-[#FF4D6D] mb-2">
                💍
            </div>
            <h1 class="font-script text-5xl sm:text-6xl text-[#FF4D6D] leading-tight">
                {{ $groomNickname }} & {{ $brideNickname }}
            </h1>
            <p class="font-cute-heading text-xs text-[#7A5C61] tracking-widest uppercase font-semibold">
                Kami Akan Menikah!
            </p>
            <p class="font-cute-heading text-[11px] text-[#A88B92] tracking-wider">
                {{ $eventFormattedDate }}
            </p>
        </div>

        {{-- Personal Guest Box & Buka Undangan Button (NO PHOTO as requested) --}}
        <div class="relative z-10 w-full max-w-sm pb-6 sm:pb-8 space-y-3.5">
            <div class="bg-white/95 border-2 border-[#FFCCD5] rounded-2xl p-4 shadow-lg backdrop-blur-sm">
                <p class="font-cute-heading text-[11px] text-[#7A5C61] uppercase tracking-wider font-semibold mb-1">
                    Kepada Yth. Sahabat Tercinta:
                </p>
                <p class="font-cute-heading text-lg sm:text-xl font-bold text-[#FF4D6D] truncate">
                    {{ $displayGuest }}
                </p>
                <span class="font-cute-heading text-[11px] text-[#7A5C61] block mt-0.5">
                    di Tempat
                </span>
            </div>

            {{-- Buka Undangan Button --}}
            <button
                type="button"
                @click="openInvitation()"
                class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#FF4D6D] via-[#FF758F] to-[#FF4D6D] text-white font-cute-heading text-sm font-bold shadow-xl shadow-[#FF4D6D]/35 hover:scale-102 active:scale-95 transition-all flex items-center justify-center gap-2.5 cursor-pointer group"
            >
                <span class="animate-heart text-lg">💌</span>
                <span>Buka Undangan Ceria</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform"></i>
            </button>

            <p class="font-cute-heading text-[11px] text-[#7A5C61]">
                *Ketuk tombol untuk membuka undangan & memutar alunan musik
            </p>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 2. MAIN MOBILE-FIRST CONTAINER (Max-W 480px, Centered)  --}}
    {{-- ======================================================== --}}
    <main
        id="mainContainer"
        class="max-w-[480px] mx-auto min-h-screen bg-[#FFF5F8] {{ request()->has('embed') ? '' : 'shadow-2xl border-x-2 border-[#FFCCD5]/60' }} relative overflow-hidden pb-24"
        :class="{ 'h-screen max-h-screen overflow-hidden pointer-events-none': isCoverVisible }"
    >
        {{-- FLOATING MUSIC BUTTON --}}
        <div
            x-show="isUnlocked"
            x-cloak
            class="fixed top-5 right-5 z-40"
        >
            <button
                type="button"
                @click="toggleAudio()"
                class="w-11 h-11 rounded-full bg-white/90 border-2 border-[#FFCCD5] shadow-xl backdrop-blur-md flex items-center justify-center text-[#FF4D6D] hover:scale-105 active:scale-95 transition cursor-pointer"
                :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
            >
                <div :class="isPlaying ? 'animate-vinyl' : 'paused'">
                    <i class="fa-solid fa-compact-disc text-xl"></i>
                </div>
            </button>
        </div>

        {{-- STICKY BOTTOM NAVIGATION BAR --}}
        <nav
            x-show="isUnlocked"
            x-cloak
            class="fixed bottom-3 inset-x-0 mx-auto z-40 max-w-[440px] px-3"
        >
            <div class="bg-white/95 border-2 border-[#FFCCD5] backdrop-blur-lg rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#7A5C61]">
                <a href="#cover" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">🏠</span>
                    <span>Sampul</span>
                </a>
                <a href="#mempelai" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">💑</span>
                    <span>Pasangan</span>
                </a>
                <a href="#acara" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">📅</span>
                    <span>Acara</span>
                </a>
                <a href="#galeri" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">📸</span>
                    <span>Galeri</span>
                </a>
                <a href="#kado" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">🎁</span>
                    <span>Kado</span>
                </a>
                <a href="#rsvp" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-semibold">
                    <span class="text-sm">💌</span>
                    <span>RSVP</span>
                </a>
            </div>
        </nav>

        {{-- ======================================================== --}}
        {{-- SECTION 1: HERO / COVER BANNER                           --}}
        {{-- ======================================================== --}}
        <section id="cover" class="relative pt-12 pb-10 px-6 text-center overflow-hidden">
            {{-- Decorative circles --}}
            <div class="w-20 h-20 rounded-full bg-[#FFD1DC]/40 blur-2xl absolute -top-5 -left-5"></div>
            <div class="w-24 h-24 rounded-full bg-[#FFE3E8]/50 blur-2xl absolute top-10 -right-5"></div>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-[11px] font-bold uppercase mb-4 shadow-xs">
                <span>✨</span>
                <span>The Wedding Celebration</span>
                <span>✨</span>
            </div>

            <h1 class="font-script text-6xl text-[#FF4D6D] mb-1">
                {{ $groomNickname }} & {{ $brideNickname }}
            </h1>
            <p class="font-cute-heading text-xs font-bold text-[#7A5C61] uppercase tracking-widest mb-6">
                {{ $eventFormattedDate }}
            </p>

            {{-- Couple Polaroid Stack --}}
            <div class="relative w-64 h-64 mx-auto mb-6">
                <div class="w-full h-full bg-white p-3 rounded-3xl shadow-xl border-2 border-[#FFD1DC] rotate-1">
                    <img
                        src="{{ $groomPhoto }}"
                        alt="Prewed Couple"
                        class="w-full h-full object-cover rounded-2xl"
                    >
                </div>
                <div class="absolute -bottom-3 -right-3 bg-white px-3 py-1 rounded-full border-2 border-[#FFD1DC] shadow-md font-cute-heading text-xs font-bold text-[#FF4D6D] flex items-center gap-1">
                    <span>💍</span> Forever & Always
                </div>
            </div>

            {{-- Holy Verse / Sweet Quote --}}
            <div class="bg-white/80 border border-[#FFCCD5] rounded-2xl p-5 shadow-xs max-w-sm mx-auto">
                <p class="font-cute-heading text-xs italic text-[#7A5C61] leading-relaxed">
                    "{{ $holyVerse }}"
                </p>
                <p class="font-cute-heading text-[11px] font-bold text-[#FF4D6D] mt-2">
                    {{ $holyVerseSource }}
                </p>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 2: MEMPELAI (GROOM & BRIDE)                      --}}
        {{-- ======================================================== --}}
        <section id="mempelai" class="py-10 px-6 space-y-6">
            <div class="text-center">
                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">Pasangan Berbahagia</span>
                <h2 class="font-cute-heading text-2xl font-bold text-[#3D2A2E] mt-0.5">Dua Hati, Satu Janji</h2>
            </div>

            {{-- Groom Card --}}
            <div class="bg-white border-2 border-[#FFD1DC] rounded-3xl p-5 shadow-sm text-center relative overflow-hidden">
                <span class="absolute top-3 right-3 text-2xl">🤵🏻</span>
                <div class="w-28 h-28 mx-auto rounded-2xl overflow-hidden border-2 border-[#FFCCD5] shadow-md mb-3 rotate-[-1deg]">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-cute-heading text-lg font-bold text-[#FF4D6D]">{{ $groomFullName }}</h3>
                <p class="font-cute-heading text-xs text-[#7A5C61] mt-1">{{ $groomParents }}</p>
                <p class="text-xs text-[#7A5C61] mt-2 italic px-2">"{{ $groomBio }}"</p>
                @if($groomInstagram)
                    <a
                        href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFF0F3] border border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-[11px] font-bold mt-3 hover:bg-[#FFE3E8] transition"
                    >
                        <i class="fa-brands fa-instagram"></i>
                        <span>{{ $groomInstagram }}</span>
                    </a>
                @endif
            </div>

            {{-- Love Divider --}}
            <div class="flex items-center justify-center gap-3 text-[#FF4D6D]">
                <div class="h-0.5 w-16 bg-[#FFCCD5]"></div>
                <span class="text-xl animate-heart">💖</span>
                <div class="h-0.5 w-16 bg-[#FFCCD5]"></div>
            </div>

            {{-- Bride Card --}}
            <div class="bg-white border-2 border-[#FFD1DC] rounded-3xl p-5 shadow-sm text-center relative overflow-hidden">
                <span class="absolute top-3 right-3 text-2xl">👰🏻</span>
                <div class="w-28 h-28 mx-auto rounded-2xl overflow-hidden border-2 border-[#FFCCD5] shadow-md mb-3 rotate-1">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-cute-heading text-lg font-bold text-[#FF4D6D]">{{ $brideFullName }}</h3>
                <p class="font-cute-heading text-xs text-[#7A5C61] mt-1">{{ $brideParents }}</p>
                <p class="text-xs text-[#7A5C61] mt-2 italic px-2">"{{ $brideBio }}"</p>
                @if($brideInstagram)
                    <a
                        href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFF0F3] border border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-[11px] font-bold mt-3 hover:bg-[#FFE3E8] transition"
                    >
                        <i class="fa-brands fa-instagram"></i>
                        <span>{{ $brideInstagram }}</span>
                    </a>
                @endif
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 3: ACARA & COUNTDOWN                             --}}
        {{-- ======================================================== --}}
        <section id="acara" class="py-10 px-6 space-y-6 bg-white/60 border-y border-[#FFCCD5]">
            <div class="text-center">
                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">Waktu & Lokasi</span>
                <h2 class="font-cute-heading text-2xl font-bold text-[#3D2A2E] mt-0.5">Rangkaian Acara Bahagia</h2>
            </div>

            {{-- COUNTDOWN TIMER BUBBLES --}}
            <div class="bg-white border-2 border-[#FFCCD5] rounded-3xl p-4 shadow-sm text-center">
                <p class="font-cute-heading text-xs font-bold text-[#7A5C61] uppercase tracking-wider mb-3">
                    Hitung Mundur Hari Bahagia ⏳
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <div class="bg-[#FFF5F8] border border-[#FFCCD5] rounded-2xl p-2.5">
                        <span class="font-cute-heading text-xl font-bold text-[#FF4D6D] block" x-text="days">0</span>
                        <span class="font-cute-heading text-[10px] text-[#7A5C61]">Hari</span>
                    </div>
                    <div class="bg-[#FFF5F8] border border-[#FFCCD5] rounded-2xl p-2.5">
                        <span class="font-cute-heading text-xl font-bold text-[#FF4D6D] block" x-text="hours">0</span>
                        <span class="font-cute-heading text-[10px] text-[#7A5C61]">Jam</span>
                    </div>
                    <div class="bg-[#FFF5F8] border border-[#FFCCD5] rounded-2xl p-2.5">
                        <span class="font-cute-heading text-xl font-bold text-[#FF4D6D] block" x-text="minutes">0</span>
                        <span class="font-cute-heading text-[10px] text-[#7A5C61]">Menit</span>
                    </div>
                    <div class="bg-[#FFF5F8] border border-[#FFCCD5] rounded-2xl p-2.5">
                        <span class="font-cute-heading text-xl font-bold text-[#FF4D6D] block" x-text="seconds">0</span>
                        <span class="font-cute-heading text-[10px] text-[#7A5C61]">Detik</span>
                    </div>
                </div>

                {{-- Add to Google Calendar --}}
                @php
                    $calTitle = rawurlencode($story->title);
                    $calDates = $eventDate->format('Ymd\THis\Z') . '/' . $eventDate->copy()->addHours(5)->format('Ymd\THis\Z');
                    $calLocation = rawurlencode($ceremonyVenue . ', ' . $ceremonyAddress);
                    $calDetails = rawurlencode("Undangan Pernikahan {$story->title}\nLihat detail: " . url()->current());
                    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calDates}&details={$calDetails}&location={$calLocation}";
                @endphp
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    class="mt-3.5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#FFF0F3] border border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-xs font-bold hover:bg-[#FFE3E8] transition shadow-xs"
                >
                    <i class="fa-solid fa-calendar-plus"></i>
                    <span>Simpan Tanggal ke Google Calendar</span>
                </a>
            </div>

            {{-- Akad Nikah Card --}}
            <div class="bg-white border-2 border-[#FFD1DC] rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-[#FFF0F3] text-[#FF4D6D] flex items-center justify-center font-bold text-sm">💍</span>
                    <h3 class="font-cute-heading text-base font-bold text-[#3D2A2E]">Akad Nikah / Pemberkatan</h3>
                </div>
                <div class="text-xs text-[#7A5C61] space-y-1 font-cute-heading">
                    <p><i class="fa-regular fa-calendar text-[#FF4D6D] w-4"></i> {{ $eventFormattedDate }}</p>
                    <p><i class="fa-regular fa-clock text-[#FF4D6D] w-4"></i> {{ $ceremonyTime }}</p>
                    <p><i class="fa-solid fa-location-dot text-[#FF4D6D] w-4"></i> <strong>{{ $ceremonyVenue }}</strong></p>
                    <p class="text-[11px] text-[#7A5C61] pl-4">{{ $ceremonyAddress }}</p>
                </div>
                <a
                    href="{{ $ceremonyMapsUrl }}"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#FF4D6D] text-white font-cute-heading text-xs font-bold shadow-xs hover:bg-[#e03b5a] transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Buka Google Maps</span>
                </a>
            </div>

            {{-- Resepsi Card --}}
            <div class="bg-white border-2 border-[#FFD1DC] rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-[#FFF0F3] text-[#FF4D6D] flex items-center justify-center font-bold text-sm">🎉</span>
                    <h3 class="font-cute-heading text-base font-bold text-[#3D2A2E]">Resepsi Pernikahan Ceria</h3>
                </div>
                <div class="text-xs text-[#7A5C61] space-y-1 font-cute-heading">
                    <p><i class="fa-regular fa-calendar text-[#FF4D6D] w-4"></i> {{ $eventFormattedDate }}</p>
                    <p><i class="fa-regular fa-clock text-[#FF4D6D] w-4"></i> {{ $receptionTime }}</p>
                    <p><i class="fa-solid fa-location-dot text-[#FF4D6D] w-4"></i> <strong>{{ $receptionVenue }}</strong></p>
                    <p class="text-[11px] text-[#7A5C61] pl-4">{{ $receptionAddress }}</p>
                </div>
                <a
                    href="{{ $receptionMapsUrl }}"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#FF4D6D] text-white font-cute-heading text-xs font-bold shadow-xs hover:bg-[#e03b5a] transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Petunjuk Arah Rute</span>
                </a>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 4: GALERI PRE-WEDDING & LIGHTBOX                 --}}
        {{-- ======================================================== --}}
        <section id="galeri" class="py-10 px-6 space-y-5">
            <div class="text-center">
                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">Momen Terindah</span>
                <h2 class="font-cute-heading text-2xl font-bold text-[#3D2A2E] mt-0.5">Galeri Kenangan Manis</h2>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                @forelse($story->media as $idx => $item)
                    <div
                        @click="openLightbox('{{ $item->url }}', '{{ addslashes($item->caption ?? '') }}')"
                        class="bg-white p-2 rounded-2xl border-2 border-[#FFD1DC] shadow-sm hover:scale-102 transition cursor-pointer rotate-{{ ($idx % 2 === 0) ? '1' : '-1' }}"
                    >
                        <div class="aspect-square rounded-xl overflow-hidden mb-1.5">
                            <img src="{{ $item->url }}" alt="{{ $item->caption }}" class="w-full h-full object-cover">
                        </div>
                        @if($item->caption)
                            <p class="font-cute-heading text-[10px] text-[#7A5C61] text-center truncate px-1">
                                {{ $item->caption }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 bg-white/70 rounded-2xl border border-[#FFCCD5]">
                        <span class="text-3xl">📸</span>
                        <p class="font-cute-heading text-xs text-[#7A5C61] mt-2">Momen foto pre-wedding segera hadir.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 5: KADO DIGITAL / TANDA KASIH                    --}}
        {{-- ======================================================== --}}
        <section id="kado" class="py-10 px-6 space-y-5 bg-white/60 border-t border-[#FFCCD5]">
            <div class="text-center">
                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">Tanda Kasih</span>
                <h2 class="font-cute-heading text-2xl font-bold text-[#3D2A2E] mt-0.5">Amplop & Kado Digital</h2>
                <p class="text-xs text-[#7A5C61] max-w-xs mx-auto mt-1">
                    Doa restu Anda adalah kado terindah bagi kami. Bagi yang ingin berbagi tanda kasih secara cashless:
                </p>
            </div>

            {{-- Bank Card 1 --}}
            <div class="bg-gradient-to-r from-[#FFF0F3] to-[#FFE3E8] border-2 border-[#FFCCD5] rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">{{ $bcaName }}</span>
                    <i class="fa-solid fa-credit-card text-[#FF4D6D] text-lg"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#3D2A2E] tracking-wider">{{ $bcaNumber }}</p>
                <p class="font-cute-heading text-xs text-[#7A5C61]">a.n {{ $bcaHolder }}</p>
                <button
                    type="button"
                    @click="copyText('{{ $bcaNumber }}', 'Nomor rekening {{ $bcaName }} berhasil disalin!')"
                    class="w-full py-2 rounded-xl bg-white text-[#FF4D6D] border border-[#FFCCD5] font-cute-heading text-xs font-bold hover:bg-[#FFF0F3] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Nomor Rekening</span>
                </button>
            </div>

            {{-- Bank Card 2 --}}
            <div class="bg-gradient-to-r from-[#FFF5F8] to-[#FFEBEF] border-2 border-[#FFCCD5] rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">{{ $mandiriName }}</span>
                    <i class="fa-solid fa-wallet text-[#FF4D6D] text-lg"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#3D2A2E] tracking-wider">{{ $mandiriNumber }}</p>
                <p class="font-cute-heading text-xs text-[#7A5C61]">a.n {{ $mandiriHolder }}</p>
                <button
                    type="button"
                    @click="copyText('{{ $mandiriNumber }}', 'Nomor rekening {{ $mandiriName }} berhasil disalin!')"
                    class="w-full py-2 rounded-xl bg-white text-[#FF4D6D] border border-[#FFCCD5] font-cute-heading text-xs font-bold hover:bg-[#FFF0F3] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Nomor Rekening</span>
                </button>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 6: BUKU TAMU & RSVP                              --}}
        {{-- ======================================================== --}}
        <section id="rsvp" class="py-10 px-6 space-y-5">
            <div class="text-center">
                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">Konfirmasi Kehadiran</span>
                <h2 class="font-cute-heading text-2xl font-bold text-[#3D2A2E] mt-0.5">Buku Tamu & Doa Restu</h2>
            </div>

            {{-- RSVP FORM --}}
            <form
                @submit.prevent="submitRsvp()"
                class="bg-white border-2 border-[#FFCCD5] rounded-3xl p-5 shadow-sm space-y-4"
            >
                <div>
                    <label class="block font-cute-heading text-xs font-bold text-[#3D2A2E] mb-1">Nama Anda</label>
                    <input
                        type="text"
                        x-model="formGuestName"
                        required
                        placeholder="Tuliskan nama Anda..."
                        class="w-full bg-[#FFF5F8] border border-[#FFCCD5] rounded-xl px-3.5 py-2.5 text-xs text-[#3D2A2E] focus:outline-none focus:border-[#FF4D6D]"
                    >
                </div>

                <div>
                    <label class="block font-cute-heading text-xs font-bold text-[#3D2A2E] mb-1.5">Konfirmasi Kehadiran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="p-2 rounded-xl border cursor-pointer text-center text-xs font-cute-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'attending' ? 'bg-[#FF4D6D] text-white border-[#FF4D6D]' : 'bg-[#FFF5F8] text-[#7A5C61] border-[#FFCCD5]'">
                            <input type="radio" value="attending" x-model="formAttendance" class="sr-only">
                            <span>🥰</span>
                            <span class="text-[10px] font-bold">Hadir</span>
                        </label>
                        <label class="p-2 rounded-xl border cursor-pointer text-center text-xs font-cute-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'maybe' ? 'bg-[#FF4D6D] text-white border-[#FF4D6D]' : 'bg-[#FFF5F8] text-[#7A5C61] border-[#FFCCD5]'">
                            <input type="radio" value="maybe" x-model="formAttendance" class="sr-only">
                            <span>🤔</span>
                            <span class="text-[10px] font-bold">Ragu</span>
                        </label>
                        <label class="p-2 rounded-xl border cursor-pointer text-center text-xs font-cute-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'absent' ? 'bg-[#FF4D6D] text-white border-[#FF4D6D]' : 'bg-[#FFF5F8] text-[#7A5C61] border-[#FFCCD5]'">
                            <input type="radio" value="absent" x-model="formAttendance" class="sr-only">
                            <span>🥺</span>
                            <span class="text-[10px] font-bold">Maaf</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-cute-heading text-xs font-bold text-[#3D2A2E] mb-1">Jumlah Tamu</label>
                    <select
                        x-model="formGuestCount"
                        class="w-full bg-[#FFF5F8] border border-[#FFCCD5] rounded-xl px-3.5 py-2.5 text-xs text-[#3D2A2E] focus:outline-none focus:border-[#FF4D6D]"
                    >
                        <option value="1">1 Orang</option>
                        <option value="2">2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                    </select>
                </div>

                <div>
                    <label class="block font-cute-heading text-xs font-bold text-[#3D2A2E] mb-1">Doa & Ucapan Manis</label>
                    <textarea
                        x-model="formWishes"
                        required
                        rows="3"
                        placeholder="Tuliskan ucapan selamat & doa tulus Anda..."
                        class="w-full bg-[#FFF5F8] border border-[#FFCCD5] rounded-xl px-3.5 py-2.5 text-xs text-[#3D2A2E] focus:outline-none focus:border-[#FF4D6D]"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    :disabled="isSubmittingRsvp"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-[#FF4D6D] to-[#FF758F] text-white font-cute-heading text-xs font-bold shadow-md hover:opacity-95 transition flex items-center justify-center gap-1.5 cursor-pointer disabled:opacity-50"
                >
                    <span x-show="!isSubmittingRsvp">💌 Kirim Ucapan & RSVP</span>
                    <span x-show="isSubmittingRsvp" x-cloak>Sedang mengirim...</span>
                </button>
            </form>

            {{-- LIVE WISHES FEED --}}
            <div class="space-y-3">
                <h4 class="font-cute-heading text-xs font-bold text-[#7A5C61] uppercase tracking-wider">
                    Ucapan Dari Sahabat Tercinta (<span x-text="rsvps.length"></span>)
                </h4>
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    <template x-for="(w, idx) in rsvps" :key="idx">
                        <div class="bg-white border border-[#FFCCD5] rounded-2xl p-3.5 shadow-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-cute-heading text-xs font-bold text-[#FF4D6D]" x-text="w.guest_name"></span>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[9px] font-cute-heading font-bold"
                                    :class="w.attendance_status === 'attending' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'"
                                    x-text="w.attendance_status === 'attending' ? 'Hadir 🥰' : 'Berhalangan 🥺'"
                                ></span>
                            </div>
                            <p class="text-xs text-[#3D2A2E] font-cute-heading leading-relaxed" x-text="w.wishes"></p>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="py-8 text-center border-t border-[#FFCCD5]/80 space-y-1">
            <p class="font-script text-2xl text-[#FF4D6D]">{{ $groomNickname }} & {{ $brideNickname }}</p>
            <p class="font-cute-heading text-[10px] text-[#A88B92]">Digital Invitation by Maja Flower Studio</p>
        </footer>

        {{-- LIGHTBOX MODAL --}}
        <div
            x-show="lightboxOpen"
            x-cloak
            @click.self="closeLightbox()"
            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        >
            <div class="relative max-w-sm w-full bg-white rounded-3xl p-3 text-center">
                <button
                    type="button"
                    @click="closeLightbox()"
                    class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#FF4D6D] text-white flex items-center justify-center font-bold text-xs shadow-md"
                >✕</button>
                <img :src="lightboxImg" class="w-full rounded-2xl aspect-square object-cover mb-2">
                <p class="font-cute-heading text-xs text-[#7A5C61]" x-text="lightboxCaption"></p>
            </div>
        </div>
    </main>

    {{-- SCRIPT ALPINE COMPONENT --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('weddingCuteApp', (config) => ({
                isUnlocked: false,
                isCoverVisible: true,
                isPlaying: false,
                toastOpen: false,
                toastMessage: '',
                lightboxOpen: false,
                lightboxImg: '',
                lightboxCaption: '',
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                formGuestName: '{{ addslashes($displayGuest) }}',
                formAttendance: 'attending',
                formGuestCount: '1',
                formWishes: '',
                isSubmittingRsvp: false,
                rsvps: @json($story->rsvps ?? []),

                init() {
                    this.startCountdown(config.eventDate);
                },

                openInvitation() {
                    this.isUnlocked = true;
                    this.isCoverVisible = false;

                    document.documentElement.classList.remove('scroll-locked');
                    document.body.classList.remove('scroll-locked');

                    this.playAudio();

                    if (window.confetti) {
                        confetti({
                            particleCount: 80,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#FF4D6D', '#FF758F', '#FFAFCC', '#FFE3E8', '#FFCCD5']
                        });
                    }
                },

                playAudio() {
                    const audio = this.$refs.audioPlayer;
                    if (audio) {
                        audio.play().then(() => {
                            this.isPlaying = true;
                        }).catch(() => {
                            this.isPlaying = false;
                        });
                    }
                },

                toggleAudio() {
                    const audio = this.$refs.audioPlayer;
                    if (!audio) return;
                    if (audio.paused) {
                        audio.play();
                        this.isPlaying = true;
                    } else {
                        audio.pause();
                        this.isPlaying = false;
                    }
                },

                startCountdown(targetDate) {
                    const target = new Date(targetDate).getTime();
                    const tick = () => {
                        const now = new Date().getTime();
                        const diff = target - now;
                        if (diff > 0) {
                            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        }
                    };
                    tick();
                    setInterval(tick, 1000);
                },

                copyText(text, msg) {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(() => {
                            this.showToast(msg);
                        });
                    }
                },

                showToast(msg) {
                    this.toastMessage = msg;
                    this.toastOpen = true;
                    setTimeout(() => { this.toastOpen = false; }, 3000);
                },

                openLightbox(img, caption) {
                    this.lightboxImg = img;
                    this.lightboxCaption = caption;
                    this.lightboxOpen = true;
                },

                closeLightbox() {
                    this.lightboxOpen = false;
                },

                submitRsvp() {
                    if (config.isDemo) {
                        this.rsvps.unshift({
                            guest_name: this.formGuestName,
                            attendance_status: this.formAttendance,
                            guest_count: parseInt(this.formGuestCount),
                            wishes: this.formWishes
                        });
                        this.showToast('Ucapan doa restu berhasil dikirim (Mode Demo)! 💕');
                        this.formWishes = '';
                        return;
                    }

                    this.isSubmittingRsvp = true;
                    fetch(`/s/${config.slug}/rsvp`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            guest_name: this.formGuestName,
                            attendance_status: this.formAttendance,
                            guest_count: this.formGuestCount,
                            wishes: this.formWishes
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.isSubmittingRsvp = false;
                        if (data.success) {
                            this.rsvps.unshift({
                                guest_name: this.formGuestName,
                                attendance_status: this.formAttendance,
                                wishes: this.formWishes
                            });
                            this.showToast(data.message || 'Terima kasih atas doa restunya!');
                            this.formWishes = '';
                        }
                    })
                    .catch(() => {
                        this.isSubmittingRsvp = false;
                        this.showToast('Gagal mengirim RSVP. Silakan coba kembali.');
                    });
                }
            }));
        });
    </script>
</body>
</html>
