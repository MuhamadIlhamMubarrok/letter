<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — Undangan Pernikahan Klasik Heritage | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts: Cormorant Garamond (Royal Serif), Great Vibes (Calligraphy), Plus Jakarta Sans, Roboto Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

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

        /* Vintage Gramophone disc rotation */
        @keyframes gramophone-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-gramophone {
            animation: gramophone-spin 10s linear infinite;
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

        /* Antique Wax Seal Pulse */
        @keyframes seal-pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 25px -5px rgba(140, 109, 70, 0.4); }
            50% { transform: scale(1.03); box-shadow: 0 20px 35px -5px rgba(140, 109, 70, 0.6); }
        }
        .animate-seal {
            animation: seal-pulse 3s ease-in-out infinite;
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
    // 1. Resolve Guest Name from URL parameter (?to=..., ?guest=..., ?u=..., ?nama=...)
    $guestName = request()->query('to', request()->query('guest', request()->query('u', request()->query('nama'))));
    $displayGuest = $guestName ? trim($guestName) : 'Bapak/Ibu/Saudara/i';

    // 2. Resolve Dynamic Wedding Metadata with High-Fidelity Defaults
    $meta = is_array($story->metadata) ? $story->metadata : [];

    // Couple nicknames
    $groomNickname = $story->getGroomNickname();
    $brideNickname = $story->getBrideNickname();

    // Groom Details
    $groomFullName = $story->getGroomFullName();
    $groomParents = $story->getGroomParents();
    $groomInstagram = $meta['groom_instagram'] ?? '@aryakusuma';
    $groomBio = $meta['groom_bio'] ?? 'Pribadi bersahaja, berintegritas, pelindung keluarga, dan pemimpin bijaksana.';
    $groomPhoto = $story->getGroomPhotoUrl();

    // Bride Details
    $brideFullName = $story->getBrideFullName();
    $brideParents = $story->getBrideParents();
    $brideInstagram = $meta['bride_instagram'] ?? '@dyahayusekar';
    $brideBio = $meta['bride_bio'] ?? 'Lemah lembut, anggun, senantiasa menyejukkan hati dan penuh kasih sayang.';
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
        'number' => $meta['bank_1_number'] ?? ($meta['bank_bca_number'] ?? '8020776655'),
        'holder' => $meta['bank_1_holder'] ?? ($meta['bank_bca_holder'] ?? 'Raden Arya Kusuma')
    ];
    $bank2 = [
        'bank' => $meta['bank_2_name'] ?? 'Bank Mandiri',
        'number' => $meta['bank_2_number'] ?? ($meta['bank_mandiri_number'] ?? '1370088776655'),
        'holder' => $meta['bank_2_holder'] ?? ($meta['bank_mandiri_holder'] ?? 'Dyah Sekar Ayu')
    ];
    $giftAddress = [
        'recipient' => $groomNickname . ' & ' . $brideNickname,
        'phone' => $story->customer_phone ?: '0812-9988-7766',
        'address' => $meta['gift_delivery_address'] ?? 'Pendopo Heritage Maja, Jl. Cendana Asri No. 8, Kebayoran Baru, Jakarta Selatan 12180'
    ];

    // Audio path
    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3');
    $audioTitle = $story->audio_title ?: 'Canon in D (Classical Heritage Strings)';
    $audioStartSec = (float) ($story->audio_start_sec ?? 0);
    $audioEndSec = $story->audio_end_sec !== null ? (float) $story->audio_end_sec : null;

    // Prewedding Media
    $mediaItems = $story->media && $story->media->count() > 0 ? $story->media : collect([
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Kisah Dimulai Dalam Doa & Restu'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Dua Hati Bersatu Dalam Bingkai Kasih'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Meniti Langkah Menuju Hari Bahagia'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Keabadian Dalam Janji Suci'
        ]
    ]);

    // Google Calendar Event Link
    $calStart = $eventDate->format('Ymd\THis\Z');
    $calEnd = $eventDate->copy()->addHours(6)->format('Ymd\THis\Z');
    $calTitle = rawurlencode("Pernikahan " . $groomNickname . " & " . $brideNickname);
    $calDetails = rawurlencode("Undangan Pernikahan Klasik Heritage: " . url()->current());
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
            'guest_name' => $r->guest_name ?? 'Tamu Terhormat',
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
                        guest_name: 'Bpk. Prof. Dr. Soedirman & Keluarga',
                        attendance_status: 'attending',
                        guest_count: 2,
                        wishes: 'Selamat menempuh lembaran hidup baru untuk Ananda {{ $groomNickname }} & {{ $brideNickname }}. Semoga menjadi keluarga yang sakinah, mawaddah, warahmah penuh keberkahan.',
                        created_at: '2 jam yang lalu'
                    },
                    {
                        guest_name: 'Keluarga Besar Trah Kusumanegara',
                        attendance_status: 'attending',
                        guest_count: 4,
                        wishes: 'Ndherek mangayubagyo awit palakrama Ananda berdua. Mugi tansah rahayu wilujeng kalis ing sambikala.',
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
                    this.triggerToast(`📜 ${label} berhasil disalin!`);
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
            this.triggerToast(`📜 ${label} berhasil disalin!`);
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
                this.rsvpErrorMsg = 'Mohon sertakan nama Bapak/Ibu/Saudara/i.';
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
                    this.rsvpSuccessMsg = data.message || 'Matur nuwun sanget atas doa restunya! 📜';
                    const newEntry = data.rsvp ? data.rsvp : {
                        guest_name: payload.guest_name,
                        attendance_status: payload.attendance_status,
                        guest_count: payload.guest_count,
                        wishes: payload.wishes,
                        created_at: 'Baru saja'
                    };
                    this.wishesList.unshift(newEntry);
                    this.wishesInput = '';
                    this.triggerToast('📜 Doa restu Anda telah tercatat di Buku Tamu!');
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
                this.rsvpSuccessMsg = 'Matur nuwun sanget atas doa restunya! 📜 (Tersimpan)';
                this.triggerToast('📜 Doa restu Anda telah tercatat!');
            } finally {
                this.isSubmittingRsvp = false;
            }
        }
    }"
    class="{{ request()->has('embed') ? 'bg-[#FAF6EE]' : 'bg-[#1C1814]' }} text-[#2C2117] font-sans antialiased min-h-screen selection:bg-[#8C6D46] selection:text-white relative overflow-x-hidden scroll-locked"
    :class="{ 'h-screen max-h-screen overflow-hidden': !coverOpened }"
