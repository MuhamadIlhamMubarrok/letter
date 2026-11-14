<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $story->title }} — The Wedding Invitation | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-serif-luxury { font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif; }
        .font-display { font-family: 'Playfair Display', 'Cormorant Garamond', Georgia, serif; }

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

        /* Smooth arch styling */
        .arch-frame {
            border-top-left-radius: 9999px;
            border-top-right-radius: 9999px;
        }

        /* Vinyl rotation keyframe */
        @keyframes vinyl-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-vinyl {
            animation: vinyl-spin 8s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Luxury Sleek Scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(140, 109, 70, 0.35);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(140, 109, 70, 0.7);
        }
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(140, 109, 70, 0.35) transparent;
        }
    </style>

    <script>
        // Enforce top position immediately before DOM paint
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
    $groomNickname = $meta['groom_nickname'] ?? 'Rian';
    $brideNickname = $meta['bride_nickname'] ?? 'Adinda';

    // Groom Details
    $groomFullName = $meta['groom_full_name'] ?? ($story->sender_name ?: 'Rian Pratama, S.Kom.');
    $groomParents = $meta['groom_parents'] ?? 'Putra pertama dari Bpk. Hendra Wijaya & Ibu Sinta Dewi';
    $groomInstagram = $meta['groom_instagram'] ?? '@rianpratama';
    $groomBio = $meta['groom_bio'] ?? 'Sosok penyabar dan penuh perhatian yang selalu menjadi pelindung terbaik.';
    $groomPhoto = $meta['groom_photo'] ?? 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80';

    // Bride Details
    $brideFullName = $meta['bride_full_name'] ?? ($story->recipient_name ?: 'Adinda Kirana, S.Ds.');
    $brideParents = $meta['bride_parents'] ?? 'Putri kedua dari Bpk. Bambang Surya & Ibu Ratna Sari';
    $brideInstagram = $meta['bride_instagram'] ?? '@adindakrn';
    $brideBio = $meta['bride_bio'] ?? 'Sosok hangat, penuh senyuman dan energi positif yang mewarnai setiap hari.';
    $bridePhoto = $meta['bride_photo'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80';

    // Date & Countdown Target
    $eventDate = $story->event_date ?? \Carbon\Carbon::now()->addDays(28)->setHour(9)->setMinute(0);
    $eventDateIso = $eventDate->toIso8601String();
    $eventFormattedDate = $eventDate->translatedFormat('l, d F Y');

    // Ceremony (Akad)
    $ceremonyTime = $meta['ceremony_time'] ?? '08.00 - 10.00 WIB';
    $ceremonyVenue = $meta['ceremony_venue'] ?? 'Masjid Agung Al-Azhar';
    $ceremonyAddress = $meta['ceremony_address'] ?? 'Jl. Sisingamangaraja No. 1, Kebayoran Baru, Jakarta Selatan';
    $ceremonyMaps = $meta['ceremony_maps'] ?? ($meta['maps_url'] ?? 'https://maps.google.com/?q=Jakarta');

    // Reception (Resepsi)
    $receptionTime = $meta['reception_time'] ?? '11.00 - 14.00 WIB';
    $receptionVenue = $meta['reception_venue'] ?? ($meta['venue_name'] ?? 'Grand Glasshouse Ballroom Maja');
    $receptionAddress = $meta['reception_address'] ?? ($meta['venue_address'] ?? 'Jl. Melati Putih No. 28, Kebayoran Baru, Jakarta Selatan');
    $receptionMaps = $meta['reception_maps'] ?? ($meta['maps_url'] ?? 'https://maps.google.com/?q=Jakarta');

    // Gift Info
    $bank1 = $meta['bank_1'] ?? ['bank' => 'BCA', 'number' => '8801234567', 'holder' => 'Rian Pratama'];
    $bank2 = $meta['bank_2'] ?? ['bank' => 'Bank Mandiri', 'number' => '1370012345678', 'holder' => 'Adinda Kirana'];
    $giftAddress = $meta['gift_address'] ?? [
        'recipient' => 'Adinda & Rian (Maja Flower Studio)',
        'phone' => '0812-3456-7890',
        'address' => 'Jl. Melati Putih No. 28, Kebayoran Baru, Jakarta Selatan 12180'
    ];

    // Audio path
    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3');
    $audioTitle = $story->audio_title ?: 'Canon in D (Acoustic Romance)';
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
            'caption' => 'Dua Hati, Satu Janji Suci'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Melangkah Menuju Hari Bahagia'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
            'caption' => 'Senja Indah di Bawah Langit Cinta'
        ]
    ]);

    // Google Calendar Event Link
    $calStart = $eventDate->format('Ymd\THis\Z');
    $calEnd = $eventDate->copy()->addHours(6)->format('Ymd\THis\Z');
    $calTitle = rawurlencode("Pernikahan " . $groomNickname . " & " . $brideNickname);
    $calDetails = rawurlencode("Undangan Pernikahan Online: " . url()->current());
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
            'guest_name' => $r->guest_name ?? 'Tamu Undangan',
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
                        guest_name: 'Dimas & Sarah',
                        attendance_status: 'attending',
                        guest_count: 2,
                        wishes: 'Selamat menempuh hidup baru {{ $groomNickname }} & {{ $brideNickname }}! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah selalu.',
                        created_at: '2 jam yang lalu'
                    },
                    {
                        guest_name: 'Tante Maya & Keluarga',
                        attendance_status: 'attending',
                        guest_count: 3,
                        wishes: 'Barakallahu lakuma wa baraka alaikuma! Selamat ya anak-anakku tersayang. Sangat bahagia melihat kalian berdua.',
                        created_at: '1 hari yang lalu'
                    }
                ];
            }

            // Audio trimming loop listeners
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
                    this.triggerToast(`✅ ${label} berhasil disalin!`);
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
            this.triggerToast(`✅ ${label} berhasil disalin!`);
        },

        triggerToast(msg) {
            this.toastMessage = msg;
            this.toastVisible = true;
            setTimeout(() => { this.toastVisible = false; }, 3000);
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
                    this.rsvpSuccessMsg = data.message || 'Terima kasih atas doa restunya! ❤️';
                    const newEntry = data.rsvp ? data.rsvp : {
                        guest_name: payload.guest_name,
                        attendance_status: payload.attendance_status,
                        guest_count: payload.guest_count,
                        wishes: payload.wishes,
                        created_at: 'Baru saja'
                    };
                    this.wishesList.unshift(newEntry);
                    this.wishesInput = '';
                    this.triggerToast('💌 Ucapan doa restu Anda berhasil dikirim!');
                } else {
                    this.rsvpErrorMsg = data.message || 'Gagal mengirimkan ucapan.';
                }
            } catch (e) {
                // Offline fallback
                const fallbackEntry = {
                    guest_name: payload.guest_name,
                    attendance_status: payload.attendance_status,
                    guest_count: payload.guest_count,
                    wishes: payload.wishes,
                    created_at: 'Baru saja'
                };
                this.wishesList.unshift(fallbackEntry);
                this.wishesInput = '';
                this.rsvpSuccessMsg = 'Terima kasih atas doa restunya! ❤️ (Tersimpan lokal)';
                this.triggerToast('💌 Doa restu Anda berhasil disimpan!');
            } finally {
                this.isSubmittingRsvp = false;
            }
        }
    }"
    class="{{ request()->has('embed') ? 'bg-[#FAF7F2]' : 'bg-[#1F241F]' }} text-[#2C2A29] font-sans antialiased min-h-screen selection:bg-[#8C6D46] selection:text-white relative overflow-x-hidden scroll-locked"
    :class="{ 'h-screen max-h-screen overflow-hidden': !coverOpened }"
