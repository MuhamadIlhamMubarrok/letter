<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — Undangan Lucu & Pastel Ceria | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts: Gaegu, Quicksand, Grand Hotel, Plus Jakarta Sans, Roboto Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gaegu:wght@400;700&family=Grand+Hotel&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Quicksand:wght@400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-cute-title { font-family: 'Grand Hotel', cursive; }
        .font-cute-heading { font-family: 'Quicksand', 'Plus Jakarta Sans', sans-serif; }
        .font-handwriting { font-family: 'Gaegu', cursive; }

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

        /* Cute Music Disc Rotation */
        @keyframes cute-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-cute-disc {
            animation: cute-spin 8s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Floating elements */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(3deg); }
        }
        .animate-float {
            animation: float-slow 4s ease-in-out infinite;
        }

        /* Sleek Pastel Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #FFF0F3; }
        ::-webkit-scrollbar-thumb { background: #FFCCD5; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF4D6D; }
        * { scrollbar-width: thin; scrollbar-color: #FFCCD5 #FFF0F3; }
    </style>

    <script>
        if (window.location.hash) {
            window.history.replaceState(null, null, window.location.pathname + window.location.search);
        }
        window.scrollTo(0, 0);
    </script>
</head>

@php
    // 1. Resolve Guest Name from URL parameter (?to=..., ?guest=..., ?u=..., ?nama=...)
    $guestName = request()->query('to', request()->query('guest', request()->query('u', request()->query('nama'))));
    $displayGuest = $guestName ? trim($guestName) : 'Sahabat & Teman Tercinta';

    // 2. Resolve Dynamic Wedding Metadata with High-Fidelity Defaults
    $meta = is_array($story->metadata) ? $story->metadata : [];

    // Couple nicknames
    $groomNickname = $story->getGroomNickname();
    $brideNickname = $story->getBrideNickname();

    // Groom Details
    $groomFullName = $story->getGroomFullName();
    $groomParents = $story->getGroomParents();
    $groomInstagram = $meta['groom_instagram'] ?? '@daffaramadhan';
    $groomBio = $meta['groom_bio'] ?? 'Pribadi yang humoris, penyayang kucing, dan selalu bikin suasana jadi ceria!';
    $groomPhoto = $story->getGroomPhotoUrl();

    // Bride Details
    $brideFullName = $story->getBrideFullName();
    $brideParents = $story->getBrideParents();
    $brideInstagram = $meta['bride_instagram'] ?? '@clarissaputri';
    $brideBio = $meta['bride_bio'] ?? 'Pecinta matcha latte, suka baking kue lucu, dan senyumnya selalu manis!';
    $bridePhoto = $story->getBridePhotoUrl();

    // Date & Countdown Target
    $eventDate = $story->event_date ?? \Carbon\Carbon::now()->addDays(28)->setHour(9)->setMinute(0);
    $eventDateIso = $eventDate->toIso8601String();
    $eventFormattedDate = $eventDate->translatedFormat('l, d F Y');

    // Ceremony (Akad)
    $ceremonyTime = $story->getCeremonyTime();
    $ceremonyVenue = $story->getCeremonyVenue();
    $ceremonyAddress = $story->getCeremonyAddress();
    $ceremonyMaps = $story->getCeremonyMapsUrl();

    // Reception (Resepsi)
    $receptionTime = $story->getReceptionTime();
    $receptionVenue = $story->getReceptionVenue();
    $receptionAddress = $story->getReceptionAddress();
    $receptionMaps = $story->getReceptionMapsUrl();

    // Gift Info
    $bank1 = [
        'bank' => $meta['bank_1_name'] ?? 'BCA',
        'number' => $meta['bank_1_number'] ?? ($meta['bank_bca_number'] ?? '8020998812'),
        'holder' => $meta['bank_1_holder'] ?? ($meta['bank_bca_holder'] ?? 'Clarissa Putri')
    ];
    $bank2 = [
        'bank' => $meta['bank_2_name'] ?? 'Bank Mandiri',
        'number' => $meta['bank_2_number'] ?? ($meta['bank_mandiri_number'] ?? '137001928382'),
        'holder' => $meta['bank_2_holder'] ?? ($meta['bank_mandiri_holder'] ?? 'Daffa Ramadhan')
    ];
    $giftAddress = [
        'recipient' => $groomNickname . ' & ' . $brideNickname,
        'phone' => $story->customer_phone ?: '0812-3456-7890',
        'address' => $meta['gift_delivery_address'] ?? 'Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan 12180'
    ];

    // Audio path
    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-romantic-moment-1144.mp3');
    $audioTitle = $story->audio_title ?: 'Sweet Pastel Romance (Acoustic Joy)';
    $audioStartSec = (float) ($story->audio_start_sec ?? 0);
    $audioEndSec = $story->audio_end_sec !== null ? (float) $story->audio_end_sec : null;

    // Prewedding Media
    $mediaItems = $story->media && $story->media->count() > 0 ? $story->media : collect([
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Awal Mula Cerita Manis Kita 💕'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Tertawa Bersama di Bawah Senja 🌸'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Melangkah Berdua Menuju Halal ✨'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Selamanya Bersamamu 💖'
        ]
    ]);

    // Google Calendar Event Link
    $calStart = $eventDate->format('Ymd\THis\Z');
    $calEnd = $eventDate->copy()->addHours(6)->format('Ymd\THis\Z');
    $calTitle = rawurlencode("The Wedding of " . $groomNickname . " & " . $brideNickname . " 💕");
    $calDetails = rawurlencode("Undangan Pernikahan Lucu & Pastel: " . url()->current());
    $calLocation = rawurlencode($receptionVenue . ', ' . $receptionAddress);
    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStart}/{$calEnd}&details={$calDetails}&location={$calLocation}";
@endphp

<body
    x-data="{
        coverOpened: false,
        isPlaying: false,
        audioStartSec: {{ $audioStartSec }},
        audioEndSec: {{ $audioEndSec !== null ? $audioEndSec : 'null' }},
        toastVisible: false,
        toastMessage: '',
        lightboxOpen: false,
        lightboxImg: '',
        lightboxCaption: '',

        // Real-time Countdown
        targetTime: new Date('{{ $eventDateIso }}').getTime(),
        days: 0, hours: 0, minutes: 0, seconds: 0,

        // Real-time RSVP Form & Wishes Feed
        guestNameInput: @js($guestName ? trim($guestName) : ''),
        attendanceInput: 'attending',
        guestCountInput: 1,
        wishesInput: '',
        isSubmittingRsvp: false,
        rsvpSuccessMsg: '',
        rsvpErrorMsg: '',
        wishesList: {{ Js::from(($story->rsvps ?? collect())->map(fn($r) => [
            'guest_name' => $r->guest_name ?? 'Sahabat Tercinta',
            'attendance_status' => $r->attendance_status ?? 'attending',
            'guest_count' => $r->guest_count ?? 1,
            'wishes' => $r->wishes ?? '',
            'created_at' => !empty($r->created_at) ? ($r->created_at instanceof \Carbon\CarbonInterface ? $r->created_at->diffForHumans() : \Carbon\Carbon::parse($r->created_at)->diffForHumans()) : 'Baru saja',
        ])) }},

        init() {
            // 1. Strict pre-open scroll locking on html & body
            document.documentElement.classList.add('scroll-locked');
            document.body.classList.add('scroll-locked');
            window.scrollTo(0, 0);

            // 2. Intercept wheel, touch dragging, and keyboard scroll events
            this._wheelBlocker = (e) => {
                if (!this.coverOpened) {
                    e.preventDefault();
                }
            };
            this._touchBlocker = (e) => {
                if (!this.coverOpened) {
                    e.preventDefault();
                }
            };
            this._keyBlocker = (e) => {
                if (!this.coverOpened && ['Space', 'ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End'].includes(e.code)) {
                    e.preventDefault();
                }
            };
            this._scrollReset = () => {
                if (!this.coverOpened && (window.scrollY > 0 || window.pageYOffset > 0)) {
                    window.scrollTo(0, 0);
                }
            };

            window.addEventListener('wheel', this._wheelBlocker, { passive: false });
            window.addEventListener('touchmove', this._touchBlocker, { passive: false });
            window.addEventListener('keydown', this._keyBlocker);
            window.addEventListener('scroll', this._scrollReset);

            // Live countdown timer
            this.updateCountdown();
            setInterval(() => this.updateCountdown(), 1000);

            // Local fallback wishes if list is empty
            if (this.wishesList.length === 0) {
                this.wishesList = [
                    {
                        guest_name: 'Kak Nadia & Mas Reza',
                        attendance_status: 'attending',
                        guest_count: 2,
                        wishes: 'Aaaaa selamat ya {{ $groomNickname }} & {{ $brideNickname }} kesayangan! Semoga pernikahannya selalu penuh tawa, cinta, dan kebahagiaan setiap hari 💕',
                        created_at: '1 jam yang lalu'
                    },
                    {
                        guest_name: 'Geng Matcha Ceria',
                        attendance_status: 'attending',
                        guest_count: 3,
                        wishes: 'Happy wedding teman baikku! Lancar sampai hari H ya, ga sabar pengen foto bareng pengantin gemas! 🌸✨',
                        created_at: '1 hari yang lalu'
                    }
                ];
            }

            // Audio listeners
            this.$nextTick(() => {
                const audio = this.$refs.bgAudio;
                if (audio) {
                    if (this.audioStartSec > 0) {
                        try { audio.currentTime = this.audioStartSec; } catch (e) {}
                    }
                    audio.addEventListener('timeupdate', () => {
                        if (this.audioEndSec !== null && audio.currentTime >= this.audioEndSec) {
                            audio.currentTime = this.audioStartSec;
                        }
                    });
                    audio.addEventListener('ended', () => {
                        audio.currentTime = this.audioStartSec;
                        audio.play().catch(() => {});
                    });
                }
            });
        },

        updateCountdown() {
            const now = new Date().getTime();
            const distance = Math.max(0, this.targetTime - now);
            this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
        },

        openInvitation() {
            this.coverOpened = true;

            // Remove strict scroll lock
            document.documentElement.classList.remove('scroll-locked');
            document.body.classList.remove('scroll-locked');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';

            // Unbind event listeners
            window.removeEventListener('wheel', this._wheelBlocker);
            window.removeEventListener('touchmove', this._touchBlocker);
            window.removeEventListener('keydown', this._keyBlocker);
            window.removeEventListener('scroll', this._scrollReset);

            this.playAudio();

            // Sweet Confetti Burst!
            if (window.confetti) {
                confetti({
                    particleCount: 90,
                    spread: 80,
                    origin: { y: 0.6 },
                    colors: ['#FF4D6D', '#FF758F', '#FFAFCC', '#FFE3E8', '#FFCCD5']
                });
            }

            // Smooth scroll to pembuka section
            this.$nextTick(() => {
                const firstSection = document.getElementById('pembuka');
                if (firstSection) {
                    firstSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        },

        playAudio() {
            const audio = this.$refs.bgAudio;
            if (audio) {
                if (this.audioStartSec > 0 && (audio.currentTime < this.audioStartSec || (this.audioEndSec && audio.currentTime >= this.audioEndSec))) {
                    try { audio.currentTime = this.audioStartSec; } catch (e) {}
                }
                audio.play().then(() => {
                    this.isPlaying = true;
                }).catch(() => {
                    this.isPlaying = false;
                });
            }
        },

        toggleAudio() {
            const audio = this.$refs.bgAudio;
            if (!audio) return;
            if (this.isPlaying) {
                audio.pause();
                this.isPlaying = false;
            } else {
                this.playAudio();
            }
        },

        copyText(text, label = 'Teks') {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    this.triggerToast(`💕 ${label} berhasil disalin!`);
                }).catch(() => {
                    this.fallbackCopy(text, label);
                });
            } else {
                this.fallbackCopy(text, label);
            }
        },

        fallbackCopy(text, label) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            this.triggerToast(`💕 ${label} berhasil disalin!`);
        },

        triggerToast(msg) {
            this.toastMessage = msg;
            this.toastVisible = true;
            setTimeout(() => { this.toastVisible = false; }, 3200);
        },

        openLightbox(img, caption) {
            this.lightboxImg = img;
            this.lightboxCaption = caption;
            this.lightboxOpen = true;
        },

        async submitRsvp() {
            if (this.isSubmittingRsvp) return;
            if (!this.guestNameInput.trim()) {
                this.rsvpErrorMsg = 'Yuk tuliskan namamu terlebih dahulu ya! 💕';
                return;
            }
            this.isSubmittingRsvp = true;
            this.rsvpErrorMsg = '';
            this.rsvpSuccessMsg = '';

            const payload = {
                guest_name: this.guestNameInput.trim(),
                attendance_status: this.attendanceInput,
                guest_count: parseInt(this.guestCountInput) || 1,
                wishes: this.wishesInput.trim()
            };

            try {
                const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                const res = await fetch('{{ route('story.public.rsvp', ['slug' => $story->slug]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token || ''
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (res.ok && data.success) {
                    this.rsvpSuccessMsg = data.message || 'Yeay terima kasih banyak atas doa manisnya! 💕';
                    const newEntry = data.rsvp ? data.rsvp : {
                        guest_name: payload.guest_name,
                        attendance_status: payload.attendance_status,
                        guest_count: payload.guest_count,
                        wishes: payload.wishes,
                        created_at: 'Baru saja'
                    };
                    this.wishesList.unshift(newEntry);
                    this.wishesInput = '';
                    this.triggerToast('🌸 Doa restu manismu berhasil terkirim!');
                } else {
                    this.rsvpErrorMsg = data.message || 'Gagal mengirimkan ucapan.';
                }
            } catch (e) {
                const fallbackEntry = {
                    guest_name: payload.guest_name,
                    attendance_status: payload.attendance_status,
                    guest_count: payload.guest_count,
                    wishes: payload.wishes,
                    created_at: 'Baru saja'
                };
                this.wishesList.unshift(fallbackEntry);
                this.wishesInput = '';
                this.rsvpSuccessMsg = 'Terima kasih banyak atas doa manisnya! 💕 (Tersimpan)';
                this.triggerToast('🌸 Doa restu manismu berhasil disimpan!');
            } finally {
                this.isSubmittingRsvp = false;
            }
        }
    }"
    class="{{ request()->has('embed') ? 'bg-[#FFF5F8]' : 'bg-[#2A1D20]' }} text-[#3D2A2E] font-sans antialiased min-h-screen selection:bg-[#FF4D6D] selection:text-white relative overflow-x-hidden scroll-locked"
    :class="{ 'h-screen max-h-screen overflow-hidden': !coverOpened }"
>
    <!-- DEMO PREVIEW BANNER -->
    @if(isset($isDemo) && $isDemo)
        @include('digital-story.components.demo-banner', ['template' => $template, 'isDemo' => true])
    @endif

    <!-- AUDIO ELEMENT -->
    <audio x-ref="bgAudio" src="{{ $audioTrack }}" loop preload="auto"></audio>

    <!-- TOAST NOTIFICATION (Cute Pastel Style) -->
    <div
        x-show="toastVisible"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed top-5 inset-x-0 mx-auto z-[80] w-max max-w-sm px-4 py-2.5 rounded-2xl bg-white border-2 border-[#FFCCD5] text-[#FF4D6D] shadow-2xl flex items-center gap-2.5 font-cute-heading text-xs font-bold"
    >
        <span class="text-base animate-bounce">💕</span>
        <span x-text="toastMessage"></span>
    </div>

    <!-- ======================================================== -->
    <!-- 1. COVER UNDANGAN (Cute Edge-to-Edge Pastel Cover)       -->
    <!-- ======================================================== -->
    <section
        id="cover"
        class="fixed inset-0 z-50 w-full min-h-screen min-h-[100dvh] flex flex-col justify-between items-center p-5 sm:p-8 text-center select-none overflow-hidden transition-all duration-700 ease-in-out touch-none overscroll-none"
        :class="{ '-translate-y-full opacity-0 pointer-events-none': coverOpened }"
        style="background: linear-gradient(180deg, #FFF5F8 0%, #FFE3E8 50%, #FFF0F3 100%);"
    >
        <!-- Floating Cute Stickers -->
        <div class="absolute -top-6 -right-6 text-6xl opacity-35 animate-float pointer-events-none">🌸</div>
        <div class="absolute -bottom-6 -left-6 text-6xl opacity-35 animate-float pointer-events-none" style="animation-delay: 1.5s;">🧸</div>
        <div class="absolute top-1/4 -left-4 text-4xl opacity-25 animate-pulse pointer-events-none">✨</div>
        <div class="absolute bottom-1/3 -right-3 text-4xl opacity-25 animate-pulse pointer-events-none">💖</div>

        <!-- Top Header Ribbon Badge -->
        <div class="relative z-10 {{ isset($isDemo) && $isDemo ? 'pt-16 sm:pt-20' : 'pt-4 sm:pt-8' }}">
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/95 border-2 border-[#FFCCD5] text-[#FF4D6D] font-cute-heading text-xs font-bold uppercase tracking-wider shadow-sm">
                <span>🌸</span>
                <span>The Wedding Invitation</span>
                <span>🌸</span>
            </div>
        </div>

        <!-- Couple Name Big Cute Display -->
        <div class="relative z-10 my-auto py-4 space-y-1.5 max-w-sm w-full">
            <h1 class="font-cute-title text-6xl sm:text-7xl text-[#FF4D6D] leading-tight drop-shadow-sm">
                {{ $groomNickname }} & {{ $brideNickname }}
            </h1>
            <p class="font-cute-heading text-xs text-[#7A5C61] font-bold tracking-wider uppercase">
                Kami Akan Menikah! 💕
            </p>
            <p class="font-mono text-xs text-[#FF4D6D] font-semibold">
                {{ $eventFormattedDate }}
            </p>
        </div>

        <!-- Personal Guest Box & Buka Undangan Button -->
        <div class="relative z-10 w-full max-w-sm pb-5 sm:pb-8 space-y-3.5">
            <div class="bg-white/95 border-2 border-[#FFCCD5] rounded-3xl p-4 shadow-xl backdrop-blur-sm space-y-1">
                <p class="font-cute-heading text-[11px] text-[#7A5C61] uppercase tracking-wider font-bold">
                    Kepada Yth. Sahabat Tercinta:
                </p>
                <h2 class="font-cute-heading text-xl sm:text-2xl font-bold text-[#FF4D6D] truncate">
                    {{ $displayGuest }}
                </h2>
                <span class="font-cute-heading text-xs text-[#7A5C61] block font-semibold">
                    di Tempat
                </span>
            </div>

            <!-- Buka Undangan Button -->
            <button
                type="button"
                @click="openInvitation()"
                class="group w-full py-3.5 sm:py-4 px-6 rounded-2xl bg-gradient-to-r from-[#FF4D6D] via-[#FF758F] to-[#FF4D6D] hover:brightness-105 text-white font-cute-heading text-sm font-bold shadow-xl shadow-[#FF4D6D]/30 transition-all flex items-center justify-center gap-2.5 cursor-pointer active:scale-95"
            >
                <span>💌</span>
                <span>Buka Undangan Ceria</span>
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </button>

            <p class="font-cute-heading text-[11px] text-[#7A5C61] italic pt-0.5 font-medium">
                *Ketuk tombol untuk membuka undangan & memutar alunan musik
            </p>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- FLOATING AUDIO CONTROLLER (Pastel Disc)                  -->
    <!-- ======================================================== -->
    <div
        x-show="coverOpened"
        x-cloak
        class="fixed top-5 right-5 z-40"
    >
        <button
            type="button"
            @click="toggleAudio()"
            class="w-12 h-12 rounded-full bg-white/90 border-2 border-[#FFCCD5] shadow-2xl backdrop-blur-md flex items-center justify-center text-[#FF4D6D] hover:scale-105 active:scale-95 transition cursor-pointer"
            :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
        >
            <div :class="isPlaying ? 'animate-cute-disc' : 'paused'">
                <i class="fa-solid fa-record-vinyl text-2xl"></i>
            </div>
        </button>
    </div>

    <!-- ======================================================== -->
    <!-- STICKY FLOATING BOTTOM NAVIGATION BAR                    -->
    <!-- ======================================================== -->
    <nav
        x-show="coverOpened"
        x-cloak
        class="fixed bottom-3 inset-x-0 mx-auto z-40 max-w-[440px] px-3"
    >
        <div class="bg-white/95 border-2 border-[#FFCCD5] backdrop-blur-md rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#7A5C61]">
            <a href="#mempelai" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-bold uppercase">
                <i class="fa-solid fa-heart text-xs mb-0.5 text-[#FF4D6D]"></i>
                <span>Mempelai</span>
            </a>
            <a href="#acara" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-bold uppercase">
                <i class="fa-solid fa-calendar-check text-xs mb-0.5 text-[#FF4D6D]"></i>
                <span>Acara</span>
            </a>
            <a href="#countdown" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-bold uppercase">
                <i class="fa-solid fa-clock text-xs mb-0.5 text-[#FF4D6D]"></i>
                <span>Waktu</span>
            </a>
            <a href="#kado" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-bold uppercase">
                <i class="fa-solid fa-gift text-xs mb-0.5 text-[#FF4D6D]"></i>
                <span>Kado</span>
            </a>
            <a href="#rsvp" class="flex flex-col items-center hover:text-[#FF4D6D] transition text-[10px] font-cute-heading font-bold uppercase">
                <i class="fa-solid fa-envelope-open-text text-xs mb-0.5 text-[#FF4D6D]"></i>
                <span>RSVP</span>
            </a>
        </div>
    </nav>

    <!-- ======================================================== -->
    <!-- MAIN INVITATION CONTENT (Scrollable, Max-W 480px)       -->
    <!-- ======================================================== -->
    <main
        id="invitation-main-content"
        class="max-w-[480px] mx-auto min-h-screen bg-gradient-to-b from-[#FFF5F8] via-[#FFFFFF] to-[#FFF5F8] {{ request()->has('embed') ? '' : 'shadow-2xl border-x-2 border-[#FFCCD5]' }} relative overflow-hidden pb-24 transition-opacity duration-700"
        :class="{ 'opacity-0 pointer-events-none': !coverOpened, 'opacity-100 pointer-events-auto': coverOpened }"
    >
        <!-- ======================================================== -->
        <!-- 2. PEMBUKA (Salam & Ayat Suci Ceria)                     -->
        <!-- ======================================================== -->
        <section id="pembuka" class="py-14 px-6 text-center space-y-6 relative">
            <div class="flex items-center justify-center gap-2 text-[#FF4D6D] text-lg">
                <span>🌸</span>
                <div class="w-16 h-0.5 bg-[#FFCCD5] rounded-full"></div>
                <span>🌸</span>
            </div>

            <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                Doa & Salam Pembuka
            </span>

            <h3 class="font-cute-heading text-2xl font-bold text-[#3D2A2E]">
                Assalamu'alaikum Warahmatullahi Wabarakatuh
            </h3>

            <!-- Holy Verse Box (Cute Ribbon Card) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] relative space-y-3">
                <div class="text-3xl text-[#FF4D6D]/40 font-cute-title">“</div>
                <p class="font-cute-heading text-xs sm:text-sm text-[#7A5C61] leading-relaxed font-medium">
                    "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
                </p>
                <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block">
                    (QS. Ar-Rum: 21)
                </span>
            </div>

            <p class="font-cute-heading text-xs text-[#7A5C61] leading-relaxed max-w-sm mx-auto font-medium">
                Dengan penuh rasa syukur dan memohon ridho Allah SWT, kami ingin berbagi kebahagiaan hari pernikahan kami:
            </p>
        </section>

        <!-- ======================================================== -->
        <!-- 3. PROFIL MEMPELAI (Cute Polaroid Style)                 -->
        <!-- ======================================================== -->
        <section id="mempelai" class="py-12 px-6 space-y-10">
            <div class="text-center space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Pasangan Pengantin
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    Kedua Mempelai
                </h3>
                <div class="w-16 h-0.5 bg-[#FFCCD5] mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Mempelai Pria (Cute Polaroid) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] text-center space-y-4">
                <div class="relative w-40 h-40 mx-auto rounded-3xl overflow-hidden border-4 border-[#FFCCD5] shadow-md bg-[#FFF5F8]">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-cute-heading text-2xl font-bold text-[#3D2A2E]">
                        {{ $groomFullName }}
                    </h4>
                    <p class="font-cute-heading text-xs text-[#7A5C61]">
                        {{ $groomParents }}
                    </p>
                    <p class="font-cute-heading text-xs text-[#FF4D6D] italic pt-1 font-medium">
                        "{{ $groomBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#FFF0F3] border border-[#FFCCD5] text-[#FF4D6D] text-xs font-mono hover:bg-[#FF4D6D] hover:text-white transition font-semibold"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $groomInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Monogram Heart Divider -->
            <div class="text-center">
                <span class="font-cute-title text-5xl text-[#FF4D6D] block">&</span>
            </div>

            <!-- Mempelai Wanita (Cute Polaroid) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] text-center space-y-4">
                <div class="relative w-40 h-40 mx-auto rounded-3xl overflow-hidden border-4 border-[#FFCCD5] shadow-md bg-[#FFF5F8]">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-cute-heading text-2xl font-bold text-[#3D2A2E]">
                        {{ $brideFullName }}
                    </h4>
                    <p class="font-cute-heading text-xs text-[#7A5C61]">
                        {{ $brideParents }}
                    </p>
                    <p class="font-cute-heading text-xs text-[#FF4D6D] italic pt-1 font-medium">
                        "{{ $brideBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#FFF0F3] border border-[#FFCCD5] text-[#FF4D6D] text-xs font-mono hover:bg-[#FF4D6D] hover:text-white transition font-semibold"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $brideInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 4. SAVE THE DATE & CUTE COUNTDOWN BUBBLES                -->
        <!-- ======================================================== -->
        <section id="countdown" class="py-12 px-6 bg-[#FFF0F3] border-y-2 border-[#FFCCD5] text-center space-y-6">
            <div class="space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Save The Date
                </span>
                <h3 class="font-cute-heading text-2xl sm:text-3xl font-bold text-[#3D2A2E]">
                    Menuju Hari Bahagia 💕
                </h3>
                <p class="font-cute-heading text-xs text-[#7A5C61] font-semibold">
                    {{ $eventFormattedDate }}
                </p>
            </div>

            <!-- Cute Bubble Timer Grid -->
            <div class="grid grid-cols-4 gap-2.5 max-w-xs mx-auto">
                <div class="bg-white p-3 rounded-2xl shadow-sm border-2 border-[#FFCCD5]">
                    <span class="font-mono text-2xl font-bold text-[#FF4D6D] block" x-text="days">0</span>
                    <span class="font-cute-heading text-[10px] uppercase tracking-wider text-[#7A5C61] font-bold">Hari</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border-2 border-[#FFCCD5]">
                    <span class="font-mono text-2xl font-bold text-[#FF4D6D] block" x-text="hours">0</span>
                    <span class="font-cute-heading text-[10px] uppercase tracking-wider text-[#7A5C61] font-bold">Jam</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border-2 border-[#FFCCD5]">
                    <span class="font-mono text-2xl font-bold text-[#FF4D6D] block" x-text="minutes">0</span>
                    <span class="font-cute-heading text-[10px] uppercase tracking-wider text-[#7A5C61] font-bold">Menit</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border-2 border-[#FFCCD5]">
                    <span class="font-mono text-2xl font-bold text-[#FF4D6D] block" x-text="seconds">0</span>
                    <span class="font-cute-heading text-[10px] uppercase tracking-wider text-[#7A5C61] font-bold">Detik</span>
                </div>
            </div>

            <!-- Save To Google Calendar Button -->
            <div>
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white hover:bg-[#FF4D6D] text-[#FF4D6D] hover:text-white border-2 border-[#FFCCD5] text-xs font-cute-heading font-bold shadow-md transition"
                >
                    <i class="fa-solid fa-calendar-plus text-sm"></i>
                    <span>Simpan ke Google Calendar</span>
                </a>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 5. WAKTU & TEMPAT ACARA (Akad & Resepsi)                  -->
        <!-- ======================================================== -->
        <section id="acara" class="py-12 px-6 space-y-8">
            <div class="text-center space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Rangkaian Acara
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    Waktu & Tempat
                </h3>
                <div class="w-16 h-0.5 bg-[#FFCCD5] mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Card 1: Akad Nikah -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#FFF0F3] text-[#FF4D6D] border border-[#FFCCD5] flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-handshake-simple"></i>
                </div>
                <div>
                    <h4 class="font-cute-heading text-2xl font-bold text-[#3D2A2E]">Akad Nikah</h4>
                    <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#7A5C61] mt-0.5 font-semibold">
                        Pukul {{ $ceremonyTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#FFCCD5]/50 space-y-1">
                    <p class="font-cute-heading font-bold text-sm text-[#3D2A2E]">{{ $ceremonyVenue }}</p>
                    <p class="font-cute-heading text-xs text-[#7A5C61] leading-relaxed">{{ $ceremonyAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $ceremonyMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#FF4D6D] hover:bg-[#e03b5a] text-white text-xs font-cute-heading font-bold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Resepsi Pernikahan -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#FFF0F3] text-[#FF4D6D] border border-[#FFCCD5] flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <div>
                    <h4 class="font-cute-heading text-2xl font-bold text-[#3D2A2E]">Resepsi Pernikahan</h4>
                    <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#7A5C61] mt-0.5 font-semibold">
                        Pukul {{ $receptionTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#FFCCD5]/50 space-y-1">
                    <p class="font-cute-heading font-bold text-sm text-[#3D2A2E]">{{ $receptionVenue }}</p>
                    <p class="font-cute-heading text-xs text-[#7A5C61] leading-relaxed">{{ $receptionAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $receptionMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#FF4D6D] hover:bg-[#e03b5a] text-white text-xs font-cute-heading font-bold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 6. GALERI FOTO, LOVE STORY & DRESS CODE                  -->
        <!-- ======================================================== -->
        <section id="galeri" class="py-12 px-6 space-y-8 bg-[#FFF0F3] border-y-2 border-[#FFCCD5]">
            <div class="text-center space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Momen Terindah
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    Galeri Kenangan Manis
                </h3>
                <div class="w-16 h-0.5 bg-[#FFCCD5] mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Prewedding Photo Grid -->
            <div class="grid grid-cols-2 gap-3.5">
                @foreach($mediaItems as $idx => $m)
                    <div
                        @click="openLightbox('{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}', '{{ addslashes($m->caption ?? '') }}')"
                        class="bg-white p-2 rounded-2xl border-2 border-[#FFCCD5] shadow-sm hover:scale-[1.02] transition cursor-pointer"
                    >
                        <div class="aspect-square rounded-xl overflow-hidden mb-1.5">
                            <img src="{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}" alt="{{ $m->caption ?? 'Prewedding' }}" class="w-full h-full object-cover">
                        </div>
                        <p class="font-cute-heading text-[10px] text-[#7A5C61] text-center truncate px-1 font-bold">
                            {{ $m->caption ?? 'Klik perbesar' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Love Story Timeline Vertikal -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] space-y-5">
                <h4 class="font-cute-heading text-xl font-bold text-center text-[#3D2A2E]">
                    Perjalanan Cinta Kami 💕
                </h4>

                <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#FFCCD5]">
                    <!-- Point 1 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#FF4D6D] border-2 border-white shadow-sm"></div>
                        <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block">Tahun 2021</span>
                        <h5 class="font-cute-heading font-bold text-sm text-[#3D2A2E]">Pertama Kali Bertemu</h5>
                        <p class="font-cute-heading text-xs text-[#7A5C61] mt-0.5 leading-relaxed font-medium">
                            Ketemu di festival musik kampus, waktu itu ga sengaja barengan antri boba lalu ngobrol seru berjam-jam! 🧋
                        </p>
                    </div>

                    <!-- Point 2 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#FF4D6D] border-2 border-white shadow-sm"></div>
                        <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block">Tahun 2023</span>
                        <h5 class="font-cute-heading font-bold text-sm text-[#3D2A2E]">Komitmen Bersama</h5>
                        <p class="font-cute-heading text-xs text-[#7A5C61] mt-0.5 leading-relaxed font-medium">
                            Memutuskan untuk saling menemani dalam suka dan duka, lalu mengenalkan ke orang tua masing-masing.
                        </p>
                    </div>

                    <!-- Point 3 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#FF4D6D] border-2 border-white shadow-sm"></div>
                        <span class="font-cute-heading text-xs text-[#FF4D6D] font-bold block">Tahun 2026</span>
                        <h5 class="font-cute-heading font-bold text-sm text-[#3D2A2E]">Menuju Hari Bahagia</h5>
                        <p class="font-cute-heading text-xs text-[#7A5C61] mt-0.5 leading-relaxed font-medium">
                            Mengikat janji suci pernikahan untuk terus masak bareng, jalan-jalan bareng, dan bahagia selamanya! 🌸
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dress Code Tamu Rekomendasi (Cute Pastel Palette) -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border-2 border-[#FFCCD5] text-center space-y-2">
                <span class="font-cute-heading text-xs uppercase tracking-wider text-[#FF4D6D] font-bold block">
                    Dress Code Tamu Undangan
                </span>
                <p class="font-cute-heading text-xs text-[#3D2A2E] font-bold">Pastel Blush / Baby Pink & Vanilla Cream</p>
                <div class="flex items-center justify-center gap-2.5 pt-1">
                    <span class="w-5 h-5 rounded-full bg-[#FF8DA1] shadow-sm" title="Blush Pink"></span>
                    <span class="w-5 h-5 rounded-full bg-[#FFAFCC] shadow-sm" title="Baby Pink"></span>
                    <span class="w-5 h-5 rounded-full bg-[#FFF8E7] border border-[#FFCCD5] shadow-sm" title="Vanilla Cream"></span>
                    <span class="w-5 h-5 rounded-full bg-[#B5D5C5] shadow-sm" title="Pastel Mint Sage"></span>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 7. TANDA KASIH / WEDDING GIFT (Amplop Digital Ceria)    -->
        <!-- ======================================================== -->
        <section id="kado" class="py-12 px-6 space-y-6">
            <div class="text-center space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Tanda Kasih
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    Amplop & Kado Digital
                </h3>
                <div class="w-16 h-0.5 bg-[#FFCCD5] mx-auto rounded-full mt-2"></div>
            </div>

            <p class="font-cute-heading text-xs text-[#7A5C61] text-center leading-relaxed font-medium">
                Doa restu Anda adalah kado terindah bagi kami. Namun apabila ingin memberikan tanda kasih secara cashless:
            </p>

            <!-- Bank Transfer 1 -->
            <div class="bg-gradient-to-r from-[#FFF0F3] to-[#FFE3E8] border-2 border-[#FFCCD5] rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">{{ $bank1['bank'] }}</span>
                    <i class="fa-solid fa-credit-card text-[#FF4D6D] text-lg"></i>
                </div>
                <p class="font-mono text-xl font-bold text-[#3D2A2E] tracking-wider">{{ $bank1['number'] }}</p>
                <p class="font-cute-heading text-xs text-[#7A5C61] font-semibold">a.n {{ $bank1['holder'] }}</p>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank1['number'] }}', 'No. Rekening {{ $bank1['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-white text-[#FF4D6D] border border-[#FFCCD5] font-cute-heading text-xs font-bold hover:bg-[#FFF0F3] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Bank Transfer 2 -->
            <div class="bg-gradient-to-r from-[#FFF0F3] to-[#FFE3E8] border-2 border-[#FFCCD5] rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase tracking-wider">{{ $bank2['bank'] }}</span>
                    <i class="fa-solid fa-building-columns text-[#FF4D6D] text-lg"></i>
                </div>
                <p class="font-mono text-xl font-bold text-[#3D2A2E] tracking-wider">{{ $bank2['number'] }}</p>
                <p class="font-cute-heading text-xs text-[#7A5C61] font-semibold">a.n {{ $bank2['holder'] }}</p>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank2['number'] }}', 'No. Rekening {{ $bank2['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-white text-[#FF4D6D] border border-[#FFCCD5] font-cute-heading text-xs font-bold hover:bg-[#FFF0F3] transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Kirim Kado Fisik -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border-2 border-[#FFCCD5] space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-cute-heading text-xs font-bold text-[#FF4D6D] uppercase">Kirim Kado Fisik</span>
                    <i class="fa-solid fa-box-open text-[#FF4D6D] text-lg"></i>
                </div>
                <div class="font-cute-heading text-xs text-[#7A5C61] space-y-1">
                    <p class="font-bold text-[#3D2A2E]">{{ $giftAddress['recipient'] }}</p>
                    <p class="font-mono">{{ $giftAddress['phone'] }}</p>
                    <p class="leading-relaxed">{{ $giftAddress['address'] }}</p>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ addslashes($giftAddress['address'] . ' (' . $giftAddress['recipient'] . ' - ' . $giftAddress['phone'] . ')') }}', 'Alamat Kirim Kado')"
                        class="w-full py-2.5 rounded-xl bg-[#FFF0F3] text-[#FF4D6D] border border-[#FFCCD5] font-cute-heading text-xs font-bold hover:bg-[#FF4D6D] hover:text-white transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Salin Alamat Kirim Kado</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 8. RSVP & BUKU TAMU CERIA FEED                           -->
        <!-- ======================================================== -->
        <section id="rsvp" class="py-12 px-6 space-y-8 bg-[#FFF0F3] border-y-2 border-[#FFCCD5]">
            <div class="text-center space-y-1">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Konfirmasi Kehadiran
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    RSVP & Doa Restu 💕
                </h3>
                <div class="w-16 h-0.5 bg-[#FFCCD5] mx-auto rounded-full mt-2"></div>
            </div>

            <!-- RSVP Form -->
            <form @submit.prevent="submitRsvp" class="bg-white rounded-3xl p-6 shadow-sm border-2 border-[#FFCCD5] space-y-4">
                <template x-if="rsvpSuccessMsg">
                    <div class="p-3 bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-cute-heading rounded-xl text-center font-bold" x-text="rsvpSuccessMsg"></div>
                </template>
                <template x-if="rsvpErrorMsg">
                    <div class="p-3 bg-rose-50 border border-rose-300 text-rose-800 text-xs font-cute-heading rounded-xl text-center font-bold" x-text="rsvpErrorMsg"></div>
                </template>

                <div>
                    <label class="block text-xs font-cute-heading text-[#7A5C61] mb-1 font-bold">Nama Lengkap Teman-teman</label>
                    <input
                        type="text"
                        x-model="guestNameInput"
                        placeholder="Contoh: Dita & Sahabat"
                        class="w-full px-3.5 py-2.5 rounded-xl border-2 border-[#FFCCD5] bg-[#FFF5F8] text-xs text-[#3D2A2E] font-cute-heading focus:outline-none focus:border-[#FF4D6D]"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-cute-heading text-[#7A5C61] mb-1 font-bold">Konfirmasi Hadir</label>
                        <select
                            x-model="attendanceInput"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-[#FFCCD5] bg-[#FFF5F8] text-xs text-[#3D2A2E] font-cute-heading focus:outline-none focus:border-[#FF4D6D]"
                        >
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="tentative">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-cute-heading text-[#7A5C61] mb-1 font-bold">Jumlah Tamu</label>
                        <select
                            x-model="guestCountInput"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-[#FFCCD5] bg-[#FFF5F8] text-xs text-[#3D2A2E] font-cute-heading focus:outline-none focus:border-[#FF4D6D]"
                        >
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4">4 Orang</option>
                            <option value="5">5 Orang</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-cute-heading text-[#7A5C61] mb-1 font-bold">Pesan & Doa Manis</label>
                    <textarea
                        x-model="wishesInput"
                        rows="3"
                        placeholder="Tuliskan ucapan selamat & doa restu untuk pengantin..."
                        class="w-full px-3.5 py-2.5 rounded-xl border-2 border-[#FFCCD5] bg-[#FFF5F8] text-xs text-[#3D2A2E] font-cute-heading focus:outline-none focus:border-[#FF4D6D]"
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isSubmittingRsvp"
                        class="w-full py-3 rounded-xl bg-[#FF4D6D] hover:bg-[#e03b5a] text-white text-xs font-cute-heading font-bold uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                        <i class="fa-solid" :class="isSubmittingRsvp ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                        <span x-text="isSubmittingRsvp ? 'Mengirimkan...' : 'Kirim Ucapan Manis 💕'"></span>
                    </button>
                </div>
            </form>

            <!-- Real-Time Wishes Feed -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-cute-heading font-bold text-[#7A5C61]">Doa Manis Yang Masuk</span>
                    <span class="font-cute-heading font-bold text-[#FF4D6D]" x-text="wishesList.length + ' Ucapan'"></span>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2.5 pr-1">
                    <template x-for="(wish, idx) in wishesList" :key="idx">
                        <div class="bg-white rounded-2xl p-4 shadow-xs border border-[#FFCCD5] space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#FFF0F3] text-[#FF4D6D] border border-[#FFCCD5] flex items-center justify-center text-xs font-bold font-cute-heading">
                                        <span x-text="wish.guest_name ? wish.guest_name.substring(0, 1).toUpperCase() : 'S'"></span>
                                    </div>
                                    <span class="font-cute-heading font-bold text-xs text-[#3D2A2E]" x-text="wish.guest_name"></span>
                                </div>
                                <span
                                    class="text-[9px] font-cute-heading font-bold px-2 py-0.5 rounded-full"
                                    :class="wish.attendance_status === 'attending' ? 'bg-emerald-100 text-emerald-800' : (wish.attendance_status === 'not_attending' ? 'bg-neutral-100 text-neutral-600' : 'bg-amber-100 text-amber-800')"
                                    x-text="wish.attendance_status === 'attending' ? 'Hadir' : (wish.attendance_status === 'not_attending' ? 'Tidak Hadir' : 'Ragu-ragu')"
                                ></span>
                            </div>
                            <p class="font-cute-heading text-xs text-[#7A5C61] leading-relaxed font-medium" x-text="wish.wishes || 'Memberikan doa restu.'"></p>
                            <span class="text-[9px] font-mono text-[#7A5C61]/60 block text-right" x-text="wish.created_at"></span>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 9. PENUTUP & KELUARGA BESAR                              -->
        <!-- ======================================================== -->
        <section class="py-14 px-6 text-center space-y-6">
            <div class="flex items-center justify-center gap-2 text-[#FF4D6D] text-lg">
                <span>🌸</span>
                <div class="w-16 h-0.5 bg-[#FFCCD5] rounded-full"></div>
                <span>🌸</span>
            </div>

            <div class="space-y-2">
                <span class="font-cute-heading text-xs tracking-wider uppercase text-[#FF4D6D] font-bold block">
                    Ungkapan Terima Kasih
                </span>
                <h3 class="font-cute-heading text-3xl font-bold text-[#3D2A2E]">
                    Sampai Jumpa di Hari Bahagia 💕
                </h3>
            </div>

            <p class="font-cute-heading text-xs text-[#7A5C61] leading-relaxed max-w-sm mx-auto font-medium">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila teman-teman dan keluarga berkenan hadir dan mendoakan kami berdua.
            </p>

            <p class="font-cute-heading italic text-base text-[#3D2A2E] font-bold">
                Wassalamu'alaikum Warahmatullahi Wabarakatuh
            </p>

            <!-- Family Names -->
            <div class="pt-4 border-t border-[#FFCCD5] space-y-1">
                <span class="text-[10px] font-cute-heading uppercase text-[#FF4D6D] tracking-wider font-bold block">Kami yang Berbahagia:</span>
                <p class="font-cute-heading font-bold text-base text-[#3D2A2E]">{{ $groomFullName }} & {{ $brideFullName }}</p>
                <p class="font-cute-heading text-xs text-[#7A5C61]">Beserta Seluruh Keluarga Besar Kedua Mempelai</p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 10. FOOTER MINIMALIS                                     -->
        <!-- ======================================================== -->
        <footer class="py-8 px-6 text-center border-t-2 border-[#FFCCD5] space-y-2 text-[#7A5C61]">
            <p class="font-cute-title text-4xl text-[#FF4D6D]">
                {{ $groomNickname }} & {{ $brideNickname }}
            </p>
            <p class="font-cute-heading text-xs tracking-widest uppercase font-semibold">
                {{ $eventFormattedDate }}
            </p>
            <div class="pt-2">
                <a
                    href="{{ url('/') }}"
                    class="inline-block text-[10px] font-mono text-[#FF4D6D] hover:underline"
                >
                    Cute Pastel Invitation by Maja Flower Atelier
                </a>
            </div>
        </footer>
    </main>

    <!-- ======================================================== -->
    <!-- LIGHTBOX FULLSCREEN MODAL                                -->
    <!-- ======================================================== -->
    <div
        x-show="lightboxOpen"
        x-cloak
        @click="lightboxOpen = false"
        class="fixed inset-0 z-[100] bg-black/85 backdrop-blur-md flex items-center justify-center p-4 cursor-zoom-out"
    >
        <div class="relative max-w-md w-full bg-white p-3 rounded-3xl border-2 border-[#FFCCD5] shadow-2xl" @click.stop>
            <button
                type="button"
                @click="lightboxOpen = false"
                class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#FF4D6D] text-white flex items-center justify-center font-bold text-xs shadow-md hover:scale-110 transition"
            >✕</button>
            <img :src="lightboxImg" class="w-full rounded-2xl aspect-square object-cover mb-2">
            <p class="font-cute-heading text-xs text-center text-[#7A5C61] font-bold" x-text="lightboxCaption"></p>
        </div>
    </div>
</body>
</html>
