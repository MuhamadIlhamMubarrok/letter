<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — Royal Haute-Couture Wedding Invitation | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts: Cinzel Decorative, Playfair Display, Plus Jakarta Sans, Roboto Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-luxury-heading { font-family: 'Cinzel', Georgia, serif; }
        .font-display { font-family: 'Playfair Display', Georgia, serif; }

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

        /* 24K Gold Vinyl Disc Rotation */
        @keyframes vinyl-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-vinyl {
            animation: vinyl-spin 9s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Gold Shimmer Button Animation */
        @keyframes gold-sheen {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-gold {
            background: linear-gradient(90deg, #D4AF37 0%, #F5E6BE 40%, #DFC27D 60%, #D4AF37 100%);
            background-size: 200% auto;
            animation: gold-sheen 4s linear infinite;
        }

        /* Luxury Titanium Card Shimmer */
        .card-titanium {
            background: linear-gradient(135deg, #182218 0%, #0F1710 50%, #152217 100%);
            border: 1px solid rgba(212, 175, 55, 0.4);
            box-shadow: inset 0 0 15px rgba(212, 175, 55, 0.1), 0 10px 25px -5px rgba(0, 0, 0, 0.6);
        }

        /* Dark Sleek Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #080D09; }
        ::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.4); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(212, 175, 55, 0.8); }
        * { scrollbar-width: thin; scrollbar-color: rgba(212, 175, 55, 0.4) #080D09; }
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
    $displayGuest = $guestName ? trim($guestName) : 'Distinguished VIP Guest';

    // 2. Resolve Dynamic Wedding Metadata with High-Fidelity Defaults
    $meta = is_array($story->metadata) ? $story->metadata : [];

    // Couple nicknames
    $groomNickname = $story->getGroomNickname();
    $brideNickname = $story->getBrideNickname();

    // Groom Details
    $groomFullName = $story->getGroomFullName();
    $groomParents = $story->getGroomParents();
    $groomInstagram = $meta['groom_instagram'] ?? '@leonardo.adisurya';
    $groomBio = $meta['groom_bio'] ?? 'Visioner berjiwa luhur, berkarisma, dan sosok pemimpin teguh penuh kelembutan.';
    $groomPhoto = $story->getGroomPhotoUrl();

    // Bride Details
    $brideFullName = $story->getBrideFullName();
    $brideParents = $story->getBrideParents();
    $brideInstagram = $meta['bride_instagram'] ?? '@kimberly.clara';
    $brideBio = $meta['bride_bio'] ?? 'Sosok memesona, berwawasan luas, anggun, dan senantiasa memancarkan kehangatan.';
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
        'bank' => $meta['bank_1_name'] ?? 'BCA Prioritas',
        'number' => $meta['bank_1_number'] ?? ($meta['bank_bca_number'] ?? '8020998812'),
        'holder' => $meta['bank_1_holder'] ?? ($meta['bank_bca_holder'] ?? 'Leonardo Adisurya')
    ];
    $bank2 = [
        'bank' => $meta['bank_2_name'] ?? 'Bank Mandiri',
        'number' => $meta['bank_2_number'] ?? ($meta['bank_mandiri_number'] ?? '137001928382'),
        'holder' => $meta['bank_2_holder'] ?? ($meta['bank_mandiri_holder'] ?? 'Kimberly Clara')
    ];
    $giftAddress = [
        'recipient' => $groomNickname . ' & ' . $brideNickname,
        'phone' => $story->customer_phone ?: '0811-9876-5432',
        'address' => $meta['gift_delivery_address'] ?? 'The Glasshouse Residence, Jl. Dharmawangsa Raya No. 18, Kebayoran Baru, Jakarta Selatan 12160'
    ];

    // Audio path
    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3');
    $audioTitle = $story->audio_title ?: 'Canon in D (Royal Emerald Symphony)';
    $audioStartSec = (float) ($story->audio_start_sec ?? 0);
    $audioEndSec = $story->audio_end_sec !== null ? (float) $story->audio_end_sec : null;

    // Prewedding Media
    $mediaItems = $story->media && $story->media->count() > 0 ? $story->media : collect([
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
            'caption' => 'The Beginning of Our Forever'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Pure Elegance in Golden Light'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Walking Hand in Hand'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Symphony of Pure Devotion'
        ]
    ]);

    // Google Calendar Event Link
    $calStart = $eventDate->format('Ymd\THis\Z');
    $calEnd = $eventDate->copy()->addHours(6)->format('Ymd\THis\Z');
    $calTitle = rawurlencode("The Royal Wedding of " . $groomNickname . " & " . $brideNickname);
    $calDetails = rawurlencode("Undangan Pernikahan Elegan Luxury: " . url()->current());
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
            'guest_name' => $r->guest_name ?? 'VIP Guest',
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
                        guest_name: 'Sir Arthur & Lady Victoria',
                        attendance_status: 'attending',
                        guest_count: 2,
                        wishes: 'Heartiest congratulations to {{ $groomNickname }} & {{ $brideNickname }}. May your love continue to shine with eternal grace, joy, and prosperous abundance.',
                        created_at: '2 jam yang lalu'
                    },
                    {
                        guest_name: 'Dato’ Sri William & Datin Clara',
                        attendance_status: 'attending',
                        guest_count: 2,
                        wishes: 'An exquisite celebration for a truly magnificent couple. Wishing you both a lifetime of happiness, harmony, and eternal romance.',
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
                    this.triggerToast(`✨ ${label} berhasil disalin!`);
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
            this.triggerToast(`✨ ${label} berhasil disalin!`);
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
                this.rsvpErrorMsg = 'Mohon masukkan nama Anda.';
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
                    this.rsvpSuccessMsg = data.message || 'Terima kasih atas doa restunya! ✨';
                    const newEntry = data.rsvp ? data.rsvp : {
                        guest_name: payload.guest_name,
                        attendance_status: payload.attendance_status,
                        guest_count: payload.guest_count,
                        wishes: payload.wishes,
                        created_at: 'Baru saja'
                    };
                    this.wishesList.unshift(newEntry);
                    this.wishesInput = '';
                    this.triggerToast('✨ Doa restu Anda telah diterima oleh kedua mempelai!');
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
                this.rsvpSuccessMsg = 'Terima kasih atas doa restunya! ✨ (Tersimpan)';
                this.triggerToast('✨ Doa restu Anda telah tercatat!');
            } finally {
                this.isSubmittingRsvp = false;
            }
        }
    }"
    class="{{ request()->has('embed') ? 'bg-[#090F0B]' : 'bg-[#040604]' }} text-[#F5E6BE] font-sans antialiased min-h-screen selection:bg-[#D4AF37] selection:text-black relative overflow-x-hidden scroll-locked"
    :class="{ 'h-screen max-h-screen overflow-hidden': !coverOpened }"
>
    <!-- DEMO PREVIEW BANNER -->
    @if(isset($isDemo) && $isDemo)
        @include('digital-story.components.demo-banner', ['template' => $template, 'isDemo' => true])
    @endif

    <!-- AUDIO ELEMENT -->
    <audio x-ref="bgAudio" src="{{ $audioTrack }}" loop preload="auto"></audio>

    <!-- TOAST NOTIFICATION (VIP Gold Metal Style) -->
    <div
        x-show="toastVisible"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed top-5 inset-x-0 mx-auto z-[80] w-max max-w-sm px-4 py-2.5 rounded-xl bg-[#101913] border border-[#D4AF37] text-[#F5E6BE] shadow-2xl flex items-center gap-2.5 font-luxury-heading text-sm font-bold backdrop-blur-md"
    >
        <span class="text-base text-[#D4AF37]">✨</span>
        <span x-text="toastMessage"></span>
    </div>

    <!-- ======================================================== -->
    <!-- 1. COVER UNDANGAN (Royal Crest Shield Cover)             -->
    <!-- ======================================================== -->
    <section
        id="cover"
        class="fixed inset-0 z-50 w-full min-h-screen min-h-[100dvh] flex flex-col justify-between items-center p-5 sm:p-8 text-center select-none overflow-hidden transition-all duration-700 ease-in-out touch-none overscroll-none"
        :class="{ '-translate-y-full opacity-0 pointer-events-none': coverOpened }"
        style="background: linear-gradient(180deg, rgba(8,13,9,0.94) 0%, rgba(15,23,16,0.98) 100%), url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80') center/cover no-repeat;"
    >
        <!-- 24K Gold Beveled Arch Outline -->
        <div class="absolute inset-3 sm:inset-5 border border-[#D4AF37]/35 rounded-3xl pointer-events-none shadow-[inset_0_0_20px_rgba(212,175,55,0.08)]"></div>
        <div class="absolute top-4 left-4 text-[#D4AF37]/50 text-xl font-luxury-heading pointer-events-none">✦</div>
        <div class="absolute top-4 right-4 text-[#D4AF37]/50 text-xl font-luxury-heading pointer-events-none">✦</div>
        <div class="absolute bottom-4 left-4 text-[#D4AF37]/50 text-xl font-luxury-heading pointer-events-none">✦</div>
        <div class="absolute bottom-4 right-4 text-[#D4AF37]/50 text-xl font-luxury-heading pointer-events-none">✦</div>

        <!-- Top Header Label -->
        <div class="relative z-10 {{ isset($isDemo) && $isDemo ? 'pt-16 sm:pt-20' : 'pt-4 sm:pt-8' }}">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#101913]/90 border border-[#D4AF37]/60 text-[#DFC27D] font-mono text-[10px] uppercase tracking-[0.25em] shadow-lg">
                <i class="fa-solid fa-crown text-[10px] text-[#D4AF37]"></i>
                <span>The Royal Wedding of</span>
                <i class="fa-solid fa-crown text-[10px] text-[#D4AF37]"></i>
            </div>
        </div>

        <!-- Couple Name Big Display -->
        <div class="relative z-10 my-auto py-4 space-y-2 max-w-sm w-full">
            <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-[#D4AF37]/25 via-transparent to-[#D4AF37]/10 border border-[#D4AF37]/60 shadow-2xl flex items-center justify-center text-2xl text-[#D4AF37] mb-2 font-luxury-heading">
                ✦
            </div>
            <h1 class="font-luxury-heading text-3xl sm:text-4xl text-[#FFFFFF] tracking-widest uppercase leading-tight font-bold drop-shadow-lg">
                {{ $groomNickname }} <span class="text-[#D4AF37] font-normal">&</span> {{ $brideNickname }}
            </h1>
            <p class="font-mono text-xs text-[#DFC27D] tracking-[0.2em] uppercase font-semibold">
                {{ $eventFormattedDate }}
            </p>
        </div>

        <!-- VIP Guest Box & Buka Undangan Button (Shimmer Gold) -->
        <div class="relative z-10 w-full max-w-sm pb-5 sm:pb-8 space-y-3.5">
            <div class="bg-[#101913]/90 border border-[#D4AF37]/50 rounded-2xl p-4 shadow-2xl backdrop-blur-md space-y-1">
                <p class="font-mono text-[10px] text-[#B8A98E] uppercase tracking-widest">
                    Cordially Invited VIP Guest:
                </p>
                <h2 class="font-luxury-heading text-lg sm:text-xl font-bold text-[#FFFFFF] truncate">
                    {{ $displayGuest }}
                </h2>
                <span class="font-mono text-[10px] text-[#D4AF37] block">
                    VIP Special Invitation
                </span>
            </div>

            <!-- Buka Undangan Button -->
            <button
                type="button"
                @click="openInvitation()"
                class="shimmer-gold group w-full py-3.5 sm:py-4 px-6 rounded-2xl text-[#0F1710] font-luxury-heading text-xs font-bold uppercase tracking-[0.2em] shadow-xl shadow-[#D4AF37]/30 transition-all flex items-center justify-center gap-2.5 cursor-pointer active:scale-95"
            >
                <i class="fa-solid fa-envelope-open text-sm group-hover:rotate-12 transition-transform"></i>
                <span>Open Royal Invitation</span>
            </button>

            <p class="font-mono text-[10px] text-[#B8A98E] italic pt-0.5">
                *Tap to unfold the royal invitation & begin soundtrack
            </p>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- FLOATING AUDIO CONTROLLER (24K Gold Vinyl)               -->
    <!-- ======================================================== -->
    <div
        x-show="coverOpened"
        x-cloak
        class="fixed top-5 right-5 z-40"
    >
        <button
            type="button"
            @click="toggleAudio()"
            class="w-12 h-12 rounded-full bg-[#101913]/90 border border-[#D4AF37] shadow-2xl backdrop-blur-md flex items-center justify-center text-[#D4AF37] hover:scale-105 active:scale-95 transition cursor-pointer"
            :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
        >
            <div :class="isPlaying ? 'animate-vinyl' : 'paused'">
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
        <div class="bg-[#101913]/95 border border-[#D4AF37]/40 backdrop-blur-md rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#B8A98E]">
            <a href="#mempelai" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-luxury-heading font-bold uppercase">
                <i class="fa-solid fa-crown text-xs mb-0.5 text-[#D4AF37]"></i>
                <span>Couple</span>
            </a>
            <a href="#acara" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-luxury-heading font-bold uppercase">
                <i class="fa-solid fa-calendar-check text-xs mb-0.5 text-[#D4AF37]"></i>
                <span>Event</span>
            </a>
            <a href="#countdown" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-luxury-heading font-bold uppercase">
                <i class="fa-solid fa-clock text-xs mb-0.5 text-[#D4AF37]"></i>
                <span>Timer</span>
            </a>
            <a href="#kado" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-luxury-heading font-bold uppercase">
                <i class="fa-solid fa-gift text-xs mb-0.5 text-[#D4AF37]"></i>
                <span>Gift</span>
            </a>
            <a href="#rsvp" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-luxury-heading font-bold uppercase">
                <i class="fa-solid fa-envelope-open-text text-xs mb-0.5 text-[#D4AF37]"></i>
                <span>RSVP</span>
            </a>
        </div>
    </nav>

    <!-- ======================================================== -->
    <!-- MAIN INVITATION CONTENT (Scrollable, Max-W 480px)       -->
    <!-- ======================================================== -->
    <main
        id="invitation-main-content"
        class="max-w-[480px] mx-auto min-h-screen bg-[#080D09] {{ request()->has('embed') ? '' : 'shadow-2xl border-x border-[#D4AF37]/25' }} relative overflow-hidden pb-24 transition-opacity duration-700"
        :class="{ 'opacity-0 pointer-events-none': !coverOpened, 'opacity-100 pointer-events-auto': coverOpened }"
    >
        <!-- ======================================================== -->
        <!-- 2. PEMBUKA (Salam & Ayat Suci Haute-Couture)             -->
        <!-- ======================================================== -->
        <section id="pembuka" class="py-14 px-6 text-center space-y-6 relative">
            <div class="flex items-center justify-center gap-2 text-[#D4AF37] text-sm">
                <span>✦</span>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>
                <span>✦</span>
            </div>

            <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                The Sacred Union
            </span>

            <h3 class="font-luxury-heading text-xl sm:text-2xl font-bold text-[#FFFFFF] tracking-wide">
                Assalamu'alaikum Warahmatullahi Wabarakatuh
            </h3>

            <!-- Holy Verse Card (Obsidian & 24K Gold Glass) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 relative space-y-3">
                <div class="text-3xl text-[#D4AF37]/50 font-display">“</div>
                <p class="font-display italic text-sm sm:text-base text-[#F5E6BE] leading-relaxed">
                    "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
                </p>
                <span class="font-mono text-xs text-[#D4AF37] font-semibold block tracking-widest">
                    — Q.S. Ar-Rum: 21 —
                </span>
            </div>

            <p class="text-xs text-[#B8A98E] leading-relaxed max-w-sm mx-auto">
                Dengan penuh rasa syukur dan memohon rahmat serta ridho Allah Subhanahu Wa Ta'ala, kami bermaksud menyelenggarakan resepsi pernikahan putra-putri kami:
            </p>
        </section>

        <!-- ======================================================== -->
        <!-- 3. PROFIL MEMPELAI (Haute-Couture Editorial Split)       -->
        <!-- ======================================================== -->
        <section id="mempelai" class="py-12 px-6 space-y-10">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Distinguished Couple
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Kedua Mempelai
                </h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mt-2"></div>
            </div>

            <!-- Mempelai Pria (Editorial Arch Frame) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 text-center space-y-4">
                <div class="relative w-44 h-56 mx-auto rounded-t-full rounded-b-2xl overflow-hidden border-2 border-[#D4AF37]/50 shadow-2xl bg-[#080D09]">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-luxury-heading text-xl sm:text-2xl font-bold text-[#FFFFFF] tracking-wide">
                        {{ $groomFullName }}
                    </h4>
                    <p class="font-mono text-xs text-[#B8A98E]">
                        {{ $groomParents }}
                    </p>
                    <p class="font-display text-xs text-[#DFC27D] italic pt-1">
                        "{{ $groomBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#18251B] border border-[#D4AF37]/50 text-[#D4AF37] text-xs font-mono hover:bg-[#D4AF37] hover:text-[#080D09] transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $groomInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Monogram Haute-Couture Divider -->
            <div class="text-center">
                <span class="font-display text-5xl text-[#D4AF37] font-light block">&</span>
            </div>

            <!-- Mempelai Wanita (Editorial Arch Frame) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 text-center space-y-4">
                <div class="relative w-44 h-56 mx-auto rounded-t-full rounded-b-2xl overflow-hidden border-2 border-[#D4AF37]/50 shadow-2xl bg-[#080D09]">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover" />
                </div>
                <div class="space-y-1.5">
                    <h4 class="font-luxury-heading text-xl sm:text-2xl font-bold text-[#FFFFFF] tracking-wide">
                        {{ $brideFullName }}
                    </h4>
                    <p class="font-mono text-xs text-[#B8A98E]">
                        {{ $brideParents }}
                    </p>
                    <p class="font-display text-xs text-[#DFC27D] italic pt-1">
                        "{{ $brideBio }}"
                    </p>
                    <div class="pt-2">
                        <a
                            href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#18251B] border border-[#D4AF37]/50 text-[#D4AF37] text-xs font-mono hover:bg-[#D4AF37] hover:text-[#080D09] transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $brideInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 4. GEOMETRIC ARCHITECTURAL COUNTDOWN                     -->
        <!-- ======================================================== -->
        <section id="countdown" class="py-12 px-6 bg-[#0E150F] border-y border-[#D4AF37]/25 text-center space-y-6">
            <div class="space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Save The Date
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Countdown To Forever
                </h3>
                <p class="font-mono text-xs text-[#DFC27D] tracking-wider uppercase">
                    {{ $eventFormattedDate }}
                </p>
            </div>

            <!-- Geometric Gold Timer Grid -->
            <div class="grid grid-cols-4 gap-2.5 max-w-xs mx-auto">
                <div class="bg-[#101913] p-3 rounded-2xl shadow-xl border border-[#D4AF37]/40">
                    <span class="font-mono text-2xl font-bold text-[#FFFFFF] block" x-text="days">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#D4AF37]">Hari</span>
                </div>
                <div class="bg-[#101913] p-3 rounded-2xl shadow-xl border border-[#D4AF37]/40">
                    <span class="font-mono text-2xl font-bold text-[#FFFFFF] block" x-text="hours">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#D4AF37]">Jam</span>
                </div>
                <div class="bg-[#101913] p-3 rounded-2xl shadow-xl border border-[#D4AF37]/40">
                    <span class="font-mono text-2xl font-bold text-[#FFFFFF] block" x-text="minutes">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#D4AF37]">Menit</span>
                </div>
                <div class="bg-[#101913] p-3 rounded-2xl shadow-xl border border-[#D4AF37]/40">
                    <span class="font-mono text-2xl font-bold text-[#D4AF37] block" x-text="seconds">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#D4AF37]">Detik</span>
                </div>
            </div>

            <!-- Save To Google Calendar Button -->
            <div>
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#101913] hover:bg-[#D4AF37] text-[#D4AF37] hover:text-[#080D09] border border-[#D4AF37]/60 text-xs font-mono font-bold shadow-lg transition"
                >
                    <i class="fa-solid fa-calendar-plus text-sm"></i>
                    <span>Simpan ke Google Calendar</span>
                </a>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 5. WAKTU & TEMPAT ACARA (VIP Event Pavilions)             -->
        <!-- ======================================================== -->
        <section id="acara" class="py-12 px-6 space-y-8">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Royal Itinerary
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Waktu & Tempat
                </h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mt-2"></div>
            </div>

            <!-- Card 1: Akad Nikah (VIP Pavilion) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#18251B] text-[#D4AF37] border border-[#D4AF37]/40 flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-handshake-simple"></i>
                </div>
                <div>
                    <h4 class="font-luxury-heading text-xl sm:text-2xl font-bold text-[#FFFFFF]">Akad Nikah</h4>
                    <span class="font-mono text-xs text-[#D4AF37] font-semibold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#B8A98E] mt-0.5">
                        Pukul {{ $ceremonyTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#D4AF37]/20 space-y-1">
                    <p class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">{{ $ceremonyVenue }}</p>
                    <p class="text-xs text-[#B8A98E] leading-relaxed">{{ $ceremonyAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $ceremonyMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#D4AF37] hover:bg-[#b59226] text-[#080D09] text-xs font-mono font-bold shadow-lg transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Resepsi Pernikahan (VIP Pavilion) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#18251B] text-[#D4AF37] border border-[#D4AF37]/40 flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <div>
                    <h4 class="font-luxury-heading text-xl sm:text-2xl font-bold text-[#FFFFFF]">Resepsi Pernikahan</h4>
                    <span class="font-mono text-xs text-[#D4AF37] font-semibold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#B8A98E] mt-0.5">
                        Pukul {{ $receptionTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#D4AF37]/20 space-y-1">
                    <p class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">{{ $receptionVenue }}</p>
                    <p class="text-xs text-[#B8A98E] leading-relaxed">{{ $receptionAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $receptionMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#D4AF37] hover:bg-[#b59226] text-[#080D09] text-xs font-mono font-bold shadow-lg transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 6. GALERI FOTO, LOVE ODYSSEY & VIP DRESS CODE            -->
        <!-- ======================================================== -->
        <section id="galeri" class="py-12 px-6 space-y-8 bg-[#0E150F] border-y border-[#D4AF37]/25">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Haute-Couture Gallery
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Kisah Kasih & Kenangan
                </h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mt-2"></div>
            </div>

            <!-- Prewedding Photo Grid (Vogue Editorial Hover) -->
            <div class="grid grid-cols-2 gap-3">
                @foreach($mediaItems as $idx => $m)
                    <div
                        @click="openLightbox('{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}', '{{ addslashes($m->caption ?? '') }}')"
                        class="group relative overflow-hidden rounded-2xl shadow-xl border border-[#D4AF37]/35 aspect-[4/5] cursor-pointer hover:border-[#D4AF37] transition bg-[#101913]"
                    >
                        <img
                            src="{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}"
                            alt="{{ $m->caption ?? 'Foto Prewedding' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-2.5">
                            <span class="text-[#F5E6BE] text-[10px] font-mono truncate">{{ $m->caption ?? 'View Editorial' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Love Story Timeline Vertikal (The Golden Odyssey) -->
            <div class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 space-y-5">
                <h4 class="font-luxury-heading text-xl font-bold text-center text-[#FFFFFF]">
                    Perjalanan Cinta Kami
                </h4>

                <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#D4AF37]/40">
                    <!-- Point 1 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#D4AF37] border-2 border-[#101913] shadow-md"></div>
                        <span class="font-mono text-[10px] text-[#D4AF37] font-bold block">Tahun 2021</span>
                        <h5 class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">The Fateful Encounter</h5>
                        <p class="text-xs text-[#B8A98E] mt-0.5 leading-relaxed">
                            Dipertemukan dalam sebuah pertemuan diplomatik seni, berawal dari ketertarikan intelektual dan percakapan mendalam.
                        </p>
                    </div>

                    <!-- Point 2 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#D4AF37] border-2 border-[#101913] shadow-md"></div>
                        <span class="font-mono text-[10px] text-[#D4AF37] font-bold block">Tahun 2023</span>
                        <h5 class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">The Sacred Vow</h5>
                        <p class="text-xs text-[#B8A98E] mt-0.5 leading-relaxed">
                            Memutuskan untuk melangkah bersama dengan komitmen kokoh, menyatukan visi hidup dan mempererat kedua keluarga besar.
                        </p>
                    </div>

                    <!-- Point 3 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-[#D4AF37] border-2 border-[#101913] shadow-md"></div>
                        <span class="font-mono text-[10px] text-[#D4AF37] font-bold block">Tahun 2026</span>
                        <h5 class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">The Royal Union</h5>
                        <p class="text-xs text-[#B8A98E] mt-0.5 leading-relaxed">
                            Mengikat janji suci pernikahan abadi dalam naungan cinta, keanggunan, dan saling menghormati sepanjang masa.
                        </p>
                    </div>
                </div>
            </div>

            <!-- VIP Dress Code Rekomendasi (Black Tie / Emerald & Gold) -->
            <div class="bg-[#101913]/90 rounded-2xl p-4 shadow-xl border border-[#D4AF37]/35 text-center space-y-2">
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#D4AF37] font-semibold block">
                    VIP Dress Code Recommendation
                </span>
                <p class="font-luxury-heading text-xs text-[#FFFFFF] font-semibold">Black Tie / Emerald Velvet & Royal Champagne Gold</p>
                <div class="flex items-center justify-center gap-2.5 pt-1">
                    <span class="w-5 h-5 rounded-full bg-[#0F3B2E] border border-[#D4AF37]/50 shadow-sm" title="Emerald Velvet"></span>
                    <span class="w-5 h-5 rounded-full bg-[#111111] border border-[#D4AF37]/50 shadow-sm" title="Midnight Black"></span>
                    <span class="w-5 h-5 rounded-full bg-[#D4AF37] shadow-sm" title="24K Champagne Gold"></span>
                    <span class="w-5 h-5 rounded-full bg-[#F5F2EB] border border-black/20 shadow-sm" title="Pearl Ivory"></span>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 7. TANDA KASIH / WEDDING GIFT (VIP Titanium Metal Cards) -->
        <!-- ======================================================== -->
        <section id="kado" class="py-12 px-6 space-y-6">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Wedding Gift
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Tanda Kasih
                </h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mt-2"></div>
            </div>

            <p class="text-xs text-[#B8A98E] text-center leading-relaxed">
                Doa restu Anda merupakan karunia terindah bagi kami. Namun apabila Anda berkehendak memberikan tanda kasih, dapat mengirimkannya melalui:
            </p>

            <!-- Bank Transfer 1 (VIP Titanium Metal Card) -->
            <div class="card-titanium rounded-3xl p-5 shadow-2xl space-y-3 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#D4AF37] uppercase tracking-widest">{{ $bank1['bank'] }}</span>
                    <i class="fa-solid fa-credit-card text-[#D4AF37] text-lg"></i>
                </div>
                <div>
                    <span class="font-mono text-xl font-bold text-[#FFFFFF] block tracking-wider drop-shadow-md">{{ $bank1['number'] }}</span>
                    <span class="font-mono text-xs text-[#B8A98E] uppercase tracking-wider">Cardholder: {{ $bank1['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank1['number'] }}', 'No. Rekening {{ $bank1['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-[#18251B] hover:bg-[#D4AF37] text-[#D4AF37] hover:text-[#080D09] border border-[#D4AF37]/50 text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Bank Transfer 2 (VIP Titanium Metal Card) -->
            <div class="card-titanium rounded-3xl p-5 shadow-2xl space-y-3 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#D4AF37] uppercase tracking-widest">{{ $bank2['bank'] }}</span>
                    <i class="fa-solid fa-building-columns text-[#D4AF37] text-lg"></i>
                </div>
                <div>
                    <span class="font-mono text-xl font-bold text-[#FFFFFF] block tracking-wider drop-shadow-md">{{ $bank2['number'] }}</span>
                    <span class="font-mono text-xs text-[#B8A98E] uppercase tracking-wider">Cardholder: {{ $bank2['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank2['number'] }}', 'No. Rekening {{ $bank2['bank'] }}')"
                        class="w-full py-2.5 rounded-xl bg-[#18251B] hover:bg-[#D4AF37] text-[#D4AF37] hover:text-[#080D09] border border-[#D4AF37]/50 text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Kirim Kado Fisik (VIP Concierge Parcel) -->
            <div class="card-titanium rounded-3xl p-5 shadow-2xl space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#D4AF37] uppercase tracking-widest">Kirim Kado Fisik</span>
                    <i class="fa-solid fa-box-open text-[#D4AF37] text-lg"></i>
                </div>
                <div class="text-xs text-[#B8A98E] space-y-1">
                    <p class="font-bold text-[#FFFFFF] font-luxury-heading">{{ $giftAddress['recipient'] }}</p>
                    <p class="font-mono">{{ $giftAddress['phone'] }}</p>
                    <p class="leading-relaxed">{{ $giftAddress['address'] }}</p>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ addslashes($giftAddress['address'] . ' (' . $giftAddress['recipient'] . ' - ' . $giftAddress['phone'] . ')') }}', 'Alamat Kirim Kado')"
                        class="w-full py-2.5 rounded-xl bg-[#18251B] hover:bg-[#D4AF37] text-[#D4AF37] hover:text-[#080D09] border border-[#D4AF37]/50 text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Salin Alamat Kirim Kado</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 8. RSVP & LIVE VIP WISHING BOARD FEED                    -->
        <!-- ======================================================== -->
        <section id="rsvp" class="py-12 px-6 space-y-8 bg-[#0E150F] border-y border-[#D4AF37]/25">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    VIP Concierge
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    RSVP & Doa Restu
                </h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mt-2"></div>
            </div>

            <!-- RSVP Form (VIP Glassmorphism) -->
            <form @submit.prevent="submitRsvp" class="bg-[#101913]/90 rounded-3xl p-6 shadow-xl border border-[#D4AF37]/35 space-y-4">
                <template x-if="rsvpSuccessMsg">
                    <div class="p-3 bg-emerald-950/80 border border-emerald-500 text-emerald-300 text-xs font-mono rounded-xl text-center" x-text="rsvpSuccessMsg"></div>
                </template>
                <template x-if="rsvpErrorMsg">
                    <div class="p-3 bg-rose-950/80 border border-rose-500 text-rose-300 text-xs font-mono rounded-xl text-center" x-text="rsvpErrorMsg"></div>
                </template>

                <div>
                    <label class="block text-xs font-mono text-[#B8A98E] mb-1">Nama Lengkap Anda</label>
                    <input
                        type="text"
                        x-model="guestNameInput"
                        placeholder="Contoh: Alexander Tan & Partner"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#D4AF37]/40 bg-[#080D09] text-xs text-[#FFFFFF] focus:outline-none focus:border-[#D4AF37]"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-[#B8A98E] mb-1">Konfirmasi Hadir</label>
                        <select
                            x-model="attendanceInput"
                            class="w-full px-3 py-2.5 rounded-xl border border-[#D4AF37]/40 bg-[#080D09] text-xs text-[#FFFFFF] focus:outline-none focus:border-[#D4AF37]"
                        >
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="tentative">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-[#B8A98E] mb-1">Jumlah Tamu</label>
                        <select
                            x-model="guestCountInput"
                            class="w-full px-3 py-2.5 rounded-xl border border-[#D4AF37]/40 bg-[#080D09] text-xs text-[#FFFFFF] focus:outline-none focus:border-[#D4AF37]"
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
                    <label class="block text-xs font-mono text-[#B8A98E] mb-1">Pesan & Doa Restu</label>
                    <textarea
                        x-model="wishesInput"
                        rows="3"
                        placeholder="Tuliskan ucapan selamat & doa restu untuk kedua mempelai..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#D4AF37]/40 bg-[#080D09] text-xs text-[#FFFFFF] focus:outline-none focus:border-[#D4AF37]"
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isSubmittingRsvp"
                        class="shimmer-gold w-full py-3 rounded-xl text-[#0F1710] text-xs font-luxury-heading font-bold uppercase tracking-widest shadow-lg transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                        <i class="fa-solid" :class="isSubmittingRsvp ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                        <span x-text="isSubmittingRsvp ? 'Mengirimkan...' : 'Kirim Konfirmasi & Doa'"></span>
                    </button>
                </div>
            </form>

            <!-- Real-Time Wishes Feed (VIP Wishing Board) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-mono text-[#B8A98E]">VIP Wishes Received</span>
                    <span class="font-mono font-bold text-[#D4AF37]" x-text="wishesList.length + ' Ucapan'"></span>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2.5 pr-1">
                    <template x-for="(wish, idx) in wishesList" :key="idx">
                        <div class="bg-[#101913]/90 rounded-2xl p-4 shadow-sm border border-[#D4AF37]/20 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#18251B] border border-[#D4AF37]/50 text-[#D4AF37] flex items-center justify-center text-xs font-bold font-mono">
                                        <span x-text="wish.guest_name ? wish.guest_name.substring(0, 1).toUpperCase() : 'V'"></span>
                                    </div>
                                    <span class="font-bold text-xs text-[#FFFFFF]" x-text="wish.guest_name"></span>
                                </div>
                                <span
                                    class="text-[9px] font-mono px-2 py-0.5 rounded-full"
                                    :class="wish.attendance_status === 'attending' ? 'bg-emerald-900/60 text-emerald-300 border border-emerald-500/40' : (wish.attendance_status === 'not_attending' ? 'bg-neutral-800 text-neutral-400' : 'bg-amber-900/60 text-amber-300 border border-amber-500/40')"
                                    x-text="wish.attendance_status === 'attending' ? 'Hadir' : (wish.attendance_status === 'not_attending' ? 'Tidak Hadir' : 'Ragu-ragu')"
                                ></span>
                            </div>
                            <p class="text-xs text-[#B8A98E] leading-relaxed" x-text="wish.wishes || 'Memberikan doa restu.'"></p>
                            <span class="text-[9px] font-mono text-[#D4AF37]/60 block text-right" x-text="wish.created_at"></span>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 9. PENUTUP & KELUARGA BESAR                              -->
        <!-- ======================================================== -->
        <section class="py-14 px-6 text-center space-y-6">
            <div class="flex items-center justify-center gap-2 text-[#D4AF37] text-sm">
                <span>✦</span>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent"></div>
                <span>✦</span>
            </div>

            <div class="space-y-2">
                <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#D4AF37] font-semibold block">
                    Royal Gratitude
                </span>
                <h3 class="font-luxury-heading text-2xl sm:text-3xl font-bold text-[#FFFFFF]">
                    Sampai Jumpa di Hari Bahagia
                </h3>
            </div>

            <p class="text-xs text-[#B8A98E] leading-relaxed max-w-sm mx-auto">
                Merupakan suatu kehormatan dan kebahagiaan terbesar bagi kami apabila Anda berkenan hadir dan melimpahkan doa restu kepada kedua mempelai.
            </p>

            <p class="font-display italic text-base text-[#FFFFFF]">
                Wassalamu'alaikum Warahmatullahi Wabarakatuh
            </p>

            <!-- Family Names -->
            <div class="pt-4 border-t border-[#D4AF37]/20 space-y-1">
                <span class="text-[10px] font-mono uppercase text-[#D4AF37] tracking-wider block">Kami yang Berbahagia:</span>
                <p class="font-luxury-heading font-bold text-sm text-[#FFFFFF]">{{ $groomFullName }} & {{ $brideFullName }}</p>
                <p class="text-xs text-[#B8A98E]">Beserta Seluruh Keluarga Besar Kedua Mempelai</p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 10. FOOTER MINIMALIS                                     -->
        <!-- ======================================================== -->
        <footer class="py-8 px-6 text-center border-t border-[#D4AF37]/20 space-y-2 text-[#B8A98E]">
            <p class="font-luxury-heading text-xl font-bold text-[#D4AF37]">
                {{ $groomNickname }} & {{ $brideNickname }}
            </p>
            <p class="font-mono text-[10px] tracking-widest uppercase">
                {{ $eventFormattedDate }}
            </p>
            <div class="pt-2">
                <a
                    href="{{ url('/') }}"
                    class="inline-block text-[10px] font-mono text-[#D4AF37] hover:underline"
                >
                    Haute-Couture Digital Invitation by Maja Flower Atelier
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
        class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex items-center justify-center p-4 cursor-zoom-out"
    >
        <div class="relative max-w-md w-full bg-[#101913] p-3 rounded-2xl border border-[#D4AF37] shadow-2xl" @click.stop>
            <button
                type="button"
                @click="lightboxOpen = false"
                class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#D4AF37] text-[#080D09] flex items-center justify-center font-bold text-xs shadow-md hover:scale-110 transition"
            >✕</button>
            <img :src="lightboxImg" class="w-full rounded-xl aspect-[4/5] object-cover mb-2 border border-[#D4AF37]/30">
            <p class="font-mono text-xs text-center text-[#F5E6BE]" x-text="lightboxCaption"></p>
        </div>
    </div>
</body>
</html>