>
    <!-- AUDIO ELEMENT -->
    <audio x-ref="bgAudio" src="{{ $audioTrack }}" loop preload="auto"></audio>

    <!-- TOAST NOTIFICATION -->
    <div
        x-show="toastVisible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed top-6 inset-x-0 mx-auto z-50 max-w-xs px-4 py-3 rounded-2xl bg-[#2C2A29]/95 text-white text-xs font-mono font-semibold shadow-2xl backdrop-blur-md border border-white/20 text-center flex items-center justify-center gap-2"
        x-cloak
    >
        <i class="fa-solid fa-circle-check text-[#8C6D46]"></i>
        <span x-text="toastMessage"></span>
    </div>

    <!-- LIGHTBOX MODAL PREVIEW -->
    <div
        x-show="lightboxOpen"
        x-cloak
        @click.away="lightboxOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md select-none"
    >
        <div class="relative max-w-md w-full text-center">
            <button @click="lightboxOpen = false" class="absolute -top-12 right-0 text-white text-xl p-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img :src="lightboxImg" :alt="lightboxCaption" class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl mx-auto border border-white/10" />
            <p class="text-white/80 text-xs font-mono mt-3" x-text="lightboxCaption"></p>
        </div>
    </div>

    @if(isset($isDemo) && $isDemo)
        @include('digital-story.components.demo-banner')
    @endif

    <!-- ======================================================== -->
    <!-- DESKTOP CONTAINER: Centered 480px Smartphone Layout     -->
    <!-- ======================================================== -->
    <div
        class="max-w-[480px] mx-auto min-h-screen bg-[#FAF7F2] {{ request()->has('embed') ? '' : 'shadow-2xl border-x border-[#8C6D46]/15' }} relative overflow-hidden pb-24"
        :class="{ 'h-screen max-h-screen overflow-hidden': !coverOpened }"
    >

        <!-- ======================================================== -->
        <!-- 1. GLOBAL FLOATING UI (Floating Audio & Bottom Bar)      -->
        <!-- ======================================================== -->
        <div x-show="coverOpened || isPlaying" x-transition.opacity.duration.500ms class="z-40">
            <!-- Floating Music Player Button -->
            <button
                type="button"
                @click="toggleAudio()"
                class="fixed top-5 right-5 z-40 w-11 h-11 rounded-full bg-[#FAF7F2]/90 border border-[#8C6D46]/40 shadow-xl backdrop-blur-md flex items-center justify-center text-[#8C6D46] hover:scale-105 active:scale-95 transition cursor-pointer"
                :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
            >
                <div class="relative w-8 h-8 rounded-full flex items-center justify-center" :class="{ 'animate-vinyl': isPlaying, 'paused': !isPlaying }">
                    <i class="fa-solid fa-compact-disc text-xl"></i>
                </div>
            </button>

            <!-- Bottom Floating Navigation Bar -->
            <nav class="fixed bottom-3 inset-x-0 max-w-[440px] mx-auto z-40 px-3">
                <div class="bg-[#2C2A29]/90 border border-[#8C6D46]/40 backdrop-blur-lg rounded-2xl py-2 px-3 shadow-2xl flex items-center justify-around text-white/70">
                    <a href="#cover" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-heart text-xs mb-0.5"></i>
                        <span>Cover</span>
                    </a>
                    <a href="#mempelai" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-user-group text-xs mb-0.5"></i>
                        <span>Mempelai</span>
                    </a>
                    <a href="#acara" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-calendar-check text-xs mb-0.5"></i>
                        <span>Acara</span>
                    </a>
                    <a href="#galeri" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-images text-xs mb-0.5"></i>
                        <span>Galeri</span>
                    </a>
                    <a href="#kado" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-gift text-xs mb-0.5"></i>
                        <span>Kado</span>
                    </a>
                    <a href="#rsvp" class="flex flex-col items-center hover:text-[#8C6D46] transition text-[10px]">
                        <i class="fa-solid fa-envelope-open-text text-xs mb-0.5"></i>
                        <span>RSVP</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- ======================================================== -->
        <!-- 2. COVER UNDANGAN (Hero Cover & Opening Trigger)         -->
        <!-- ======================================================== -->
        <section
            id="cover"
            class="fixed inset-0 z-50 max-w-[480px] mx-auto min-h-screen min-h-[100dvh] flex flex-col justify-between items-center p-5 sm:p-8 text-center select-none overflow-hidden transition-all duration-700 ease-in-out touch-none overscroll-none"
            :class="{ '-translate-y-full opacity-0 pointer-events-none': coverOpened }"
            style="background: linear-gradient(180deg, rgba(250,247,242,0.5) 0%, rgba(250,247,242,0.96) 85%), url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80') center/cover no-repeat;"
        >
            <!-- Decorative Arch Outline -->
            <div class="absolute inset-3 sm:inset-4 arch-frame border border-[#8C6D46]/25 pointer-events-none"></div>

            <!-- Top Header Label -->
            <div class="relative z-10 pt-4 sm:pt-8">
                <span class="inline-block px-3.5 py-1 rounded-full bg-[#8C6D46]/10 border border-[#8C6D46]/30 text-[#8C6D46] font-mono text-[9px] sm:text-[10px] tracking-[0.25em] uppercase font-semibold">
                    The Wedding Of
                </span>
            </div>

            <!-- Couple Name Big Display -->
            <div class="relative z-10 space-y-1.5 sm:space-y-2 my-auto py-3">
                <div class="w-12 h-12 mx-auto rounded-full bg-[#8C6D46]/15 border border-[#8C6D46]/35 flex items-center justify-center text-lg text-[#8C6D46] shadow-inner mb-2">
                    💍
                </div>
                <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-[#2C2A29] tracking-tight leading-tight">
                    {{ $groomNickname }} <span class="text-[#8C6D46] italic font-normal">&</span> {{ $brideNickname }}
                </h1>
                <p class="font-mono text-[11px] sm:text-xs text-[#6E6A66] tracking-wider uppercase">
                    {{ $eventFormattedDate }}
                </p>
            </div>

            <!-- Personal Guest Card on Cover -->
            <div class="relative z-10 w-full max-w-sm space-y-3 pb-4 sm:pb-6">
                <div class="bg-white/95 border border-[#8C6D46]/30 rounded-2xl p-3.5 sm:p-4 shadow-xl backdrop-blur-sm space-y-1">
                    <span class="font-mono text-[9px] sm:text-[10px] uppercase tracking-[0.2em] text-[#6E6A66] block">
                        Kepada Yth. Bapak/Ibu/Saudara/i:
                    </span>
                    <h2 class="font-serif-luxury text-lg sm:text-2xl font-bold text-[#2C2A29] tracking-tight">
                        {{ $displayGuest }}
                    </h2>
                    <span class="font-mono text-[10px] sm:text-[11px] text-[#8C6D46] font-medium block">
                        di Tempat
                    </span>
                </div>

                <!-- Buka Undangan Button -->
                <button
                    type="button"
                    @click="openInvitation()"
                    class="group w-full py-3 sm:py-3.5 px-6 rounded-2xl bg-gradient-to-r from-[#8C6D46] via-[#9e7d52] to-[#8C6D46] text-white font-mono text-xs font-bold shadow-xl hover:shadow-[#8C6D46]/40 hover:scale-[1.02] active:scale-95 transition-all duration-300 border border-white/20 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i class="fa-solid fa-envelope-open text-sm group-hover:rotate-12 transition-transform"></i>
                    <span>Buka Undangan</span>
                </button>

                <p class="font-mono text-[9px] text-[#6E6A66] pt-1">
                    *Sentuh tombol di atas untuk membuka undangan & memutar musik
                </p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- INVITATION MAIN CONTENT (Fades in & unlocks after cover) -->
        <!-- ======================================================== -->
        <main
            id="invitation-main-content"
            class="transition-opacity duration-700"
            :class="{ 'opacity-0 pointer-events-none': !coverOpened, 'opacity-100 pointer-events-auto': coverOpened }"
        >

        <!-- ======================================================== -->
        <!-- 3. PEMBUKA (Quote & Salam Suci)                         -->
        <!-- ======================================================== -->
        <section id="pembuka" class="py-14 px-6 text-center space-y-6 relative">
            <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full"></div>
            
            <span class="font-mono text-[10px] tracking-[0.25em] uppercase text-[#8C6D46] font-semibold block">
                Doa & Salam Pembuka
            </span>

            <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-[#2C2A29]">
                Assalamu'alaikum Warahmatullahi Wabarakatuh
            </h3>

            <!-- Quran Quote Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/20 relative space-y-4">
                <div class="text-2xl text-[#8C6D46]/40 font-serif">“</div>
                <p class="font-serif-luxury italic text-sm sm:text-base text-[#2C2A29]/90 leading-relaxed">
                    "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."
                </p>
                <span class="font-mono text-xs text-[#8C6D46] font-semibold block">
                    — Q.S. Ar-Rum: 21 —
                </span>
            </div>

            <p class="text-xs text-[#6E6A66] leading-relaxed max-w-sm mx-auto">
                Dengan penuh rasa syukur dan memohon rahmat serta ridho Allah Subhanahu Wa Ta'ala, kami bermaksud menyelenggarakan syukuran pernikahan putra-putri kami:
            </p>
        </section>

        <!-- ======================================================== -->
        <!-- 4. PROFIL MEMPELAI (Pria & Wanita)                      -->
        <!-- ======================================================== -->
        <section id="mempelai" class="py-12 px-6 space-y-10">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Pasangan Pengantin
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    Kedua Mempelai
                </h3>
                <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Mempelai Pria -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/20 text-center space-y-4">
                <div class="relative w-40 h-52 mx-auto arch-frame overflow-hidden border-2 border-[#8C6D46]/30 shadow-md">
                    <img src="{{ $groomPhoto }}" alt="{{ $groomFullName }}" class="w-full h-full object-cover" />
                </div>
                <div>
                    <h4 class="font-serif-luxury text-2xl font-bold text-[#2C2A29]">
                        {{ $groomFullName }}
                    </h4>
                    <p class="text-xs text-[#6E6A66] mt-1">
                        {{ $groomParents }}
                    </p>
                    <p class="text-[11px] text-[#6E6A66]/80 italic mt-2">
                        "{{ $groomBio }}"
                    </p>
                    <div class="mt-3">
                        <a
                            href="https://instagram.com/{{ ltrim($groomInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#FAF7F2] border border-[#8C6D46]/30 text-[#8C6D46] text-xs font-mono hover:bg-[#8C6D46] hover:text-white transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $groomInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Monogram Divider -->
            <div class="text-center">
                <span class="font-serif-luxury text-4xl italic text-[#8C6D46] font-normal">&</span>
            </div>

            <!-- Mempelai Wanita -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/20 text-center space-y-4">
                <div class="relative w-40 h-52 mx-auto arch-frame overflow-hidden border-2 border-[#8C6D46]/30 shadow-md">
                    <img src="{{ $bridePhoto }}" alt="{{ $brideFullName }}" class="w-full h-full object-cover" />
                </div>
                <div>
                    <h4 class="font-serif-luxury text-2xl font-bold text-[#2C2A29]">
                        {{ $brideFullName }}
                    </h4>
                    <p class="text-xs text-[#6E6A66] mt-1">
                        {{ $brideParents }}
                    </p>
                    <p class="text-[11px] text-[#6E6A66]/80 italic mt-2">
                        "{{ $brideBio }}"
                    </p>
                    <div class="mt-3">
                        <a
                            href="https://instagram.com/{{ ltrim($brideInstagram, '@') }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#FAF7F2] border border-[#8C6D46]/30 text-[#8C6D46] text-xs font-mono hover:bg-[#8C6D46] hover:text-white transition"
                        >
                            <i class="fa-brands fa-instagram"></i>
                            <span>{{ $brideInstagram }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 5. COUNTDOWN & SAVE THE DATE                            -->
        <!-- ======================================================== -->
        <section class="py-12 px-6 bg-[#F5EFE6] border-y border-[#8C6D46]/20 text-center space-y-6">
            <div class="space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Save The Date
                </span>
                <h3 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#2C2A29]">
                    Menuju Hari Bahagia
                </h3>
                <p class="text-xs text-[#6E6A66] font-mono">
                    {{ $eventFormattedDate }}
                </p>
            </div>

            <!-- Live Timer Grid -->
            <div class="grid grid-cols-4 gap-2.5 max-w-xs mx-auto">
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-[#8C6D46]/20">
                    <span class="font-mono text-2xl font-bold text-[#2C2A29] block" x-text="days">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#6E6A66]">Hari</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-[#8C6D46]/20">
                    <span class="font-mono text-2xl font-bold text-[#2C2A29] block" x-text="hours">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#6E6A66]">Jam</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-[#8C6D46]/20">
                    <span class="font-mono text-2xl font-bold text-[#2C2A29] block" x-text="minutes">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#6E6A66]">Menit</span>
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-[#8C6D46]/20">
                    <span class="font-mono text-2xl font-bold text-[#8C6D46] block" x-text="seconds">0</span>
                    <span class="font-mono text-[9px] uppercase tracking-wider text-[#6E6A66]">Detik</span>
                </div>
            </div>

            <!-- Save To Google Calendar Button -->
            <div>
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white hover:bg-[#8C6D46] text-[#8C6D46] hover:text-white border border-[#8C6D46]/40 text-xs font-mono font-semibold shadow-md transition"
                >
                    <i class="fa-solid fa-calendar-plus text-sm"></i>
                    <span>Simpan ke Google Calendar</span>
                </a>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 6. WAKTU & LOKASI ACARA (Akad & Resepsi 2 Kartu)         -->
        <!-- ======================================================== -->
        <section id="acara" class="py-12 px-6 space-y-8">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Rangkaian Acara
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    Waktu & Tempat
                </h3>
                <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Card 1: Akad Nikah -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/25 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#8C6D46]/10 text-[#8C6D46] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-handshake-simple"></i>
                </div>
                <div>
                    <h4 class="font-serif-luxury text-2xl font-bold text-[#2C2A29]">Akad Nikah</h4>
                    <span class="font-mono text-xs text-[#8C6D46] font-semibold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#6E6A66] mt-0.5">
                        Pukul {{ $ceremonyTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#8C6D46]/15 space-y-1">
                    <p class="font-bold text-sm text-[#2C2A29]">{{ $ceremonyVenue }}</p>
                    <p class="text-xs text-[#6E6A66] leading-relaxed">{{ $ceremonyAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $ceremonyMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#8C6D46] hover:bg-[#775a36] text-white text-xs font-mono font-semibold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Resepsi Pernikahan -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/25 text-center space-y-4 relative overflow-hidden">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#8C6D46]/10 text-[#8C6D46] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <div>
                    <h4 class="font-serif-luxury text-2xl font-bold text-[#2C2A29]">Resepsi Pernikahan</h4>
                    <span class="font-mono text-xs text-[#8C6D46] font-semibold block mt-1">
                        {{ $eventFormattedDate }}
                    </span>
                    <p class="font-mono text-xs text-[#6E6A66] mt-0.5">
                        Pukul {{ $receptionTime }}
                    </p>
                </div>
                <div class="pt-3 border-t border-[#8C6D46]/15 space-y-1">
                    <p class="font-bold text-sm text-[#2C2A29]">{{ $receptionVenue }}</p>
                    <p class="text-xs text-[#6E6A66] leading-relaxed">{{ $receptionAddress }}</p>
                </div>
                <div>
                    <a
                        href="{{ $receptionMaps }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#8C6D46] hover:bg-[#775a36] text-white text-xs font-mono font-semibold shadow-md transition"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Buka Google Maps</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 7. GALERI FOTO PREWEDDING & LOVE STORY                  -->
        <!-- ======================================================== -->
        <section id="galeri" class="py-12 px-6 space-y-8 bg-[#F5EFE6]/60 border-y border-[#8C6D46]/20">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Galeri Kenangan
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    Kisah Kasih & Foto
                </h3>
                <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- Prewedding Photo Grid -->
            <div class="grid grid-cols-2 gap-3">
                @foreach($mediaItems as $idx => $m)
                    <div
                        @click="openLightbox('{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}', '{{ addslashes($m->caption ?? '') }}')"
                        class="group relative overflow-hidden rounded-2xl shadow-sm border border-[#8C6D46]/20 aspect-[4/5] cursor-pointer hover:scale-[1.02] transition"
                    >
                        <img
                            src="{{ $m->file_url ?? Storage::disk('public')->url($m->file_path ?? '') }}"
                            alt="{{ $m->caption ?? 'Foto Prewedding' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-2.5">
                            <span class="text-white text-[10px] font-mono truncate">{{ $m->caption ?? 'Klik untuk memperbesar' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Love Story Timeline Vertikal -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/20 space-y-5">
                <h4 class="font-serif-luxury text-xl font-bold text-center text-[#2C2A29]">
                    Perjalanan Cinta Kami
                </h4>

                <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#8C6D46]/30">
                    <!-- Point 1 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-[#8C6D46] border-2 border-white"></div>
                        <span class="font-mono text-[10px] text-[#8C6D46] font-bold block">Tahun 2021</span>
                        <h5 class="font-serif-luxury font-bold text-sm text-[#2C2A29]">Pertama Kali Bertemu</h5>
                        <p class="text-xs text-[#6E6A66] mt-0.5 leading-relaxed">
                            Dipertemukan di bangku perkuliahan dalam kepanitiaan seni kampus, berawal dari tatapan mata dan obrolan sederhana.
                        </p>
                    </div>

                    <!-- Point 2 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-[#8C6D46] border-2 border-white"></div>
                        <span class="font-mono text-[10px] text-[#8C6D46] font-bold block">Tahun 2023</span>
                        <h5 class="font-serif-luxury font-bold text-sm text-[#2C2A29]">Komitmen Bersama</h5>
                        <p class="text-xs text-[#6E6A66] mt-0.5 leading-relaxed">
                            Memutuskan untuk melangkah bersama dengan komitmen yang teguh dan saling mengenalkan kepada keluarga besar.
                        </p>
                    </div>

                    <!-- Point 3 -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-[#8C6D46] border-2 border-white"></div>
                        <span class="font-mono text-[10px] text-[#8C6D46] font-bold block">Tahun 2026</span>
                        <h5 class="font-serif-luxury font-bold text-sm text-[#2C2A29]">Menuju Hari Bahagia</h5>
                        <p class="text-xs text-[#6E6A66] mt-0.5 leading-relaxed">
                            Mengikat janji suci pernikahan untuk saling menyayangi, menghormati, dan melengkapi hingga hari tua.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dress Code Recommendation Card -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-[#8C6D46]/20 text-center space-y-2">
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#8C6D46] font-semibold block">
                    Dress Code Tamu
                </span>
                <p class="text-xs text-[#2C2A29] font-medium">Earth Tone / Sage Green & Warm Terracotta</p>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <span class="w-5 h-5 rounded-full bg-[#7D8F7B] shadow-xs" title="Sage Green"></span>
                    <span class="w-5 h-5 rounded-full bg-[#C49B71] shadow-xs" title="Warm Muted Gold"></span>
                    <span class="w-5 h-5 rounded-full bg-[#B87A64] shadow-xs" title="Terracotta"></span>
                    <span class="w-5 h-5 rounded-full bg-[#F4E8D8] border border-black/10 shadow-xs" title="Warm Cream"></span>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 8. WEDDING GIFT (Amplop Digital & Kado Fisik)            -->
        <!-- ======================================================== -->
        <section id="kado" class="py-12 px-6 space-y-6">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Tanda Kasih
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    Wedding Gift
                </h3>
                <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <p class="text-xs text-[#6E6A66] text-center leading-relaxed">
                Doa restu Anda merupakan karunia terindah bagi kami. Namun apabila Anda berkehendak memberikan tanda kasih, dapat mengirimkannya melalui:
            </p>

            <!-- Bank Transfer 1 -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-[#8C6D46]/25 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#8C6D46] uppercase">{{ $bank1['bank'] }}</span>
                    <i class="fa-solid fa-credit-card text-[#8C6D46]"></i>
                </div>
                <div>
                    <span class="font-mono text-lg font-bold text-[#2C2A29] block tracking-wider">{{ $bank1['number'] }}</span>
                    <span class="text-xs text-[#6E6A66]">a.n {{ $bank1['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank1['number'] }}', 'No. Rekening {{ $bank1['bank'] }}')"
                        class="w-full py-2 rounded-xl bg-[#FAF7F2] hover:bg-[#8C6D46] text-[#8C6D46] hover:text-white border border-[#8C6D46]/30 text-xs font-mono font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Bank Transfer 2 -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-[#8C6D46]/25 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#8C6D46] uppercase">{{ $bank2['bank'] }}</span>
                    <i class="fa-solid fa-building-columns text-[#8C6D46]"></i>
                </div>
                <div>
                    <span class="font-mono text-lg font-bold text-[#2C2A29] block tracking-wider">{{ $bank2['number'] }}</span>
                    <span class="text-xs text-[#6E6A66]">a.n {{ $bank2['holder'] }}</span>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ $bank2['number'] }}', 'No. Rekening {{ $bank2['bank'] }}')"
                        class="w-full py-2 rounded-xl bg-[#FAF7F2] hover:bg-[#8C6D46] text-[#8C6D46] hover:text-white border border-[#8C6D46]/30 text-xs font-mono font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin No. Rekening</span>
                    </button>
                </div>
            </div>

            <!-- Kirim Kado Fisik -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-[#8C6D46]/25 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-[#8C6D46] uppercase">Kirim Kado Fisik</span>
                    <i class="fa-solid fa-box-open text-[#8C6D46]"></i>
                </div>
                <div class="text-xs text-[#6E6A66] space-y-1">
                    <p class="font-bold text-[#2C2A29]">{{ $giftAddress['recipient'] }}</p>
                    <p class="font-mono">{{ $giftAddress['phone'] }}</p>
                    <p class="leading-relaxed">{{ $giftAddress['address'] }}</p>
                </div>
                <div>
                    <button
                        type="button"
                        @click="copyText('{{ addslashes($giftAddress['address'] . ' (' . $giftAddress['recipient'] . ' - ' . $giftAddress['phone'] . ')') }}', 'Alamat Kirim Kado')"
                        class="w-full py-2 rounded-xl bg-[#FAF7F2] hover:bg-[#8C6D46] text-[#8C6D46] hover:text-white border border-[#8C6D46]/30 text-xs font-mono font-semibold transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Salin Alamat Kado</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 9. RSVP & KOLOM UCAPAN REAL-TIME FEED                    -->
        <!-- ======================================================== -->
        <section id="rsvp" class="py-12 px-6 space-y-8 bg-[#F5EFE6]/60 border-y border-[#8C6D46]/20">
            <div class="text-center space-y-1">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Konfirmasi Kehadiran
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    RSVP & Doa Restu
                </h3>
                <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full mt-2"></div>
            </div>

            <!-- RSVP Form -->
            <form @submit.prevent="submitRsvp" class="bg-white rounded-3xl p-6 shadow-sm border border-[#8C6D46]/25 space-y-4">
                <template x-if="rsvpSuccessMsg">
                    <div class="p-3 bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-mono rounded-xl text-center" x-text="rsvpSuccessMsg"></div>
                </template>
                <template x-if="rsvpErrorMsg">
                    <div class="p-3 bg-rose-50 border border-rose-300 text-rose-800 text-xs font-mono rounded-xl text-center" x-text="rsvpErrorMsg"></div>
                </template>

                <div>
                    <label class="block text-xs font-mono text-[#6E6A66] mb-1">Nama Lengkap Anda</label>
                    <input
                        type="text"
                        x-model="guestNameInput"
                        placeholder="Contoh: Budi Santoso & Keluarga"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#8C6D46]/30 bg-[#FAF7F2] text-xs text-[#2C2A29] focus:outline-none focus:border-[#8C6D46]"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-[#6E6A66] mb-1">Konfirmasi Hadir</label>
                        <select
                            x-model="attendanceInput"
                            class="w-full px-3 py-2.5 rounded-xl border border-[#8C6D46]/30 bg-[#FAF7F2] text-xs text-[#2C2A29] focus:outline-none focus:border-[#8C6D46]"
                        >
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="tentative">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-[#6E6A66] mb-1">Jumlah Tamu</label>
                        <select
                            x-model="guestCountInput"
                            class="w-full px-3 py-2.5 rounded-xl border border-[#8C6D46]/30 bg-[#FAF7F2] text-xs text-[#2C2A29] focus:outline-none focus:border-[#8C6D46]"
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
                    <label class="block text-xs font-mono text-[#6E6A66] mb-1">Pesan & Doa Restu</label>
                    <textarea
                        x-model="wishesInput"
                        rows="3"
                        placeholder="Tuliskan ucapan selamat & doa restu untuk kedua mempelai..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#8C6D46]/30 bg-[#FAF7F2] text-xs text-[#2C2A29] focus:outline-none focus:border-[#8C6D46]"
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isSubmittingRsvp"
                        class="w-full py-3 rounded-xl bg-[#8C6D46] hover:bg-[#775a36] text-white text-xs font-mono font-bold shadow-md transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                        <i class="fa-solid" :class="isSubmittingRsvp ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                        <span x-text="isSubmittingRsvp ? 'Mengirimkan...' : 'Kirim Konfirmasi & Doa'"></span>
                    </button>
                </div>
            </form>

            <!-- Real-Time Wishes Feed -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-mono text-[#6E6A66]">Ucapan Doa Restu Masuk</span>
                    <span class="font-mono font-bold text-[#8C6D46]" x-text="wishesList.length + ' Ucapan'"></span>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2.5 pr-1">
                    <template x-for="(wish, idx) in wishesList" :key="idx">
                        <div class="bg-white rounded-2xl p-4 shadow-xs border border-[#8C6D46]/15 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#8C6D46]/15 text-[#8C6D46] flex items-center justify-center text-xs font-bold font-mono">
                                        <span x-text="wish.guest_name ? wish.guest_name.substring(0, 1).toUpperCase() : 'G'"></span>
                                    </div>
                                    <span class="font-bold text-xs text-[#2C2A29]" x-text="wish.guest_name"></span>
                                </div>
                                <span
                                    class="text-[9px] font-mono px-2 py-0.5 rounded-full"
                                    :class="wish.attendance_status === 'attending' ? 'bg-emerald-100 text-emerald-800' : (wish.attendance_status === 'not_attending' ? 'bg-neutral-100 text-neutral-600' : 'bg-amber-100 text-amber-800')"
                                    x-text="wish.attendance_status === 'attending' ? 'Hadir' : (wish.attendance_status === 'not_attending' ? 'Tidak Hadir' : 'Ragu-ragu')"
                                ></span>
                            </div>
                            <p class="text-xs text-[#6E6A66] leading-relaxed" x-text="wish.wishes || 'Memberikan doa restu.'"></p>
                            <span class="text-[9px] font-mono text-[#6E6A66]/60 block text-right" x-text="wish.created_at"></span>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 10. PENUTUP (Closing & Keluarga Besar)                   -->
        <!-- ======================================================== -->
        <section class="py-14 px-6 text-center space-y-6">
            <div class="w-12 h-0.5 bg-[#8C6D46]/40 mx-auto rounded-full"></div>

            <div class="space-y-2">
                <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[#8C6D46] font-semibold block">
                    Ungkapan Terima Kasih
                </span>
                <h3 class="font-serif-luxury text-3xl font-bold text-[#2C2A29]">
                    Sampai Jumpa di Hari Bahagia
                </h3>
            </div>

            <p class="text-xs text-[#6E6A66] leading-relaxed max-w-sm mx-auto">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kedua mempelai.
            </p>

            <p class="font-serif-luxury italic text-base text-[#2C2A29]">
                Wassalamu'alaikum Warahmatullahi Wabarakatuh
            </p>

            <!-- Family Names -->
            <div class="pt-4 border-t border-[#8C6D46]/15 space-y-1">
                <span class="text-[10px] font-mono uppercase text-[#8C6D46] tracking-wider block">Kami yang Berbahagia:</span>
                <p class="font-bold text-sm text-[#2C2A29]">{{ $groomFullName }} & {{ $brideFullName }}</p>
                <p class="text-xs text-[#6E6A66]">Beserta Seluruh Keluarga Besar Kedua Mempelai</p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 11. FOOTER MINIMALIS                                    -->
        <!-- ======================================================== -->
        <footer class="py-8 px-6 text-center border-t border-[#8C6D46]/20 space-y-2 text-[#6E6A66]">
            <p class="font-serif-luxury text-xl font-bold text-[#8C6D46]">
                {{ $groomNickname }} & {{ $brideNickname }}
            </p>
            <p class="font-mono text-[10px] tracking-widest uppercase">
                {{ $eventFormattedDate }}
            </p>
            <div class="pt-2">
                <a
                    href="{{ url('/') }}"
                    class="inline-block text-[10px] font-mono text-[#8C6D46] hover:underline"
                >
                    Digital Invitation by Maja Flower Atelier
                </a>
            </div>
        </footer>
        </main>
    </div>
</body>
</html>