>
    <!-- DEMO PREVIEW BANNER -->
    @if(isset($isDemo) && $isDemo)
        @include('digital-story.components.demo-banner', ['template' => $template, 'isDemo' => true])
    @endif

    <!-- AUDIO ELEMENT -->
    <audio x-ref="bgAudio" src="{{ $audioTrack }}" loop preload="auto"></audio>

    <!-- TOAST NOTIFICATION (Vintage Parchment Style) -->
    <div
        x-show="toastVisible"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed top-5 inset-x-0 mx-auto z-[80] w-max max-w-sm px-4 py-2.5 rounded-xl bg-[#FAF6EE] border-2 border-[#8C6D46] text-[#4A3728] shadow-2xl flex items-center gap-2.5 font-classic-heading text-sm font-bold"
    >
        <span class="text-base text-[#8C6D46]">📜</span>
        <span x-text="toastMessage"></span>
    </div>

    <!-- ======================================================== -->
    <!-- 1. COVER UNDANGAN (Sacred Wax Seal Gate)                 -->
    <!-- ======================================================== -->
    <section
        id="cover"
        class="fixed inset-0 z-50 w-full min-h-screen min-h-[100dvh] flex flex-col justify-between items-center p-5 sm:p-8 text-center select-none overflow-hidden transition-all duration-700 ease-in-out touch-none overscroll-none"
        :class="{ '-translate-y-full opacity-0 pointer-events-none': coverOpened }"
        style="background: linear-gradient(180deg, rgba(28,24,20,0.92) 0%, rgba(45,36,28,0.97) 100%), url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80') center/cover no-repeat;"
    >
        <!-- Vintage Filigree Border Arch -->
        <div class="absolute inset-3 sm:inset-5 border-2 border-[#8C6D46]/40 rounded-3xl pointer-events-none"></div>
        <div class="absolute top-4 left-4 text-[#8C6D46]/60 text-2xl font-classic-heading pointer-events-none">❦</div>
        <div class="absolute top-4 right-4 text-[#8C6D46]/60 text-2xl font-classic-heading pointer-events-none">❧</div>
        <div class="absolute bottom-4 left-4 text-[#8C6D46]/60 text-2xl font-classic-heading pointer-events-none">❧</div>
        <div class="absolute bottom-4 right-4 text-[#8C6D46]/60 text-2xl font-classic-heading pointer-events-none">❦</div>

        <!-- Top Header Label -->
        <div class="relative z-10 {{ isset($isDemo) && $isDemo ? 'pt-16 sm:pt-20' : 'pt-4 sm:pt-8' }}">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#FAF6EE]/10 border border-[#8C6D46]/40 text-[#DFC27D] font-classic-heading text-xs uppercase tracking-widest shadow-sm">
                <span>🌿</span>
                <span>The Sacred Wedding of</span>
                <span>🌿</span>
            </div>
        </div>

        <!-- Couple Name Big Calligraphy Display -->
        <div class="relative z-10 my-auto py-4 space-y-2 max-w-sm w-full">
            <div class="w-14 h-14 mx-auto rounded-full bg-[#8C6D46]/20 border-2 border-[#8C6D46]/60 shadow-lg flex items-center justify-center text-2xl text-[#DFC27D] mb-1 font-classic-heading font-bold">
                ❦
            </div>
            <h1 class="font-cursive text-5xl sm:text-6xl text-[#F4EFE6] leading-tight drop-shadow-md">
                {{ $groomNickname }} <span class="text-[#DFC27D]">&</span> {{ $brideNickname }}
            </h1>
            <p class="font-classic-heading text-xs text-[#DFC27D] tracking-widest uppercase font-semibold">
                {{ $eventFormattedDate }}
            </p>
        </div>

        <!-- Personal Guest Box & Buka Undangan Button (Wax Seal Style) -->
        <div class="relative z-10 w-full max-w-sm pb-5 sm:pb-8 space-y-3.5">
            <div class="bg-[#FAF6EE]/95 border-2 border-[#8C6D46]/50 rounded-2xl p-4 shadow-xl backdrop-blur-sm space-y-1">
                <p class="font-classic-heading text-[11px] text-[#6B5A4B] uppercase tracking-widest">
                    Kepada Yth. Bapak/Ibu/Saudara/i:
                </p>
                <h2 class="font-classic-heading text-xl sm:text-2xl font-bold text-[#2C2117] truncate">
                    {{ $displayGuest }}
                </h2>
                <span class="font-classic-heading text-xs text-[#8C6D46] block">
                    di Tempat
                </span>
            </div>

            <!-- Buka Undangan Button -->
            <button
                type="button"
                @click="openInvitation()"
                class="group w-full py-3.5 sm:py-4 px-6 rounded-2xl bg-gradient-to-r from-[#8C6D46] via-[#A07D53] to-[#8C6D46] hover:brightness-110 text-[#FAF6EE] font-classic-heading text-sm font-bold uppercase tracking-widest shadow-xl shadow-[#8C6D46]/40 transition-all flex items-center justify-center gap-2.5 cursor-pointer active:scale-95 animate-seal"
            >
                <i class="fa-solid fa-envelope-open text-base group-hover:rotate-12 transition-transform"></i>
                <span>Buka Lembaran Undangan</span>
                <span class="text-xs">❦</span>
            </button>

            <p class="font-classic-heading text-[11px] text-[#C5B498] italic pt-0.5">
                *Sentuh tombol di atas untuk membuka undangan & melantunkan gending
            </p>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- FLOATING AUDIO CONTROLLER (Gramophone)                   -->
    <!-- ======================================================== -->
    <div
        x-show="coverOpened"
        x-cloak
        class="fixed top-5 right-5 z-40"
    >
        <button
            type="button"
            @click="toggleAudio()"
            class="w-12 h-12 rounded-full bg-[#FAF6EE]/90 border-2 border-[#8C6D46]/60 shadow-2xl backdrop-blur-md flex items-center justify-center text-[#8C6D46] hover:scale-105 active:scale-95 transition cursor-pointer"
            :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
        >
            <div :class="isPlaying ? 'animate-gramophone' : 'paused'">
                <i class="fa-solid fa-compact-disc text-2xl"></i>
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
        <div class="bg-[#FAF6EE]/95 border-2 border-[#8C6D46]/40 backdrop-blur-md rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#6B5A4B]">
            <a href="#mempelai" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                <i class="fa-solid fa-heart text-xs mb-0.5 text-[#8C6D46]"></i>
                <span>Mempelai</span>
            </a>
            <a href="#acara" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                <i class="fa-solid fa-calendar-check text-xs mb-0.5 text-[#8C6D46]"></i>
                <span>Acara</span>
            </a>
            <a href="#countdown" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                <i class="fa-solid fa-clock text-xs mb-0.5 text-[#8C6D46]"></i>
                <span>Waktu</span>
            </a>
            <a href="#kado" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                <i class="fa-solid fa-gift text-xs mb-0.5 text-[#8C6D46]"></i>
                <span>Kado</span>
            </a>
            <a href="#rsvp" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px] font-classic-heading font-bold uppercase">
                <i class="fa-solid fa-envelope-open-text text-xs mb-0.5 text-[#8C6D46]"></i>
                <span>RSVP</span>
            </a>
        </div>
    </nav>

    <!-- ======================================================== -->
    <!-- MAIN INVITATION CONTENT (Scrollable, Max-W 480px)       -->
    <!-- ======================================================== -->
    <main
        id="invitation-main-content"
        class="max-w-[480px] mx-auto min-h-screen bg-parchment {{ request()->has('embed') ? '' : 'shadow-2xl border-x-2 border-[#8C6D46]/30' }} relative overflow-hidden pb-24 transition-opacity duration-700"
        :class="{ 'opacity-0 pointer-events-none': !coverOpened, 'opacity-100 pointer-events-auto': coverOpened }"
    >
        <!-- ======================================================== -->
        <!-- 2. PEMBUKA (Doa & Salam Pembuka / Ayat Suci)             -->
        <!-- ======================================================== -->
        <section id="pembuka" class="py-14 px-6 text-center space-y-6 relative">
            <div class="flex items-center justify-center gap-2 text-[#8C6D46]/60 text-lg">
                <span>❦</span>
                <div class="w-16 h-0.5 bg-[#8C6D46]/30 rounded-full"></div>
                <span>❧</span>
            </div>

            <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                Doa & Salam Pembuka
            </span>

            <h3 class="font-classic-heading text-2xl font-bold text-[#2C2117]">
                Assalamu'alaikum Warahmatullahi Wabarakatuh
            </h3>

            <!-- Quran Holy Verse Box (Royal Parchment Frame) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/30 relative space-y-3">
                <div class="text-3xl text-[#8C6D46]/40 font-classic-heading">“</div>
                <p class="font-classic-heading italic text-sm sm:text-base text-[#4A3728] leading-relaxed">
                    "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
                </p>
                <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block tracking-wider">
                    — Q.S. Ar-Rum: 21 —
                </span>
            </div>

            <p class="font-classic-heading text-xs text-[#6B5A4B] leading-relaxed max-w-sm mx-auto">
                Dengan memohon rahmat dan ridho Allah Subhanahu Wa Ta'ala, serta restu dari para sesepuh dan keluarga besar, kami bermaksud menyelenggarakan upacara pernikahan putra-putri kami:
            </p>
        </section>

        <!-- ======================================================== -->
        <!-- 3. PROFIL MEMPELAI (Cameo Medallion Oval Portraits)      -->
        <!-- ======================================================== -->
        <section id="mempelai" class="py-12 px-6 space-y-10">
            <div class="text-center space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Pasangan Pengantin
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Kedua Mempelai
                </h3>
                <div class="w-16 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Mempelai Pria (Cameo Portrait) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/30 text-center space-y-4">
                <div class="relative w-40 h-52 mx-auto rounded-[50%/60%] overflow-hidden border-4 border-[#8C6D46]/60 shadow-xl bg-[#E8DEC8]">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover sepia-[0.15]" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-classic-heading text-2xl font-bold text-[#2C2117]">
                        {{ $groomFullName }}
                    </h4>
                    <p class="font-classic-heading text-xs text-[#6B5A4B]">
                        {{ $groomParents }}
                    </p>
                    <p class="font-classic-heading text-xs text-[#8C6D46] italic pt-1">
                        "{{ $groomBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#E8DEC8]/50 border border-[#8C6D46]/40 text-[#8C6D46] text-xs font-mono hover:bg-[#8C6D46] hover:text-white transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $groomInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Monogram Botanical Divider -->
            <div class="text-center">
                <span class="font-cursive text-5xl text-[#8C6D46] block">&</span>
            </div>

            <!-- Mempelai Wanita (Cameo Portrait) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/30 text-center space-y-4">
                <div class="relative w-40 h-52 mx-auto rounded-[50%/60%] overflow-hidden border-4 border-[#8C6D46]/60 shadow-xl bg-[#E8DEC8]">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover sepia-[0.15]" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-classic-heading text-2xl font-bold text-[#2C2117]">
                        {{ $brideFullName }}
                    </h4>
                    <p class="font-classic-heading text-xs text-[#6B5A4B]">
                        {{ $brideParents }}
                    </p>
                    <p class="font-classic-heading text-xs text-[#8C6D46] italic pt-1">
                        "{{ $brideBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#E8DEC8]/50 border border-[#8C6D46]/40 text-[#8C6D46] text-xs font-mono hover:bg-[#8C6D46] hover:text-white transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $brideInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 4. SAVE THE DATE & VINTAGE CLOCK COUNTDOWN               -->
        <!-- ======================================================== -->
        <section id="countdown" class="py-12 px-6 bg-[#E8DEC8]/40 border-y-2 border-[#8C6D46]/25 text-center space-y-6">
            <div class="space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Save The Date
                </span>
                <h3 class="font-classic-heading text-2xl sm:text-3xl font-bold text-[#2C2117]">
                    Menuju Hari Bahagia
                </h3>
                <p class="font-classic-heading text-xs text-[#6B5A4B] font-semibold">
                    {{ $eventFormattedDate }}
                </p>
            </div>

            <!-- Vintage Pocket Watch Timer Grid -->
            <div class="grid grid-cols-4 gap-2.5 max-w-xs mx-auto">
                <div class="bg-[#FAF6EE] p-3 rounded-2xl shadow-sm border-2 border-[#8C6D46]/30">
                    <span class="font-mono text-2xl font-bold text-[#2C2117] block" x-text="days">0</span>
                    <span class="font-classic-heading text-[10px] uppercase tracking-wider text-[#6B5A4B] font-bold">Hari</span>
                </div>
                <div class="bg-[#FAF6EE] p-3 rounded-2xl shadow-sm border-2 border-[#8C6D46]/30">
                    <span class="font-mono text-2xl font-bold text-[#2C2117] block" x-text="hours">0</span>
                    <span class="font-classic-heading text-[10px] uppercase tracking-wider text-[#6B5A4B] font-bold">Jam</span>
                </div>
                <div class="bg-[#FAF6EE] p-3 rounded-2xl shadow-sm border-2 border-[#8C6D46]/30">
                    <span class="font-mono text-2xl font-bold text-[#2C2117] block" x-text="minutes">0</span>
                    <span class="font-classic-heading text-[10px] uppercase tracking-wider text-[#6B5A4B] font-bold">Menit</span>
                </div>
                <div class="bg-[#FAF6EE] p-3 rounded-2xl shadow-sm border-2 border-[#8C6D46]/30">
                    <span class="font-mono text-2xl font-bold text-[#8C6D46] block" x-text="seconds">0</span>
                    <span class="font-classic-heading text-[10px] uppercase tracking-wider text-[#6B5A4B] font-bold">Detik</span>
                </div>
            </div>

            <!-- Save To Google Calendar Button -->
            <div>
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#FAF6EE] hover:bg-[#8C6D46] text-[#8C6D46] hover:text-[#FAF6EE] border-2 border-[#8C6D46]/50 text-xs font-classic-heading font-bold shadow-md transition"
                >
                    <i class="fa-solid fa-calendar-plus text-sm"></i>
                    <span>Simpan ke Google Calendar</span>
                </a>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 5. WAKTU & TEMPAT ACARA (Royal Decree Scrolls)           -->
        <!-- ======================================================== -->
        <section id="acara" class="py-12 px-6 space-y-8">
            <div class="text-center space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Rangkaian Acara
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Waktu & Tempat
                </h3>
                <div class="w-16 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Card 1: Akad Nikah (Royal Scroll) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/35 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#E8DEC8] text-[#8C6D46] border border-[#8C6D46]/40 flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-handshake-simple"></i>
                </div>
                <div>
                    <h4 class="font-classic-heading text-2xl font-bold text-[#2C2117]">Akad Nikah</h4>
                    <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#6B5A4B] mt-0.5">
                        Pukul {{ $ceremonyTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#8C6D46]/20 space-y-1">
                    <p class="font-classic-heading font-bold text-base text-[#2C2117]">{{ $ceremonyVenue }}</p>
                    <p class="font-classic-heading text-xs text-[#6B5A4B] leading-relaxed">{{ $ceremonyAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $ceremonyMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#8C6D46] hover:bg-[#725736] text-[#FAF6EE] text-xs font-classic-heading font-bold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Resepsi Pernikahan (Royal Scroll) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/35 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#E8DEC8] text-[#8C6D46] border border-[#8C6D46]/40 flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <div>
                    <h4 class="font-classic-heading text-2xl font-bold text-[#2C2117]">Resepsi Pernikahan</h4>
                    <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#6B5A4B] mt-0.5">
                        Pukul {{ $receptionTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#8C6D46]/20 space-y-1">
                    <p class="font-classic-heading font-bold text-base text-[#2C2117]">{{ $receptionVenue }}</p>
                    <p class="font-classic-heading text-xs text-[#6B5A4B] leading-relaxed">{{ $receptionAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $receptionMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#8C6D46] hover:bg-[#725736] text-[#FAF6EE] text-xs font-classic-heading font-bold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 6. GALERI FOTO, KISAH KASIH & DRESS CODE                 -->
        <!-- ======================================================== -->
        <section id="galeri" class="py-12 px-6 space-y-8 bg-[#E8DEC8]/35 border-y-2 border-[#8C6D46]/25">
            <div class="text-center space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Galeri Kenangan
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Kisah Kasih & Kenangan
                </h3>
                <div class="w-16 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Prewedding Photo Grid (Antique Sepia Borders) -->
            <div class="grid grid-cols-2 gap-3">
                @foreach($mediaItems as $idx => $m)
                    <div
                        @click="openLightbox('{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}', '{{ addslashes($m->caption ?? '') }}')"
                        class="group relative overflow-hidden rounded-2xl shadow-sm border-2 border-[#8C6D46]/35 aspect-[4/5] cursor-pointer hover:scale-[1.02] transition bg-[#E8DEC8]"
                    >
                        <img
                            src="{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}"
                            alt="{{ $m->caption ?? 'Foto Prewedding' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500 sepia-[0.1]"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-2.5">
                            <span class="text-[#FAF6EE] text-[10px] font-classic-heading truncate">{{ $m->caption ?? 'Perbesar Foto' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Love Story Timeline Vertikal (Babad Tresna) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/30 space-y-5">
                <h4 class="font-classic-heading text-2xl font-bold text-center text-[#2C2117]">
                    Perjalanan Cinta Kami
                </h4>

                <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#8C6D46]/40">
                    <!-- Point 1 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#8C6D46] border-2 border-[#FAF6EE] shadow-sm"></div>
                        <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block">Tahun 2021</span>
                        <h5 class="font-classic-heading font-bold text-base text-[#2C2117]">Pertama Kali Bertemu</h5>
                        <p class="font-classic-heading text-xs text-[#6B5A4B] mt-0.5 leading-relaxed">
                            Dipertemukan dalam kegiatan pagelaran seni budaya, berawal dari tatapan mata dan obrolan penuh kehangatan.
                        </p>
                    </div>

                    <!-- Point 2 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#8C6D46] border-2 border-[#FAF6EE] shadow-sm"></div>
                        <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block">Tahun 2023</span>
                        <h5 class="font-classic-heading font-bold text-base text-[#2C2117]">Ikatan Komitmen Suci</h5>
                        <p class="font-classic-heading text-xs text-[#6B5A4B] mt-0.5 leading-relaxed">
                            Memutuskan untuk melangkah bersama dengan niat tulus saling melengkapi dan menyatukan kedua keluarga besar.
                        </p>
                    </div>

                    <!-- Point 3 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#8C6D46] border-2 border-[#FAF6EE] shadow-sm"></div>
                        <span class="font-classic-heading text-xs text-[#8C6D46] font-bold block">Tahun 2026</span>
                        <h5 class="font-classic-heading font-bold text-base text-[#2C2117]">Menuju Mahligai Rumah Tangga</h5>
                        <p class="font-classic-heading text-xs text-[#6B5A4B] mt-0.5 leading-relaxed">
                            Mengikat janji suci pernikahan untuk saling mengasihi, menghormati, dan membina keluarga yang bahagia hingga akhir hayat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dress Code Rekomendasi (Traditional Javanese Earthtone) -->
            <div class="bg-[#FAF6EE] rounded-2xl p-4 shadow-sm border-2 border-[#8C6D46]/30 text-center space-y-2">
                <span class="font-classic-heading text-xs uppercase tracking-widest text-[#8C6D46] font-bold block">
                    Dress Code Tamu Undangan
                </span>
                <p class="font-classic-heading text-xs text-[#2C2117] font-semibold">Traditional Batik / Warm Earthtone & Sand Ivory</p>
                <div class="flex items-center justify-center gap-2.5 pt-1">
                    <span class="w-5 h-5 rounded-full bg-[#6F4E37] shadow-sm" title="Sogan Brown"></span>
                    <span class="w-5 h-5 rounded-full bg-[#9B5848] shadow-sm" title="Terracotta Parijotho"></span>
                    <span class="w-5 h-5 rounded-full bg-[#A07D53] shadow-sm" title="Antique Brass"></span>
                    <span class="w-5 h-5 rounded-full bg-[#FAF6EE] border border-[#8C6D46]/40 shadow-sm" title="Sand Ivory"></span>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 7. TANDA KASIH / WEDDING GIFT (Airmail Envelope)        -->
        <!-- ======================================================== -->
        <section id="kado" class="py-12 px-6 space-y-6">
            <div class="text-center space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Tanda Kasih
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Titipan Kasih
                </h3>
                <div class="w-16 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <p class="font-classic-heading text-xs text-[#6B5A4B] text-center leading-relaxed">
                Doa restu Bapak/Ibu/Saudara/i merupakan karunia terindah bagi kami. Namun apabila berkehendak memberikan tanda kasih, dapat mengirimkannya melalui:
            </p>

            <!-- Bank Transfer 1 (Airmail Style) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-5 shadow-sm border-2 border-[#8C6D46]/35 space-y-3 relative">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#8C6D46] uppercase">{{ $bank1['bank'] }}</span>
                    <i class="fa-solid fa-credit-card text-[#8C6D46]"></i>
                </div>
                <div>
                    <span class="font-mono text-xl font-bold text-[#2C2117] block tracking-wider">{{ $bank1['number'] }}</span>
                    <span class="font-classic-heading text-xs text-[#6B5A4B]">a.n {{ $bank1['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank1['number'] }}', 'No. Rekening {{ $bank1['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-[#E8DEC8]/60 hover:bg-[#8C6D46] text-[#8C6D46] hover:text-[#FAF6EE] border border-[#8C6D46]/40 text-xs font-classic-heading font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Bank Transfer 2 (Airmail Style) -->
            <div class="bg-[#FAF6EE] rounded-3xl p-5 shadow-sm border-2 border-[#8C6D46]/35 space-y-3 relative">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#8C6D46] uppercase">{{ $bank2['bank'] }}</span>
                    <i class="fa-solid fa-building-columns text-[#8C6D46]"></i>
                </div>
                <div>
                    <span class="font-mono text-xl font-bold text-[#2C2117] block tracking-wider">{{ $bank2['number'] }}</span>
                    <span class="font-classic-heading text-xs text-[#6B5A4B]">a.n {{ $bank2['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank2['number'] }}', 'No. Rekening {{ $bank2['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-[#E8DEC8]/60 hover:bg-[#8C6D46] text-[#8C6D46] hover:text-[#FAF6EE] border border-[#8C6D46]/40 text-xs font-classic-heading font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Kirim Kado Fisik -->
            <div class="bg-[#FAF6EE] rounded-3xl p-5 shadow-sm border-2 border-[#8C6D46]/35 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-classic-heading text-xs font-bold text-[#8C6D46] uppercase">Kirim Kado Fisik</span>
                    <i class="fa-solid fa-box-open text-[#8C6D46]"></i>
                </div>
                <div class="font-classic-heading text-xs text-[#6B5A4B] space-y-1">
                    <p class="font-bold text-[#2C2117]">{{ $giftAddress['recipient'] }}</p>
                    <p class="font-mono">{{ $giftAddress['phone'] }}</p>
                    <p class="leading-relaxed">{{ $giftAddress['address'] }}</p>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ addslashes($giftAddress['address'] . ' (' . $giftAddress['recipient'] . ' - ' . $giftAddress['phone'] . ')') }}', 'Alamat Kirim Kado')"
                        class="w-full py-2.5 rounded-xl bg-[#E8DEC8]/60 hover:bg-[#8C6D46] text-[#8C6D46] hover:text-[#FAF6EE] border border-[#8C6D46]/40 text-xs font-classic-heading font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Salin Alamat Kirim Kado</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 8. RSVP & BUKU TAMU ROYAL GUESTBOOK FEED                -->
        <!-- ======================================================== -->
        <section id="rsvp" class="py-12 px-6 space-y-8 bg-[#E8DEC8]/35 border-y-2 border-[#8C6D46]/25">
            <div class="text-center space-y-1">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Konfirmasi Kehadiran
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Buku Tamu & RSVP
                </h3>
                <div class="w-16 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- RSVP Form (Parchment Guestbook Style) -->
            <form @submit.prevent="submitRsvp" class="bg-[#FAF6EE] rounded-3xl p-6 shadow-sm border-2 border-[#8C6D46]/35 space-y-4">
                <template x-if="rsvpSuccessMsg">
                    <div class="p-3 bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-classic-heading rounded-xl text-center font-bold" x-text="rsvpSuccessMsg"></div>
                </template>
                <template x-if="rsvpErrorMsg">
                    <div class="p-3 bg-rose-50 border border-rose-300 text-rose-800 text-xs font-classic-heading rounded-xl text-center font-bold" x-text="rsvpErrorMsg"></div>
                </template>

                <div>
                    <label class="block text-xs font-classic-heading text-[#6B5A4B] mb-1 font-bold">Nama Lengkap Tamu</label>
                    <input
                        type="text"
                        x-model="guestNameInput"
                        placeholder="Contoh: Bpk. Bambang & Keluarga"
                        class="w-full px-3.5 py-2.5 rounded-xl border-2 border-[#8C6D46]/30 bg-[#FAF6EE] text-xs text-[#2C2117] font-classic-heading focus:outline-none focus:border-[#8C6D46]"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-classic-heading text-[#6B5A4B] mb-1 font-bold">Konfirmasi Hadir</label>
                        <select
                            x-model="attendanceInput"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-[#8C6D46]/30 bg-[#FAF6EE] text-xs text-[#2C2117] font-classic-heading focus:outline-none focus:border-[#8C6D46]"
                        >
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="tentative">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-classic-heading text-[#6B5A4B] mb-1 font-bold">Jumlah Tamu</label>
                        <select
                            x-model="guestCountInput"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-[#8C6D46]/30 bg-[#FAF6EE] text-xs text-[#2C2117] font-classic-heading focus:outline-none focus:border-[#8C6D46]"
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
                    <label class="block text-xs font-classic-heading text-[#6B5A4B] mb-1 font-bold">Pesan & Doa Restu</label>
                    <textarea
                        x-model="wishesInput"
                        rows="3"
                        placeholder="Tuliskan untaian doa restu untuk kedua mempelai..."
                        class="w-full px-3.5 py-2.5 rounded-xl border-2 border-[#8C6D46]/30 bg-[#FAF6EE] text-xs text-[#2C2117] font-classic-heading focus:outline-none focus:border-[#8C6D46]"
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isSubmittingRsvp"
                        class="w-full py-3 rounded-xl bg-[#8C6D46] hover:bg-[#725736] text-[#FAF6EE] text-xs font-classic-heading font-bold uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                        <i class="fa-solid" :class="isSubmittingRsvp ? 'fa-spinner fa-spin' : 'fa-feather'"></i>
                        <span x-text="isSubmittingRsvp ? 'Mencatat...' : 'Kirim Doa Restu'"></span>
                    </button>
                </div>
            </form>

            <!-- Real-Time Wishes Feed (Victorian Guestbook Notes) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-classic-heading font-bold text-[#6B5A4B]">Doa Restu Yang Masuk</span>
                    <span class="font-classic-heading font-bold text-[#8C6D46]" x-text="wishesList.length + ' Doa Restu'"></span>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2.5 pr-1">
                    <template x-for="(wish, idx) in wishesList" :key="idx">
                        <div class="bg-[#FAF6EE] rounded-2xl p-4 shadow-xs border border-[#8C6D46]/25 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#8C6D46]/15 text-[#8C6D46] flex items-center justify-center text-xs font-bold font-classic-heading">
                                        <span x-text="wish.guest_name ? wish.guest_name.substring(0, 1).toUpperCase() : 'T'"></span>
                                    </div>
                                    <span class="font-classic-heading font-bold text-xs text-[#2C2117]" x-text="wish.guest_name"></span>
                                </div>
                                <span
                                    class="text-[9px] font-classic-heading font-bold px-2 py-0.5 rounded-full"
                                    :class="wish.attendance_status === 'attending' ? 'bg-emerald-100 text-emerald-800' : (wish.attendance_status === 'not_attending' ? 'bg-neutral-100 text-neutral-600' : 'bg-amber-100 text-amber-800')"
                                    x-text="wish.attendance_status === 'attending' ? 'Hadir' : (wish.attendance_status === 'not_attending' ? 'Tidak Hadir' : 'Ragu-ragu')"
                                ></span>
                            </div>
                            <p class="font-classic-heading text-xs text-[#6B5A4B] leading-relaxed italic" x-text="wish.wishes || 'Memberikan doa restu.'"></p>
                            <span class="text-[9px] font-mono text-[#8C6D46]/60 block text-right" x-text="wish.created_at"></span>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 9. PENUTUP & KELUARGA BESAR                              -->
        <!-- ======================================================== -->
        <section class="py-14 px-6 text-center space-y-6">
            <div class="flex items-center justify-center gap-2 text-[#8C6D46]/60 text-lg">
                <span>❦</span>
                <div class="w-16 h-0.5 bg-[#8C6D46]/30 rounded-full"></div>
                <span>❧</span>
            </div>

            <div class="space-y-2">
                <span class="font-classic-heading text-xs tracking-[0.25em] uppercase text-[#8C6D46] font-bold block">
                    Ungkapan Terima Kasih
                </span>
                <h3 class="font-classic-heading text-3xl font-bold text-[#2C2117]">
                    Sampai Jumpa di Hari Bahagia
                </h3>
            </div>

            <p class="font-classic-heading text-xs text-[#6B5A4B] leading-relaxed max-w-sm mx-auto">
                Merupakan suatu kehormatan dan kebahagiaan yang tak terhingga bagi kami apabila Bapak/Ibu/Saudara/i berkenan rawuh dan memberikan doa restu kepada kedua mempelai.
            </p>

            <p class="font-classic-heading italic text-base text-[#2C2117] font-semibold">
                Wassalamu'alaikum Warahmatullahi Wabarakatuh
            </p>

            <!-- Family Names -->
            <div class="pt-4 border-t border-[#8C6D46]/20 space-y-1">
                <span class="text-[10px] font-classic-heading uppercase text-[#8C6D46] tracking-wider font-bold block">Kami yang Berbahagia:</span>
                <p class="font-classic-heading font-bold text-base text-[#2C2117]">{{ $groomFullName }} & {{ $brideFullName }}</p>
                <p class="font-classic-heading text-xs text-[#6B5A4B]">Beserta Seluruh Keluarga Besar Kedua Mempelai</p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 10. FOOTER MINIMALIS                                     -->
        <!-- ======================================================== -->
        <footer class="py-8 px-6 text-center border-t-2 border-[#8C6D46]/20 space-y-2 text-[#6B5A4B]">
            <p class="font-cursive text-3xl text-[#8C6D46]">
                {{ $groomNickname }} & {{ $brideNickname }}
            </p>
            <p class="font-classic-heading text-xs tracking-widest uppercase font-semibold">
                {{ $eventFormattedDate }}
            </p>
            <div class="pt-2">
                <a
                    href="{{ url('/') }}"
                    class="inline-block text-[10px] font-mono text-[#8C6D46] hover:underline"
                >
                    Classic Heritage Invitation by Maja Flower Atelier
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
        class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-md flex items-center justify-center p-4 cursor-zoom-out"
    >
        <div class="relative max-w-md w-full bg-[#FAF6EE] p-3 rounded-2xl border-2 border-[#8C6D46] shadow-2xl" @click.stop>
            <button
                type="button"
                @click="lightboxOpen = false"
                class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#8C6D46] text-[#FAF6EE] flex items-center justify-center font-bold text-xs shadow-md hover:scale-110 transition"
            >✕</button>
            <img :src="lightboxImg" class="w-full rounded-xl aspect-[4/5] object-cover mb-2 sepia-[0.1]">
            <p class="font-classic-heading text-xs text-center text-[#4A3728] font-bold" x-text="lightboxCaption"></p>
        </div>
    </div>
</body>
</html>
