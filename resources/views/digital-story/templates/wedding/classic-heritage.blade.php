<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — Undangan Klasik Heritage Botanical | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-classic-heading { font-family: 'Cormorant Garamond', Georgia, serif; }
        .font-cursive { font-family: 'Great Vibes', cursive; }

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
        @keyframes gramophone-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-gramophone {
            animation: gramophone-spin 9s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Vintage Parchment Texture pattern */
        .bg-parchment {
            background-color: #FAF6EE;
            background-image: radial-gradient(#E8DEC8 0.75px, transparent 0.75px);
            background-size: 16px 16px;
        }

        /* Sleek Antique Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(140, 109, 70, 0.4); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(140, 109, 70, 0.7); }
        * { scrollbar-width: thin; scrollbar-color: rgba(140, 109, 70, 0.4) transparent; }
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
    $displayGuest = $guestName ? trim($guestName) : 'Bapak/Ibu/Saudara/i';

    $meta = is_array($story->metadata) ? $story->metadata : [];

    $groomNickname = $meta['groom_nickname'] ?? 'Arya';
    $brideNickname = $meta['bride_nickname'] ?? 'Dyah';

    $groomFullName = $meta['groom_full_name'] ?? ($story->sender_name ?: 'Raden Arya Kusuma, S.H.');
    $groomParents = $meta['groom_parents'] ?? 'Putra pertama dari Bpk. Ir. H. Bambang Kusuma & Ibu Hj. Ratna Sari';
    $groomInstagram = $meta['groom_instagram'] ?? '@aryakusuma';
    $groomBio = $meta['groom_bio'] ?? 'Pribadi bersahaja, pelindung keluarga, dan sosok pemimpin bijaksana.';
    $groomPhoto = $meta['groom_photo'] ?? 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80';

    $brideFullName = $meta['bride_full_name'] ?? ($story->recipient_name ?: 'Dyah Sekar Ayu, S.Psi.');
    $brideParents = $meta['bride_parents'] ?? 'Putri bungsu dari Bpk. H. Suryo Pranoto & Ibu Hj. Siti Rohmah';
    $brideInstagram = $meta['bride_instagram'] ?? '@dyahayusekar';
    $brideBio = $meta['bride_bio'] ?? 'Lemah lembut, anggun, dan senantiasa menyejukkan hati di setiap suasana.';
    $bridePhoto = $meta['bride_photo'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80';

    $eventDate = $story->event_date ?? \Carbon\Carbon::now()->addDays(28)->setHour(9)->setMinute(0);
    $eventDateIso = $eventDate->toIso8601String();
    $eventFormattedDate = $eventDate->translatedFormat('l, d F Y');

    $ceremonyTime = $meta['ceremony_time'] ?? '08.30 - 10.30 WIB';
    $ceremonyVenue = $meta['venue_name'] ?? 'Pendopo Heritage Grand Ballroom Maja';
    $ceremonyAddress = $meta['venue_address'] ?? 'Jl. Cendana Asri No. 8, Kebayoran Baru, Jakarta Selatan';

    $receptionTime = $meta['reception_time'] ?? '11.30 - 15.00 WIB';
    $receptionVenue = $meta['venue_name'] ?? 'Pendopo Heritage Grand Ballroom Maja';
    $receptionAddress = $meta['venue_address'] ?? 'Jl. Cendana Asri No. 8, Kebayoran Baru, Jakarta Selatan';

    $mapsUrl = $meta['maps_url'] ?? 'https://maps.google.com/?q=Jakarta';

    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3');
    $audioTitle = $story->audio_title ?: 'Canon in D (Classical Heritage Strings)';

    $bcaNumber = $meta['bank_bca_number'] ?? '8020 7766 55';
    $bcaHolder = $meta['bank_bca_holder'] ?? 'Raden Arya Kusuma';
    $mandiriNumber = $meta['bank_mandiri_number'] ?? '137 00 8877 665';
    $mandiriHolder = $meta['bank_mandiri_holder'] ?? 'Dyah Sekar Ayu';
@endphp

<body
    x-data="weddingClassicApp({
        eventDate: '{{ $eventDateIso }}',
        audioUrl: '{{ $audioTrack }}',
        audioTitle: '{{ addslashes($audioTitle) }}',
        slug: '{{ $story->slug }}',
        isDemo: {{ isset($isDemo) && $isDemo ? 'true' : 'false' }}
    })"
    class="{{ request()->has('embed') ? 'bg-[#FAF6EE]' : 'bg-[#1E231D]' }} text-[#2C2117] font-sans antialiased min-h-screen selection:bg-[#8C6D46] selection:text-white relative overflow-x-hidden scroll-locked"
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
        x-transition
        class="fixed top-5 inset-x-0 mx-auto z-50 w-max max-w-sm px-4 py-2.5 rounded-xl bg-[#FAF6EE] border border-[#8C6D46] text-[#634832] shadow-2xl flex items-center gap-2.5 font-classic-heading text-sm font-bold"
    >
        <span class="text-base text-[#8C6D46]">📜</span>
        <span x-text="toastMessage"></span>
    </div>

    {{-- ======================================================== --}}
    {{-- 1. FULLSCREEN OPENING COVER (Classic Wax Seal & Frame)   --}}
    {{-- ======================================================== --}}
    <section
        x-ref="coverSection"
        x-show="isCoverVisible"
        x-transition:leave="transition-all duration-1000 ease-in-out"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gradient-to-b from-[#1E231D] via-[#2A3029] to-[#1E231D]"
    >
        <div class="w-full max-w-[440px] bg-[#FAF6EE] rounded-3xl border-2 border-[#8C6D46]/40 p-7 text-center shadow-2xl relative overflow-hidden">
            {{-- Botanical border corners --}}
            <div class="absolute top-2 left-2 text-[#8C6D46]/30 text-xl font-classic-heading">❦</div>
            <div class="absolute top-2 right-2 text-[#8C6D46]/30 text-xl font-classic-heading">❧</div>
            <div class="absolute bottom-2 left-2 text-[#8C6D46]/30 text-xl font-classic-heading">❧</div>
            <div class="absolute bottom-2 right-2 text-[#8C6D46]/30 text-xl font-classic-heading">❦</div>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#F4EFE6] border border-[#8C6D46]/30 text-[#8C6D46] font-classic-heading text-xs uppercase tracking-widest mb-4">
                <span>🌿</span>
                <span>The Wedding of</span>
                <span>🌿</span>
            </div>

            <h1 class="font-cursive text-5xl sm:text-6xl text-[#634832] leading-tight mb-1">
                {{ $groomNickname }} & {{ $brideNickname }}
            </h1>
            <p class="font-classic-heading text-xs text-[#6B5A4B] uppercase tracking-widest font-semibold mb-6">
                Undangan Pernikahan Klasik
            </p>

            {{-- Oval Portrait Frame --}}
            <div class="relative w-40 h-48 mx-auto mb-6">
                <div class="w-full h-full rounded-[9999px] overflow-hidden border-4 border-[#8C6D46]/50 shadow-md p-1 bg-[#FAF6EE]">
                    <img src="{{ $groomPhoto }}" alt="Mempelai" class="w-full h-full object-cover rounded-[9999px] filter sepia-[0.15]">
                </div>
                <div class="absolute -bottom-2.5 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-[#8C6D46] text-[#FAF6EE] flex items-center justify-center text-xs font-classic-heading font-bold shadow-md">
                    ❦
                </div>
            </div>

            {{-- Guest Name Box --}}
            <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-4 mb-6">
                <p class="font-classic-heading text-xs text-[#6B5A4B] uppercase tracking-widest mb-1">
                    Kepada Yth. Bapak/Ibu/Saudara/i:
                </p>
                <p class="font-classic-heading text-lg font-bold text-[#2C2117] truncate">
                    {{ $displayGuest }}
                </p>
            </div>

            {{-- Buka Undangan Button (Wax Seal Style) --}}
            <button
                type="button"
                @click="openInvitation()"
                class="w-full py-3.5 px-6 rounded-2xl bg-[#8C6D46] hover:bg-[#725736] text-[#FAF6EE] font-classic-heading text-sm font-bold uppercase tracking-widest shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95"
            >
                <span class="text-base">📜</span>
                <span>Buka Undangan</span>
                <span class="text-xs">❦</span>
            </button>

            <p class="font-classic-heading text-[11px] text-[#8C6D46] mt-3 italic">
                *Ketuk untuk membuka lembaran undangan & melantunkan melodi
            </p>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 2. MAIN MOBILE-FIRST CONTAINER (Max-W 480px, Centered)  --}}
    {{-- ======================================================== --}}
    <main
        id="mainContainer"
        class="max-w-[480px] mx-auto min-h-screen bg-parchment {{ request()->has('embed') ? '' : 'shadow-2xl border-x-2 border-[#8C6D46]/20' }} relative overflow-hidden pb-24"
    >
        {{-- FLOATING MUSIC BUTTON (Gramophone) --}}
        <div
            x-show="isUnlocked"
            x-cloak
            class="fixed top-5 right-5 z-40"
        >
            <button
                type="button"
                @click="toggleAudio()"
                class="w-11 h-11 rounded-full bg-[#FAF6EE]/90 border border-[#8C6D46]/50 shadow-xl backdrop-blur-md flex items-center justify-center text-[#8C6D46] hover:scale-105 active:scale-95 transition cursor-pointer"
                :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
            >
                <div :class="isPlaying ? 'animate-gramophone' : 'paused'">
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
            <div class="bg-[#FAF6EE]/95 border border-[#8C6D46]/40 backdrop-blur-md rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#6B5A4B]">
                <a href="#cover" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">📜</span>
                    <span>Sampul</span>
                </a>
                <a href="#mempelai" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">💍</span>
                    <span>Mempelai</span>
                </a>
                <a href="#acara" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">📅</span>
                    <span>Acara</span>
                </a>
                <a href="#galeri" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">📸</span>
                    <span>Galeri</span>
                </a>
                <a href="#kado" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">🎁</span>
                    <span>Tanda Kasih</span>
                </a>
                <a href="#rsvp" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                    <span class="text-sm">✍️</span>
                    <span>RSVP</span>
                </a>
            </div>
        </nav>

        {{-- ======================================================== --}}
        {{-- SECTION 1: HERO / COVER BANNER                           --}}
        {{-- ======================================================== --}}
        <section id="cover" class="relative pt-12 pb-10 px-6 text-center">
            <div class="inline-flex items-center gap-2 text-xs font-classic-heading text-[#8C6D46] uppercase tracking-widest mb-3">
                <span>❦ Walimatul 'Ursy ❦</span>
            </div>

            <h1 class="font-cursive text-6xl text-[#634832] mb-1">
                {{ $groomNickname }} & {{ $brideNickname }}
            </h1>
            <p class="font-classic-heading text-xs font-semibold text-[#8C6D46] tracking-widest uppercase mb-6">
                {{ $eventFormattedDate }}
            </p>

            {{-- Classical Oval Portrait Frame --}}
            <div class="relative w-56 h-72 mx-auto mb-6">
                <div class="w-full h-full rounded-[9999px] overflow-hidden border-4 border-[#8C6D46]/60 shadow-xl p-1.5 bg-[#FAF6EE]">
                    <img src="{{ $bridePhoto }}" alt="Prewed" class="w-full h-full object-cover rounded-[9999px] filter sepia-[0.1]">
                </div>
            </div>

            {{-- Sacred Verse in Antique Parchment Box --}}
            <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-5 shadow-xs max-w-sm mx-auto text-center">
                <p class="font-classic-heading text-xs italic text-[#5C4A3C] leading-relaxed">
                    "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
                </p>
                <p class="font-classic-heading text-xs font-bold text-[#8C6D46] mt-2 uppercase tracking-wider">
                    — QS. Ar-Rum: 21 —
                </p>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 2: MEMPELAI (GROOM & BRIDE)                      --}}
        {{-- ======================================================== --}}
        <section id="mempelai" class="py-10 px-6 space-y-6">
            <div class="text-center">
                <span class="font-classic-heading text-xs font-semibold text-[#8C6D46] uppercase tracking-widest">Kedua Mempelai</span>
                <h2 class="font-classic-heading text-2xl font-bold text-[#2C2117] mt-0.5">Maha Suci Allah Yang Mempertemukan</h2>
            </div>

            {{-- Groom Card --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-6 shadow-sm text-center relative">
                <div class="w-28 h-36 mx-auto rounded-[9999px] overflow-hidden border-2 border-[#8C6D46]/60 shadow-sm mb-3">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-classic-heading text-xl font-bold text-[#634832]">{{ $groomFullName }}</h3>
                <p class="font-classic-heading text-xs text-[#6B5A4B] mt-1">{{ $groomParents }}</p>
                <p class="font-classic-heading text-xs text-[#5C4A3C] mt-2 italic px-3">"{{ $groomBio }}"</p>
                @if($groomInstagram)
                    <a
                        href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F4EFE6] border border-[#8C6D46]/30 text-[#8C6D46] font-classic-heading text-xs mt-3 hover:bg-[#E8DEC8] transition"
                    >
                        <i class="fa-brands fa-instagram text-xs"></i>
                        <span>{{ $groomInstagram }}</span>
                    </a>
                @endif
            </div>

            {{-- Classic Divider --}}
            <div class="flex items-center justify-center gap-3 text-[#8C6D46]">
                <div class="h-px w-20 bg-[#8C6D46]/40"></div>
                <span class="font-classic-heading text-base font-bold">❦ & ❦</span>
                <div class="h-px w-20 bg-[#8C6D46]/40"></div>
            </div>

            {{-- Bride Card --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-6 shadow-sm text-center relative">
                <div class="w-28 h-36 mx-auto rounded-[9999px] overflow-hidden border-2 border-[#8C6D46]/60 shadow-sm mb-3">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-classic-heading text-xl font-bold text-[#634832]">{{ $brideFullName }}</h3>
                <p class="font-classic-heading text-xs text-[#6B5A4B] mt-1">{{ $brideParents }}</p>
                <p class="font-classic-heading text-xs text-[#5C4A3C] mt-2 italic px-3">"{{ $brideBio }}"</p>
                @if($brideInstagram)
                    <a
                        href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F4EFE6] border border-[#8C6D46]/30 text-[#8C6D46] font-classic-heading text-xs mt-3 hover:bg-[#E8DEC8] transition"
                    >
                        <i class="fa-brands fa-instagram text-xs"></i>
                        <span>{{ $brideInstagram }}</span>
                    </a>
                @endif
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 3: ACARA & COUNTDOWN                             --}}
        {{-- ======================================================== --}}
        <section id="acara" class="py-10 px-6 space-y-6 bg-[#F4EFE6]/70 border-y border-[#8C6D46]/25">
            <div class="text-center">
                <span class="font-classic-heading text-xs font-semibold text-[#8C6D46] uppercase tracking-widest">Agenda Acara</span>
                <h2 class="font-classic-heading text-2xl font-bold text-[#2C2117] mt-0.5">Hari & Tempat Pelaksanaan</h2>
            </div>

            {{-- COUNTDOWN CLOCK --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm text-center">
                <p class="font-classic-heading text-xs font-bold text-[#6B5A4B] uppercase tracking-widest mb-3">
                    Hitung Mundur Hari Bahagia ⏳
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-2.5">
                        <span class="font-classic-heading text-2xl font-bold text-[#634832] block" x-text="days">0</span>
                        <span class="font-classic-heading text-xs text-[#6B5A4B]">Hari</span>
                    </div>
                    <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-2.5">
                        <span class="font-classic-heading text-2xl font-bold text-[#634832] block" x-text="hours">0</span>
                        <span class="font-classic-heading text-xs text-[#6B5A4B]">Jam</span>
                    </div>
                    <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-2.5">
                        <span class="font-classic-heading text-2xl font-bold text-[#634832] block" x-text="minutes">0</span>
                        <span class="font-classic-heading text-xs text-[#6B5A4B]">Menit</span>
                    </div>
                    <div class="bg-[#F4EFE6] border border-[#8C6D46]/30 rounded-2xl p-2.5">
                        <span class="font-classic-heading text-2xl font-bold text-[#634832] block" x-text="seconds">0</span>
                        <span class="font-classic-heading text-xs text-[#6B5A4B]">Detik</span>
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
                    class="mt-3.5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#F4EFE6] border border-[#8C6D46]/40 text-[#634832] font-classic-heading text-xs font-bold hover:bg-[#E8DEC8] transition shadow-xs"
                >
                    <i class="fa-solid fa-calendar-plus text-[#8C6D46]"></i>
                    <span>Simpan ke Google Calendar</span>
                </a>
            </div>

            {{-- Akad Card --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="text-[#8C6D46] text-lg font-classic-heading">❦</span>
                    <h3 class="font-classic-heading text-lg font-bold text-[#2C2117]">Akad Nikah Khidmat</h3>
                </div>
                <div class="text-xs text-[#6B5A4B] space-y-1 font-classic-heading">
                    <p><i class="fa-regular fa-calendar text-[#8C6D46] w-4"></i> {{ $eventFormattedDate }}</p>
                    <p><i class="fa-regular fa-clock text-[#8C6D46] w-4"></i> {{ $ceremonyTime }}</p>
                    <p><i class="fa-solid fa-location-dot text-[#8C6D46] w-4"></i> <strong>{{ $ceremonyVenue }}</strong></p>
                    <p class="text-[11px] text-[#6B5A4B] pl-4">{{ $ceremonyAddress }}</p>
                </div>
                <a
                    href="{{ $mapsUrl }}"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#8C6D46] text-[#FAF6EE] font-classic-heading text-xs font-bold uppercase tracking-wider hover:bg-[#725736] transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Petunjuk Arah Google Maps</span>
                </a>
            </div>

            {{-- Resepsi Card --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="text-[#8C6D46] text-lg font-classic-heading">❦</span>
                    <h3 class="font-classic-heading text-lg font-bold text-[#2C2117]">Syukuran Resepsi Pernikahan</h3>
                </div>
                <div class="text-xs text-[#6B5A4B] space-y-1 font-classic-heading">
                    <p><i class="fa-regular fa-calendar text-[#8C6D46] w-4"></i> {{ $eventFormattedDate }}</p>
                    <p><i class="fa-regular fa-clock text-[#8C6D46] w-4"></i> {{ $receptionTime }}</p>
                    <p><i class="fa-solid fa-location-dot text-[#8C6D46] w-4"></i> <strong>{{ $receptionVenue }}</strong></p>
                    <p class="text-[11px] text-[#6B5A4B] pl-4">{{ $receptionAddress }}</p>
                </div>
                <a
                    href="{{ $mapsUrl }}"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#8C6D46] text-[#FAF6EE] font-classic-heading text-xs font-bold uppercase tracking-wider hover:bg-[#725736] transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Petunjuk Arah Google Maps</span>
                </a>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 4: GALERI KENANGAN INDAH                         --}}
        {{-- ======================================================== --}}
        <section id="galeri" class="py-10 px-6 space-y-5">
            <div class="text-center">
                <span class="font-classic-heading text-xs font-semibold text-[#8C6D46] uppercase tracking-widest">Dokumentasi</span>
                <h2 class="font-classic-heading text-2xl font-bold text-[#2C2117] mt-0.5">Galeri Kenangan Indah</h2>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                @forelse($story->media as $idx => $item)
                    <div
                        @click="openLightbox('{{ $item->url }}', '{{ addslashes($item->caption ?? '') }}')"
                        class="bg-[#FAF6EE] p-2.5 rounded-2xl border border-[#8C6D46]/40 shadow-sm hover:scale-102 transition cursor-pointer"
                    >
                        <div class="aspect-square rounded-xl overflow-hidden mb-1.5 border border-[#8C6D46]/20">
                            <img src="{{ $item->url }}" alt="{{ $item->caption }}" class="w-full h-full object-cover filter sepia-[0.1]">
                        </div>
                        @if($item->caption)
                            <p class="font-classic-heading text-xs text-[#6B5A4B] text-center italic truncate px-1">
                                {{ $item->caption }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 bg-[#F4EFE6] rounded-2xl border border-[#8C6D46]/30">
                        <span class="text-3xl text-[#8C6D46]">📜</span>
                        <p class="font-classic-heading text-xs text-[#6B5A4B] mt-2 italic">Momen foto pre-wedding segera diabadikan.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SECTION 5: TANDA KASIH (DIGITAL GIFT)                    --}}
        {{-- ======================================================== --}}
        <section id="kado" class="py-10 px-6 space-y-5 bg-[#F4EFE6]/70 border-t border-[#8C6D46]/25">
            <div class="text-center">
                <span class="font-classic-heading text-xs font-semibold text-[#8C6D46] uppercase tracking-widest">Tanda Kasih</span>
                <h2 class="font-classic-heading text-2xl font-bold text-[#2C2117] mt-0.5">Hadiah & Doa Restu</h2>
                <p class="font-classic-heading text-xs text-[#6B5A4B] max-w-xs mx-auto mt-1 italic leading-relaxed">
                    Kehadiran dan doa restu Bapak/Ibu/Saudara/i sekalian merupakan karunia terindah bagi kami. Bagi yang bermaksud mengirimkan tanda kasih:
                </p>
            </div>

            {{-- Bank Card 1 --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-classic-heading text-xs font-bold text-[#8C6D46] uppercase tracking-wider">Bank BCA</span>
                    <i class="fa-solid fa-building-columns text-[#8C6D46]"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#2C2117] tracking-wider">{{ $bcaNumber }}</p>
                <p class="font-classic-heading text-xs text-[#6B5A4B]">a.n {{ $bcaHolder }}</p>
                <button
                    type="button"
                    @click="copyText('{{ $bcaNumber }}', 'Nomor rekening BCA berhasil disalin!')"
                    class="w-full py-2 rounded-xl bg-[#F4EFE6] text-[#634832] border border-[#8C6D46]/40 font-classic-heading text-xs font-bold uppercase tracking-wider hover:bg-[#E8DEC8] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Nomor Rekening</span>
                </button>
            </div>

            {{-- Bank Card 2 --}}
            <div class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-classic-heading text-xs font-bold text-[#8C6D46] uppercase tracking-wider">Bank Mandiri</span>
                    <i class="fa-solid fa-wallet text-[#8C6D46]"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#2C2117] tracking-wider">{{ $mandiriNumber }}</p>
                <p class="font-classic-heading text-xs text-[#6B5A4B]">a.n {{ $mandiriHolder }}</p>
                <button
                    type="button"
                    @click="copyText('{{ $mandiriNumber }}', 'Nomor rekening Mandiri berhasil disalin!')"
                    class="w-full py-2 rounded-xl bg-[#F4EFE6] text-[#634832] border border-[#8C6D46]/40 font-classic-heading text-xs font-bold uppercase tracking-wider hover:bg-[#E8DEC8] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
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
                <span class="font-classic-heading text-xs font-semibold text-[#8C6D46] uppercase tracking-widest">Konfirmasi Kehadiran</span>
                <h2 class="font-classic-heading text-2xl font-bold text-[#2C2117] mt-0.5">Buku Tamu & Untaian Doa</h2>
            </div>

            {{-- RSVP FORM --}}
            <form
                @submit.prevent="submitRsvp()"
                class="bg-[#FAF6EE] border border-[#8C6D46]/40 rounded-3xl p-5 shadow-sm space-y-4"
            >
                <div>
                    <label class="block font-classic-heading text-xs font-bold text-[#2C2117] mb-1">Nama Tamu Undangan</label>
                    <input
                        type="text"
                        x-model="formGuestName"
                        required
                        placeholder="Tuliskan nama lengkap Anda..."
                        class="w-full bg-[#F4EFE6] border border-[#8C6D46]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#2C2117] focus:outline-none focus:border-[#8C6D46]"
                    >
                </div>

                <div>
                    <label class="block font-classic-heading text-xs font-bold text-[#2C2117] mb-1.5">Konfirmasi Kehadiran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-classic-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'attending' ? 'bg-[#8C6D46] text-[#FAF6EE] border-[#8C6D46]' : 'bg-[#F4EFE6] text-[#6B5A4B] border-[#8C6D46]/30'">
                            <input type="radio" value="attending" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">❦</span>
                            <span class="text-[10px] font-bold uppercase">Berkenan Hadir</span>
                        </label>
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-classic-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'maybe' ? 'bg-[#8C6D46] text-[#FAF6EE] border-[#8C6D46]' : 'bg-[#F4EFE6] text-[#6B5A4B] border-[#8C6D46]/30'">
                            <input type="radio" value="maybe" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">⌛</span>
                            <span class="text-[10px] font-bold uppercase">Belum Pasti</span>
                        </label>
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-classic-heading flex flex-col items-center gap-1"
                            :class="formAttendance === 'absent' ? 'bg-[#8C6D46] text-[#FAF6EE] border-[#8C6D46]' : 'bg-[#F4EFE6] text-[#6B5A4B] border-[#8C6D46]/30'">
                            <input type="radio" value="absent" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">✉️</span>
                            <span class="text-[10px] font-bold uppercase">Berhalangan</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-classic-heading text-xs font-bold text-[#2C2117] mb-1">Jumlah Hadir</label>
                    <select
                        x-model="formGuestCount"
                        class="w-full bg-[#F4EFE6] border border-[#8C6D46]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#2C2117] focus:outline-none focus:border-[#8C6D46]"
                    >
                        <option value="1">1 Orang</option>
                        <option value="2">2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                    </select>
                </div>

                <div>
                    <label class="block font-classic-heading text-xs font-bold text-[#2C2117] mb-1">Doa Restu & Ucapan Tulus</label>
                    <textarea
                        x-model="formWishes"
                        required
                        rows="3"
                        placeholder="Tuliskan untaian doa restu bagi kedua mempelai..."
                        class="w-full bg-[#F4EFE6] border border-[#8C6D46]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#2C2117] focus:outline-none focus:border-[#8C6D46]"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    :disabled="isSubmittingRsvp"
                    class="w-full py-3 rounded-xl bg-[#8C6D46] hover:bg-[#725736] text-[#FAF6EE] font-classic-heading text-xs font-bold uppercase tracking-wider shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer disabled:opacity-50"
                >
                    <span x-show="!isSubmittingRsvp">📜 Kirim Konfirmasi & Doa Restu</span>
                    <span x-show="isSubmittingRsvp" x-cloak>Sedang mencatat...</span>
                </button>
            </form>

            {{-- LIVE WISHES FEED --}}
            <div class="space-y-3">
                <h4 class="font-classic-heading text-xs font-bold text-[#6B5A4B] uppercase tracking-wider">
                    Untaian Doa Restu Para Tamu (<span x-text="rsvps.length"></span>)
                </h4>
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    <template x-for="(w, idx) in rsvps" :key="idx">
                        <div class="bg-[#FAF6EE] border border-[#8C6D46]/30 rounded-2xl p-3.5 shadow-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-classic-heading text-sm font-bold text-[#634832]" x-text="w.guest_name"></span>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[9px] font-classic-heading font-bold"
                                    :class="w.attendance_status === 'attending' ? 'bg-[#346739]/15 text-[#346739]' : 'bg-[#8C6D46]/15 text-[#8C6D46]'"
                                    x-text="w.attendance_status === 'attending' ? 'Hadir' : 'Berhalangan'"
                                ></span>
                            </div>
                            <p class="text-xs text-[#2C2117] font-classic-heading italic leading-relaxed" x-text="w.wishes"></p>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="py-8 text-center border-t border-[#8C6D46]/30 space-y-1">
            <p class="font-cursive text-3xl text-[#634832]">{{ $groomNickname }} & {{ $brideNickname }}</p>
            <p class="font-classic-heading text-xs text-[#6B5A4B]">Digital Invitation by Maja Flower Studio</p>
        </footer>

        {{-- LIGHTBOX MODAL --}}
        <div
            x-show="lightboxOpen"
            x-cloak
            @click.self="closeLightbox()"
            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        >
            <div class="relative max-w-sm w-full bg-[#FAF6EE] rounded-3xl p-3 text-center border border-[#8C6D46]">
                <button
                    type="button"
                    @click="closeLightbox()"
                    class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#8C6D46] text-[#FAF6EE] flex items-center justify-center font-bold text-xs shadow-md"
                >✕</button>
                <img :src="lightboxImg" class="w-full rounded-2xl aspect-square object-cover mb-2 filter sepia-[0.1]">
                <p class="font-classic-heading text-xs text-[#6B5A4B] italic" x-text="lightboxCaption"></p>
            </div>
        </div>
    </main>

    {{-- SCRIPT ALPINE COMPONENT --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('weddingClassicApp', (config) => ({
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
                        this.showToast('Untaian doa restu berhasil dicatat (Mode Demo)! 📜');
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
