<?php
    // 0. Resolve Theme Preset & Color Palette
    $activePresetKey = $themePreset ?? ($template?->value ?? ($story->template_key?->value ?? 'online_love_letter'));

    $themePresets = [
        'online_love_letter' => [
            'edition_badge' => '💌 Special Delivery',
            'edition_title' => 'Surat Cinta Online (Modern Flagship)',
            'bg_outer' => '#2A1D20',
            'bg_container' => '#FFF5F7',
            'border_color' => 'rgba(255, 77, 109, 0.25)',
            'accent_primary' => '#FF4D6D',
            'accent_gradient' => 'from-[#FF4D6D] via-[#ff6584] to-[#E07A5F]',
            'accent_soft' => '#FFF0F3',
            'accent_text' => 'text-[#FF4D6D]',
            'text_main' => 'text-[#3D2C2E]',
            'text_main_hex' => '#3D2C2E',
            'text_muted' => 'text-[#7A5C61]',
            'card_bg' => 'bg-white',
            'notebook_line_color' => '#FFD1DC',
            'wax_seal' => '❤️',
            'aura_gradient' => 'from-[#FF4D6D]/20 via-[#FFAFCC]/30 to-[#FF4D6D]/20',
            'washi_bg' => 'rgba(255, 230, 235, 0.85)',
            'washi_border' => 'rgba(255, 77, 109, 0.3)',
            'confetti_colors' => ['#FF4D6D', '#FF758F', '#FF8FA3', '#FFAFCC', '#FFCCD5', '#FFF0F3'],
        ],
        'vintage_envelope' => [
            'edition_badge' => '💌 Vintage Botanical Edition',
            'edition_title' => 'Vintage Botanical Envelope',
            'bg_outer' => '#1E231D',
            'bg_container' => '#FAF6F0',
            'border_color' => 'rgba(140, 109, 70, 0.25)',
            'accent_primary' => '#8C6D46',
            'accent_gradient' => 'from-[#8C6D46] via-[#A88B64] to-[#346739]',
            'accent_soft' => '#F4EFE6',
            'accent_text' => 'text-[#8C6D46]',
            'text_main' => 'text-[#2C2117]',
            'text_main_hex' => '#2C2117',
            'text_muted' => 'text-[#6B5A4B]',
            'card_bg' => 'bg-white',
            'notebook_line_color' => '#E8DEC8',
            'wax_seal' => '🌿',
            'aura_gradient' => 'from-[#8C6D46]/20 via-[#A88B64]/30 to-[#346739]/20',
            'washi_bg' => 'rgba(235, 225, 210, 0.85)',
            'washi_border' => 'rgba(140, 109, 70, 0.3)',
            'confetti_colors' => ['#8C6D46', '#A88B64', '#79AE6F', '#346739', '#F2EDC2'],
        ],
        'midnight_rose' => [
            'edition_badge' => '🌹 Midnight Rose Edition',
            'edition_title' => 'Midnight Rose Luxury',
            'bg_outer' => '#0A0E0A',
            'bg_container' => '#141114',
            'border_color' => 'rgba(225, 29, 72, 0.35)',
            'accent_primary' => '#E11D48',
            'accent_gradient' => 'from-[#E11D48] via-[#BE123C] to-[#881337]',
            'accent_soft' => '#2A141D',
            'accent_text' => 'text-[#E11D48]',
            'text_main' => 'text-[#F5E6ED]',
            'text_main_hex' => '#F5E6ED',
            'text_muted' => 'text-[#D1A7B9]',
            'card_bg' => 'bg-[#1C171A]',
            'notebook_line_color' => '#3E1C28',
            'wax_seal' => '🌹',
            'aura_gradient' => 'from-[#E11D48]/30 via-[#BE123C]/30 to-[#E11D48]/30',
            'washi_bg' => 'rgba(60, 20, 35, 0.85)',
            'washi_border' => 'rgba(225, 29, 72, 0.4)',
            'confetti_colors' => ['#E11D48', '#BE123C', '#FB7185', '#FDA4AF', '#FFE4E6'],
        ],
        'retro_polaroid' => [
            'edition_badge' => '🎞️ Retro Scrapbook Edition',
            'edition_title' => 'Retro Polaroid Scrapbook',
            'bg_outer' => '#211A15',
            'bg_container' => '#F5EBE1',
            'border_color' => 'rgba(217, 119, 6, 0.25)',
            'accent_primary' => '#D97706',
            'accent_gradient' => 'from-[#D97706] via-[#B45309] to-[#854D0E]',
            'accent_soft' => '#FEF3C7',
            'accent_text' => 'text-[#B45309]',
            'text_main' => 'text-[#2C2117]',
            'text_main_hex' => '#2C2117',
            'text_muted' => 'text-[#78593F]',
            'card_bg' => 'bg-[#FFFDF9]',
            'notebook_line_color' => '#E4D5C3',
            'wax_seal' => '🎞️',
            'aura_gradient' => 'from-[#D97706]/20 via-[#F59E0B]/30 to-[#B45309]/20',
            'washi_bg' => 'rgba(240, 225, 205, 0.85)',
            'washi_border' => 'rgba(217, 119, 6, 0.35)',
            'confetti_colors' => ['#D97706', '#F59E0B', '#B45309', '#FEF3C7', '#854D0E'],
        ],
        'minimalist_aesthetic' => [
            'edition_badge' => '🌿 Modern Aesthetic Edition',
            'edition_title' => 'Modern Aesthetic Pastel',
            'bg_outer' => '#151D16',
            'bg_container' => '#F8FAF7',
            'border_color' => 'rgba(52, 103, 57, 0.2)',
            'accent_primary' => '#346739',
            'accent_gradient' => 'from-[#346739] via-[#437d49] to-[#79AE6F]',
            'accent_soft' => '#EAF2E8',
            'accent_text' => 'text-[#346739]',
            'text_main' => 'text-[#1F291E]',
            'text_main_hex' => '#1F291E',
            'text_muted' => 'text-[#50634E]',
            'card_bg' => 'bg-white',
            'notebook_line_color' => '#D9E6D7',
            'wax_seal' => '🍃',
            'aura_gradient' => 'from-[#346739]/20 via-[#79AE6F]/30 to-[#9FCB98]/20',
            'washi_bg' => 'rgba(225, 240, 225, 0.85)',
            'washi_border' => 'rgba(52, 103, 57, 0.3)',
            'confetti_colors' => ['#346739', '#79AE6F', '#9FCB98', '#F2EDC2', '#FAF8E8'],
        ],
    ];

    $cfg = $themePresets[$activePresetKey] ?? $themePresets['online_love_letter'];

    // 1. Resolve Recipient Name (?to=..., ?u=..., ?nama=...)
    $paramTo = request()->query('to', request()->query('u', request()->query('nama', request()->query('guest'))));
    $recipientName = $paramTo ? trim($paramTo) : ($story->recipient_name ?: 'Sayangku yang Lucu');
    $senderName = $story->sender_name ?: 'Aku yang Selalu Sayang Kamu';
    $storyTitle = $story->title ?: 'Surat Rahasia Untuk Manusia Paling Lucu 💌';

    // 2. Resolve Audio Track
    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-romantic-moment-1144.mp3');
    $audioTitle = $story->audio_title ?: 'Melodi Romantis Paling Manis';
    $audioStartSec = (float) ($story->audio_start_sec ?? 0);
    $audioEndSec = $story->audio_end_sec !== null ? (float) $story->audio_end_sec : null;

    // 3. Resolve Togetherness Days Counter
    $startDate = $story->event_date ?? \Carbon\Carbon::now()->subDays(520);
    $daysTogether = max(1, (int) \Carbon\Carbon::now()->diffInDays($startDate));

    // 4. Default Photos with 3D Flip Backstory
    $mediaItems = $story->media && $story->media->count() > 0 ? $story->media : collect([
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=600&q=80',
            'front_caption' => 'Kencan Pertama Kita 🌸',
            'back_story' => 'Muka kamu waktu pertama kali ketemu tegang banget, padahal aslinya aku yang deg-degan setengah mati sampai tangan keringetan! 😂❤️',
            'rotation' => '-rotate-2'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=600&q=80',
            'front_caption' => 'Momen Makan Es Krim 🍦',
            'back_story' => 'Es krimnya belepotan ke hidung tapi kamu masih berusaha sok aesthetic. Tingkat kelucuan kamu di hari itu resmi tembus 10.000%! 🍨🥰',
            'rotation' => 'rotate-3'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?auto=format&fit=crop&w=600&q=80',
            'front_caption' => 'Jalan Sore Berdua 🌇',
            'back_story' => 'Waktu kita jalan sore sampai lupa waktu cuma buat ngobrolin hal-hal receh unfaedah. Bersama kamu, obrolan paling random pun jadi bermakna. ✨',
            'rotation' => '-rotate-1'
        ],
        (object)[
            'file_url' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=600&q=80',
            'front_caption' => 'Senyuman Favoritku ✨',
            'back_story' => 'Senyuman ini yang selalu berhasil bikin bad day aku jadi seratus kali lebih baik. Tolong jangan pernah berhenti tersenyum ya, manisku! 💖',
            'rotation' => 'rotate-2'
        ],
    ]);

    // 5. Love Message
    $loveMessage = $story->message ?: "Sayangku {$recipientName},\n\nTerima kasih banyak sudah hadir di hidupku dan bikin hari-hariku yang biasa aja jadi luar biasa berwarna. Buket bunga ini mungkin kelak akan mengering, tapi rasa sayang, kagum, dan syukurku karena punya kamu gak akan pernah berkurang sedikit pun.\n\nTerima kasih ya sudah selalu sabar ngadepin aku, selalu nemenin di kala senang maupun capek, dan selalu jadi tempat ternyaman untuk pulang di setiap akhir hariku.\n\nJangan lupa bahagia hari ini ya manisku. Aku sayang kamu, kemarin, hari ini, dan sampai kapan pun! ❤️";
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($story->title); ?> — <?php echo e($cfg['edition_title']); ?> | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;600;700&family=Dancing+Script:wght@600;700&family=Nunito:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Canvas Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        [x-cloak] { display: none !important; }
        .font-handwriting { font-family: 'Caveat', 'Dancing Script', cursive; }
        .font-script { font-family: 'Dancing Script', cursive; }
        .font-body { font-family: 'Nunito', 'Plus Jakarta Sans', sans-serif; }

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

        /* Luxury Sleek Scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: <?php echo e($cfg['border_color']); ?>;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: <?php echo e($cfg['accent_primary']); ?>;
        }
        * {
            scrollbar-width: thin;
            scrollbar-color: <?php echo e($cfg['border_color']); ?> transparent;
        }

        /* 3D Flip Card Styles */
        .flip-card {
            background-color: transparent;
            perspective: 1000px;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }
        .flip-card-inner.is-flipped {
            transform: rotateY(180deg);
        }
        .flip-card-front, .flip-card-back {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 1.25rem;
            overflow: hidden;
        }
        .flip-card-back {
            transform: rotateY(180deg);
        }

        /* Floating Hugs & Hearts Animation */
        @keyframes floatUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(0.8) rotate(0deg);
            }
            50% {
                transform: translateY(-130px) scale(1.25) rotate(-12deg);
            }
            100% {
                opacity: 0;
                transform: translateY(-280px) scale(1) rotate(15deg);
            }
        }
        .animate-float-up {
            animation: floatUp 2.4s ease-out forwards;
        }

        /* Lined Notebook Stationery Paper */
        .notebook-lines {
            background-image: repeating-linear-gradient(transparent, transparent 27px, <?php echo e($cfg['notebook_line_color']); ?> 28px);
            line-height: 28px;
        }

        /* Washi Tape Styles */
        .washi-tape {
            background: <?php echo e($cfg['washi_bg']); ?>;
            border-left: 2px dashed <?php echo e($cfg['washi_border']); ?>;
            border-right: 2px dashed <?php echo e($cfg['washi_border']); ?>;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Floating background hearts */
        @keyframes bgFloat {
            0% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
            50% { transform: translateY(-40px) rotate(15deg); opacity: 0.35; }
            100% { transform: translateY(-80px) rotate(-10deg); opacity: 0.15; }
        }
        .animate-bg-heart-1 { animation: bgFloat 6s ease-in-out infinite; }
        .animate-bg-heart-2 { animation: bgFloat 8s ease-in-out infinite 2s; }
        .animate-bg-heart-3 { animation: bgFloat 7s ease-in-out infinite 4s; }
    </style>

    <script>
        // Enforce top position immediately before DOM paint
        if (window.location.hash) {
            window.history.replaceState(null, null, window.location.pathname + window.location.search);
        }
        window.scrollTo(0, 0);
    </script>
</head>

<body
    x-data="{
        envelopeOpened: false,
        isPlaying: false,
        audioStartSec: <?php echo e($audioStartSec); ?>,
        audioEndSec: <?php echo e($audioEndSec !== null ? $audioEndSec : 'null'); ?>,
        toastVisible: false,
        toastMessage: '',

        // 3D Flip Polaroid Card State
        flippedCards: { 0: false, 1: false, 2: false, 3: false },
        toggleFlip(idx) {
            this.flippedCards[idx] = !this.flippedCards[idx];
            if (this.flippedCards[idx]) {
                this.fireHeartConfetti();
            }
        },

        // Mini-Game Runaway 'Enggak' Button
        noButtonOffset: { x: 0, y: 0 },
        noEscapeAttempts: 0,
        noButtonTeaseMsg: '',
        yesButtonScale: 1,
        gameSuccessModal: false,
        teaseMessages: [
            'Eits gak kena! 😝',
            'Yakin nih? Coba klik lagi kalau bisa! 🏃‍♂️',
            'Tombol rusak khusus buat jawaban ini! 🛑',
            'Dilarang menolak keimutan ini! 🤭',
            'Pilihan ini tidak ada di semesta kita! 🌌',
            'Tombolnya licin kan? Pencet yang merah aja! 😉'
        ],

        moveNoButton() {
            this.noEscapeAttempts++;
            this.yesButtonScale = Math.min(1.45, 1 + (this.noEscapeAttempts * 0.08));

            // Strictly bounded within safe mobile screen space
            const maxX = 75;
            const maxY = 45;
            const randomX = (Math.random() * (maxX * 2)) - maxX;
            const randomY = (Math.random() * (maxY * 2)) - maxY;
            this.noButtonOffset = { x: Math.round(randomX), y: Math.round(randomY) };

            const msgIdx = (this.noEscapeAttempts - 1) % this.teaseMessages.length;
            this.noButtonTeaseMsg = this.teaseMessages[msgIdx];
        },

        sayYes() {
            this.gameSuccessModal = true;
            this.fireHeartConfetti();
        },

        // Love Vouchers Claim State
        claimedVouchers: { 0: false, 1: false, 2: false },
        claimVoucher(idx) {
            this.claimedVouchers[idx] = true;
            this.fireHeartConfetti();
            this.triggerToast('🎟️ Kupon berhasil diklaim! Screenshot dan kirim ke WA ya! 💕');
        },

        // Virtual Hugs Counter & Floating Particles
        hugCount: 0,
        floatingHugs: [],
        sendVirtualHug() {
            this.hugCount++;
            const id = Date.now() + Math.random();
            const emojiList = ['🤗', '💖', '🥰', '✨', '🌸', '💌', '🧸'];
            const emoji = emojiList[Math.floor(Math.random() * emojiList.length)];
            const left = 15 + Math.random() * 70; // 15% to 85%
            this.floatingHugs.push({ id, emoji, left });

            setTimeout(() => {
                this.floatingHugs = this.floatingHugs.filter(h => h.id !== id);
            }, 2400);

            if (this.hugCount % 5 === 0) {
                this.fireHeartConfetti();
            }
        },

        init() {
            // 1. Strict pre-open scroll locking on html & body
            document.documentElement.classList.add('scroll-locked');
            document.body.classList.add('scroll-locked');
            window.scrollTo(0, 0);

            // 2. Intercept wheel, touch dragging, and keyboard scroll events
            this._wheelBlocker = (e) => {
                if (!this.envelopeOpened) {
                    e.preventDefault();
                }
            };
            this._touchBlocker = (e) => {
                if (!this.envelopeOpened) {
                    e.preventDefault();
                }
            };
            this._keyBlocker = (e) => {
                if (!this.envelopeOpened && ['Space', 'ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End'].includes(e.code)) {
                    e.preventDefault();
                }
            };
            this._scrollReset = () => {
                if (!this.envelopeOpened && (window.scrollY > 0 || window.pageYOffset > 0)) {
                    window.scrollTo(0, 0);
                }
            };

            window.addEventListener('wheel', this._wheelBlocker, { passive: false });
            window.addEventListener('touchmove', this._touchBlocker, { passive: false });
            window.addEventListener('keydown', this._keyBlocker);
            window.addEventListener('scroll', this._scrollReset);

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

        openEnvelope() {
            this.envelopeOpened = true;

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
            this.fireHeartConfetti();

            // Smooth scroll to letter content
            this.$nextTick(() => {
                const content = document.getElementById('surat-konten');
                if (content) {
                    content.scrollIntoView({ behavior: 'smooth' });
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

        fireHeartConfetti() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 45,
                    spread: 80,
                    origin: { y: 0.6 },
                    colors: <?php echo \Illuminate\Support\Js::from($cfg['confetti_colors'])->toHtml() ?>
                });
            }
        },

        triggerToast(msg) {
            this.toastMessage = msg;
            this.toastVisible = true;
            setTimeout(() => { this.toastVisible = false; }, 3200);
        }
    }"
    class="font-body antialiased min-h-screen relative overflow-x-hidden scroll-locked"
    style="background-color: <?php echo e(request()->has('embed') ? $cfg['bg_container'] : $cfg['bg_outer']); ?>; color: <?php echo e($cfg['text_main_hex']); ?>;"
    :class="{ 'h-screen max-h-screen overflow-hidden': !envelopeOpened }"
>
    <!-- AUDIO ELEMENT -->
    <audio x-ref="bgAudio" src="<?php echo e($audioTrack); ?>" loop preload="auto"></audio>

    <!-- FLOATING TOAST NOTIFICATION -->
    <div
        x-show="toastVisible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed top-6 inset-x-0 mx-auto z-50 max-w-xs px-4 py-3 rounded-2xl bg-[#1C171A]/95 text-white text-xs font-mono font-semibold shadow-2xl backdrop-blur-md border text-center flex items-center justify-center gap-2"
        style="border-color: <?php echo e($cfg['border_color']); ?>;"
        x-cloak
    >
        <span x-text="toastMessage"></span>
    </div>

    <!-- MINI-GAME SUCCESS MODAL -->
    <div
        x-show="gameSuccessModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm select-none"
    >
        <div
            @click.away="gameSuccessModal = false"
            x-show="gameSuccessModal"
            x-transition:enter="transition duration-300 ease-out transform"
            x-transition:enter-start="scale-90 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            class="bg-white rounded-3xl p-6 max-w-xs w-full text-center space-y-4 shadow-2xl border-2 relative"
            style="border-color: <?php echo e($cfg['border_color']); ?>;"
        >
            <div class="w-16 h-16 mx-auto rounded-full text-3xl flex items-center justify-center shadow-inner animate-bounce" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                💖
            </div>
            <div class="space-y-1">
                <h4 class="font-handwriting text-3xl font-bold" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                    Yeay! Tahu Kok! 🥰
                </h4>
                <p class="text-xs text-neutral-600 leading-relaxed">
                    Aku juga sayang banget sama kamu 1000x lebih banyak! Jawaban ini resmi dicatat di buku takdir alam semesta ✨
                </p>
            </div>
            <button
                type="button"
                @click="gameSuccessModal = false"
                class="w-full py-2.5 rounded-xl bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white text-xs font-bold shadow-md hover:scale-105 active:scale-95 transition cursor-pointer"
            >
                Peluk Dulu Sini 🤗
            </button>
        </div>
    </div>

    <!-- FLOATING HUG PARTICLES CONTAINER -->
    <div class="fixed inset-0 pointer-events-none z-50 overflow-hidden">
        <template x-for="hug in floatingHugs" :key="hug.id">
            <div
                class="absolute bottom-16 text-3xl select-none animate-float-up pointer-events-none"
                :style="`left: ${hug.left}%;`"
                x-text="hug.emoji"
            ></div>
        </template>
    </div>

    <?php if(isset($isDemo) && $isDemo): ?>
        <?php echo $__env->make('digital-story.components.demo-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- DESKTOP CONTAINER: Centered 480px Smartphone Layout     -->
    <!-- ======================================================== -->
    <div
        class="max-w-[480px] mx-auto min-h-screen <?php echo e(request()->has('embed') ? '' : 'shadow-2xl border-x'); ?> relative overflow-hidden pb-24"
        style="background-color: <?php echo e($cfg['bg_container']); ?>; border-color: <?php echo e($cfg['border_color']); ?>;"
        :class="{ 'h-screen max-h-screen overflow-hidden': !envelopeOpened }"
    >

        <!-- Ambient Floating Hearts In Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden select-none">
            <span class="absolute top-16 left-6 text-2xl animate-bg-heart-1" style="color: <?php echo e($cfg['border_color']); ?>;">💕</span>
            <span class="absolute top-64 right-6 text-3xl animate-bg-heart-2" style="color: <?php echo e($cfg['border_color']); ?>;">✨</span>
            <span class="absolute top-[480px] left-10 text-2xl animate-bg-heart-3" style="color: <?php echo e($cfg['border_color']); ?>;">🌸</span>
            <span class="absolute top-[820px] right-8 text-2xl animate-bg-heart-1" style="color: <?php echo e($cfg['border_color']); ?>;">💖</span>
        </div>

        <!-- ======================================================== -->
        <!-- 1. FLOATING MUSIC TOGGLE BUTTON                          -->
        <!-- ======================================================== -->
        <div class="fixed top-5 right-5 z-40">
            <button
                type="button"
                @click="toggleAudio()"
                class="w-11 h-11 rounded-full bg-white/90 border shadow-lg backdrop-blur-md flex items-center justify-center hover:scale-105 active:scale-95 transition cursor-pointer"
                style="border-color: <?php echo e($cfg['border_color']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;"
                :title="isPlaying ? 'Jeda Musik Romantis' : 'Putar Musik Romantis'"
            >
                <div class="relative w-8 h-8 rounded-full flex items-center justify-center" :class="{ 'animate-spin': isPlaying }">
                    <i class="fa-solid" :class="isPlaying ? 'fa-music text-sm' : 'fa-play text-xs pl-0.5'"></i>
                </div>
            </button>
        </div>

        <!-- ======================================================== -->
        <!-- 2. COVER AMPLOP TERTUTUP (INTERACTIVE ENVELOPE OVERLAY)  -->
        <!-- ======================================================== -->
        <section
            id="cover-amplop"
            class="fixed inset-0 z-50 max-w-[480px] mx-auto min-h-screen min-h-[100dvh] flex flex-col justify-between items-center p-5 sm:p-7 text-center select-none overflow-hidden transition-all duration-700 ease-in-out touch-none overscroll-none"
            style="background-color: <?php echo e($cfg['bg_container']); ?>;"
            :class="{ '-translate-y-full opacity-0 pointer-events-none': envelopeOpened }"
        >
            <!-- Top Cute Header -->
            <div class="pt-4 sm:pt-6 space-y-1">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-mono text-[10px] font-bold tracking-widest uppercase border"
                    style="background-color: <?php echo e($cfg['accent_soft']); ?>; border-color: <?php echo e($cfg['border_color']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;"
                >
                    <?php echo e($cfg['edition_badge']); ?>

                </span>
                <p class="font-handwriting text-xl pt-1 opacity-80" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    Ada kiriman rahasia buat kamu...
                </p>
            </div>

            <!-- Envelope Graphic Container -->
            <div class="relative w-full max-w-[320px] mx-auto my-auto py-4">
                <!-- Glowing Aura -->
                <div class="absolute -inset-2 bg-gradient-to-r <?php echo e($cfg['aura_gradient']); ?> rounded-3xl blur-xl pointer-events-none"></div>

                <!-- Envelope Body -->
                <div class="relative <?php echo e($cfg['card_bg']); ?> rounded-3xl p-6 shadow-xl border-2 space-y-4 overflow-hidden" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                    <!-- Envelope Flap Decorative Lines -->
                    <div class="absolute top-0 inset-x-0 h-10 border-b flex items-center justify-center opacity-70" style="background-color: <?php echo e($cfg['accent_soft']); ?>; border-color: <?php echo e($cfg['border_color']); ?>;">
                        <span class="w-8 h-0.5 rounded-full" style="background-color: <?php echo e($cfg['border_color']); ?>;"></span>
                    </div>

                    <!-- Wax Seal Badge -->
                    <div class="pt-4">
                        <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br <?php echo e($cfg['accent_gradient']); ?> text-white flex items-center justify-center text-2xl shadow-lg border-2 border-white animate-pulse">
                            <?php echo e($cfg['wax_seal']); ?>

                        </div>
                    </div>

                    <!-- Envelope Labels -->
                    <div class="space-y-1.5 pt-2">
                        <span class="font-mono text-[9px] uppercase tracking-widest block font-semibold opacity-70" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                            Surat Ini Khusus Untuk:
                        </span>
                        <h2 class="font-handwriting text-3xl sm:text-4xl font-bold leading-tight" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                            <?php echo e($recipientName); ?>

                        </h2>
                        <span class="font-mono text-[10px] block opacity-70" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                            Dari: <span class="font-bold" style="color: <?php echo e($cfg['accent_primary']); ?>;"><?php echo e($senderName); ?></span>
                        </span>
                    </div>

                    <div class="w-12 h-0.5 mx-auto rounded-full" style="background-color: <?php echo e($cfg['border_color']); ?>;"></div>

                    <!-- Open Envelope Button -->
                    <button
                        type="button"
                        @click="openEnvelope()"
                        class="group w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white font-mono text-xs font-bold shadow-lg hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border border-white/20"
                    >
                        <i class="fa-solid fa-heart-open group-hover:scale-125 transition-transform"></i>
                        <span>Buka Surat 💌</span>
                    </button>
                </div>
            </div>

            <!-- Bottom Explanatory Hint -->
            <div class="pb-4 text-center">
                <p class="text-[10px] font-mono opacity-80" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    *Sentuh tombol di atas untuk membuka surat & alunan musik
                </p>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- 3. HEADER & KONTEN SURAT (REVEALED AFTER OPENED)         -->
        <!-- ======================================================== -->
        <main
            id="surat-konten"
            class="px-5 sm:px-6 py-10 space-y-10 relative transition-opacity duration-700"
            :class="{ 'opacity-0 pointer-events-none': !envelopeOpened, 'opacity-100 pointer-events-auto': envelopeOpened }"
        >

            <!-- Welcome Greeting Ribbon -->
            <div class="text-center space-y-2">
                <span class="inline-block px-3 py-1 rounded-full font-mono text-[10px] font-bold tracking-wider" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                    ✨ Halo Manusia Favoritku! ✨
                </span>
                <h3 class="font-handwriting text-3xl sm:text-4xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    <?php echo e($storyTitle); ?>

                </h3>
                <p class="text-xs font-mono opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    Ditulis dengan penuh rasa sayang & sedikit baper ❤️
                </p>

                <!-- Togetherness Counter Pill -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl <?php echo e($cfg['card_bg']); ?> border shadow-xs mt-2 text-xs" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                    <span class="text-base">⏳</span>
                    <span class="font-mono text-[11px]" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Sudah <strong><?php echo e($daysTogether); ?> Hari</strong> Bersama & Aku Masih Naksir Kamu!
                    </span>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 4. 3D FLIP POLAROID SCRAPBOOK GALLERY                    -->
            <!-- ======================================================== -->
            <section class="space-y-4">
                <div class="text-center space-y-1">
                    <span class="font-mono text-[10px] uppercase tracking-widest font-bold block" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                        Koleksi Kenangan Manis
                    </span>
                    <h4 class="font-handwriting text-2xl sm:text-3xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Foto Kita & Catatan Rahasia
                    </h4>
                    <span class="inline-block px-3 py-1 rounded-full <?php echo e($cfg['card_bg']); ?> border text-[10px] font-mono shadow-xs" style="border-color: <?php echo e($cfg['border_color']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                        👀 Klik fotonya buat lihat rahasia di baliknya!
                    </span>
                </div>

                <!-- 2x2 Polaroid Grid with Washi Tape and 3D Flip -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <?php $__currentLoopData = $mediaItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $rotClass = $item->rotation ?? ($idx % 2 === 0 ? '-rotate-1' : 'rotate-2');
                            $frontImg = $item->file_url ?? (isset($item->file_path) ? Storage::disk('public')->url($item->file_path) : 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=600&q=80');
                            $caption = $item->front_caption ?? ($item->caption ?? 'Momen Berharga Berdua 💕');
                            $backStory = $item->back_story ?? 'Momen ini gak akan pernah terlupakan. Terima kasih sudah selalu ada di sampingku! ❤️';
                        ?>
                        <div
                            class="flip-card h-72 sm:h-80 w-full cursor-pointer select-none transition-transform hover:scale-[1.02]"
                            @click="toggleFlip(<?php echo e($idx); ?>)"
                        >
                            <div class="flip-card-inner" :class="{ 'is-flipped': flippedCards[<?php echo e($idx); ?>] }">
                                
                                <!-- FRONT SIDE (POLAROID PHOTO) -->
                                <div class="flip-card-front <?php echo e($cfg['card_bg']); ?> p-3.5 pb-5 shadow-md border flex flex-col justify-between relative <?php echo e($rotClass); ?>" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                                    <!-- Washi Tape Effect at Top -->
                                    <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 washi-tape rounded-xs z-10"></div>

                                    <!-- Photo Image -->
                                    <div class="w-full h-52 sm:h-60 rounded-lg overflow-hidden bg-black/5 relative">
                                        <img src="<?php echo e($frontImg); ?>" alt="<?php echo e($caption); ?>" class="w-full h-full object-cover" />
                                        <div class="absolute top-2 right-2 px-2 py-0.5 rounded-full bg-black/60 text-white text-[9px] font-mono backdrop-blur-xs flex items-center gap-1">
                                            <i class="fa-solid fa-rotate text-[8px]"></i>
                                            <span>Flip</span>
                                        </div>
                                    </div>

                                    <!-- Caption -->
                                    <div class="pt-2 text-center">
                                        <p class="font-handwriting text-lg font-bold truncate" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                            <?php echo e($caption); ?>

                                        </p>
                                        <span class="text-[9px] font-mono opacity-70 block" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                            Sentuh untuk membalik ↻
                                        </span>
                                    </div>
                                </div>

                                <!-- BACK SIDE (NOTEBOOK NOTE) -->
                                <div class="flip-card-back <?php echo e($cfg['card_bg']); ?> p-5 shadow-md border-2 border-dashed flex flex-col justify-between text-left relative notebook-lines <?php echo e($rotClass); ?>" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                                    <!-- Washi Tape -->
                                    <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 washi-tape rounded-xs z-10"></div>

                                    <div class="space-y-2 pt-2">
                                        <div class="flex items-center justify-between border-b pb-1" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                                            <span class="font-mono text-[9px] font-bold uppercase" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                                                📝 Catatan Rahasia #<?php echo e($idx + 1); ?>

                                            </span>
                                            <span class="text-xs">🔒❤️</span>
                                        </div>
                                        <p class="font-handwriting text-lg leading-relaxed" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                            "<?php echo e($backStory); ?>"
                                        </p>
                                    </div>

                                    <div class="pt-2 border-t flex items-center justify-between text-[9px] font-mono opacity-70" style="border-color: <?php echo e($cfg['border_color']); ?>; color: <?php echo e($cfg['text_main_hex']); ?>;">
                                        <span>Sentuh lagi buat balik</span>
                                        <span class="font-bold" style="color: <?php echo e($cfg['accent_primary']); ?>;">Maja Love Note</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 5. KARTU PESAN CINTA UTAMA                               -->
            <!-- ======================================================== -->
            <section class="space-y-4">
                <div class="text-center space-y-1">
                    <span class="font-mono text-[10px] uppercase tracking-widest font-bold block" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                        Isi Hati Terdalam
                    </span>
                    <h4 class="font-handwriting text-2xl sm:text-3xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Sepucuk Surat Buat Kamu
                    </h4>
                </div>

                <!-- Lined Paper Love Note -->
                <article class="rounded-3xl p-6 sm:p-8 shadow-sm border relative space-y-4 overflow-hidden <?php echo e($cfg['card_bg']); ?>" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                    <!-- Corner Sticker -->
                    <div class="absolute -top-3 -right-3 w-12 h-12 rounded-full border flex items-center justify-center text-lg rotate-12" style="background-color: <?php echo e($cfg['accent_soft']); ?>; border-color: <?php echo e($cfg['border_color']); ?>;">
                        <?php echo e($cfg['wax_seal']); ?>

                    </div>

                    <div class="space-y-3 font-handwriting text-xl sm:text-2xl leading-relaxed whitespace-pre-line" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        <?php echo e($loveMessage); ?>

                    </div>

                    <div class="pt-4 border-t flex items-center justify-between text-xs font-mono" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                        <span class="opacity-70" style="color: <?php echo e($cfg['text_main_hex']); ?>;">Tulus dari lubuk hati,</span>
                        <strong class="font-handwriting text-xl" style="color: <?php echo e($cfg['accent_primary']); ?>;"><?php echo e($senderName); ?></strong>
                    </div>
                </article>
            </section>

            <!-- ======================================================== -->
            <!-- 6. MINI-GAME INTERAKTIF (TOMBOL KABUR)                  -->
            <!-- ======================================================== -->
            <section class="rounded-3xl p-6 shadow-sm border-2 text-center space-y-5 relative overflow-hidden <?php echo e($cfg['card_bg']); ?>" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                <div class="space-y-1">
                    <span class="inline-block px-3 py-1 rounded-full font-mono text-[10px] font-bold" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                        🎮 Mini-Game Kejujuran 100% Valid
                    </span>
                    <h4 class="font-handwriting text-3xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Jujur ya... Kamu sayang sama aku gak? 🧐
                    </h4>
                    <p class="text-xs opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Pilihlah dengan hati yang tulus dan tanpa paksaan (katanya) 😜
                    </p>
                </div>

                <!-- Tease Message Bubble if Escaped -->
                <div class="min-h-[24px]">
                    <span
                        x-show="noButtonTeaseMsg"
                        x-text="noButtonTeaseMsg"
                        class="inline-block px-3 py-1 rounded-full bg-amber-50 border border-amber-300 text-amber-900 font-mono text-xs font-bold animate-bounce"
                        x-cloak
                    ></span>
                </div>

                <!-- Buttons Arena with Safe Bounding -->
                <div class="relative py-6 min-h-[90px] flex items-center justify-center gap-4">
                    <!-- YES BUTTON (Grows Bigger) -->
                    <button
                        type="button"
                        @click="sayYes()"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white font-mono text-xs sm:text-sm font-bold shadow-lg hover:opacity-95 active:scale-95 transition-all duration-200 cursor-pointer flex items-center gap-2 shrink-0 z-10"
                        :style="`transform: scale(${yesButtonScale});`"
                    >
                        <span>Sayang Banget ❤️</span>
                    </button>

                    <!-- NO BUTTON (Runs Away on Hover & Tap) -->
                    <button
                        type="button"
                        @mouseenter="moveNoButton()"
                        @touchstart.prevent="moveNoButton()"
                        @click="moveNoButton()"
                        class="px-4 py-2.5 rounded-2xl bg-neutral-200/60 hover:bg-neutral-200 text-neutral-700 font-mono text-xs font-semibold border border-neutral-300 shadow-xs transition-transform duration-150 cursor-pointer select-none shrink-0"
                        :style="`transform: translate(${noButtonOffset.x}px, ${noButtonOffset.y}px);`"
                    >
                        <span>Enggak 😜</span>
                    </button>
                </div>

                <p class="font-mono text-[9px] opacity-70" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    *Peringatan: Tombol abu-abu memiliki refleks tingkat dewa.
                </p>
            </section>

            <!-- ======================================================== -->
            <!-- 7. KUPON CINTA INTERAKTIF (INTERACTIVE LOVE VOUCHERS)    -->
            <!-- ======================================================== -->
            <section class="space-y-4">
                <div class="text-center space-y-1">
                    <span class="font-mono text-[10px] uppercase tracking-widest font-bold block" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                        Hadiah Spesial Buat Kamu
                    </span>
                    <h4 class="font-handwriting text-2xl sm:text-3xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        3 Kupon Cinta Resmi 🎟️
                    </h4>
                    <p class="text-xs opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Klaim kupon di bawah ini dan screenshot kirim ke WhatsApp aku ya!
                    </p>
                </div>

                <!-- 3 Ticket-Stub Style Vouchers -->
                <div class="space-y-3 pt-1">
                    <!-- Voucher 1 -->
                    <div class="<?php echo e($cfg['card_bg']); ?> rounded-2xl p-4 shadow-sm border relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md font-mono text-[9px] font-bold" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                                    VOUCHER 01
                                </span>
                                <h5 class="font-bold text-sm" style="color: <?php echo e($cfg['text_main_hex']); ?>;">Bebas Ngambek 24 Jam 🛡️</h5>
                            </div>
                            <p class="text-xs opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                Berlaku kapan saja saat kamu lagi bete. Wajib dimaafkan & dimanjain tanpa syarat!
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="claimVoucher(0)"
                            :disabled="claimedVouchers[0]"
                            class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                            :class="claimedVouchers[0] ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white shadow-sm active:scale-95'"
                        >
                            <i class="fa-solid" :class="claimedVouchers[0] ? 'fa-circle-check text-emerald-600' : 'fa-ticket'"></i>
                            <span x-text="claimedVouchers[0] ? 'Sudah Diklaim ✅' : 'Klaim Kupon 🎟️'"></span>
                        </button>
                    </div>

                    <!-- Voucher 2 -->
                    <div class="<?php echo e($cfg['card_bg']); ?> rounded-2xl p-4 shadow-sm border relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md font-mono text-[9px] font-bold" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                                    VOUCHER 02
                                </span>
                                <h5 class="font-bold text-sm" style="color: <?php echo e($cfg['text_main_hex']); ?>;">Makan Bebas Ditraktir 🍕</h5>
                            </div>
                            <p class="text-xs opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                Bebas pilih makanan apa aja yang kamu lagi ngidam (asal jangan jawab 'terserah')!
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="claimVoucher(1)"
                            :disabled="claimedVouchers[1]"
                            class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                            :class="claimedVouchers[1] ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white shadow-sm active:scale-95'"
                        >
                            <i class="fa-solid" :class="claimedVouchers[1] ? 'fa-circle-check text-emerald-600' : 'fa-ticket'"></i>
                            <span x-text="claimedVouchers[1] ? 'Sudah Diklaim ✅' : 'Klaim Kupon 🎟️'"></span>
                        </button>
                    </div>

                    <!-- Voucher 3 -->
                    <div class="<?php echo e($cfg['card_bg']); ?> rounded-2xl p-4 shadow-sm border relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md font-mono text-[9px] font-bold" style="background-color: <?php echo e($cfg['accent_soft']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                                    VOUCHER 03
                                </span>
                                <h5 class="font-bold text-sm" style="color: <?php echo e($cfg['text_main_hex']); ?>;">Peluk & Dengerin Curhat 🤗</h5>
                            </div>
                            <p class="text-xs opacity-75" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                                Paket lengkap pelukan hangat + telinga yang siap dengerin keluh kesahmu tanpa dipotong!
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="claimVoucher(2)"
                            :disabled="claimedVouchers[2]"
                            class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                            :class="claimedVouchers[2] ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white shadow-sm active:scale-95'"
                        >
                            <i class="fa-solid" :class="claimedVouchers[2] ? 'fa-circle-check text-emerald-600' : 'fa-ticket'"></i>
                            <span x-text="claimedVouchers[2] ? 'Sudah Diklaim ✅' : 'Klaim Kupon 🎟️'"></span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 8. PENUTUP & TOMBOL PELUK VIRTUAL                        -->
            <!-- ======================================================== -->
            <section class="rounded-3xl p-6 sm:p-8 shadow-sm border text-center space-y-5 <?php echo e($cfg['card_bg']); ?>" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                <div class="space-y-2">
                    <span class="text-3xl">🤗</span>
                    <h4 class="font-handwriting text-3xl font-bold" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Kirim Peluk Virtual Ke Aku!
                    </h4>
                    <p class="text-xs opacity-75 max-w-xs mx-auto leading-relaxed" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                        Kalau kamu lagi kangen atau butuh pelukan sekarang, sentuh tombol di bawah ini sebanyak-banyaknya ya!
                    </p>
                </div>

                <!-- Big Hug Button -->
                <div>
                    <button
                        type="button"
                        @click="sendVirtualHug()"
                        class="w-full max-w-xs mx-auto py-3.5 px-6 rounded-2xl bg-gradient-to-r <?php echo e($cfg['accent_gradient']); ?> text-white font-mono text-sm font-bold shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer border border-white/30"
                    >
                        <span>Kirim Peluk Virtual 🤗</span>
                    </button>
                </div>

                <!-- Live Hug Counter -->
                <div class="pt-2">
                    <span class="inline-block px-4 py-1.5 rounded-full border font-mono text-xs font-bold" style="background-color: <?php echo e($cfg['accent_soft']); ?>; border-color: <?php echo e($cfg['border_color']); ?>; color: <?php echo e($cfg['accent_primary']); ?>;">
                        <span x-text="hugCount">0</span> Pelukan Telah Berhasil Terkirim! 💖
                    </span>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 9. ATELIER FOOTER                                        -->
            <!-- ======================================================== -->
            <footer class="pt-8 pb-4 text-center space-y-2 border-t opacity-85" style="border-color: <?php echo e($cfg['border_color']); ?>;">
                <p class="font-handwriting text-2xl font-bold" style="color: <?php echo e($cfg['accent_primary']); ?>;">
                    <?php echo e($senderName); ?> & <?php echo e($recipientName); ?>

                </p>
                <p class="font-mono text-[9px] tracking-widest uppercase" style="color: <?php echo e($cfg['text_main_hex']); ?>;">
                    Forever & Always With Love
                </p>
                <div class="pt-2">
                    <a
                        href="<?php echo e(url('/')); ?>"
                        class="inline-block text-[10px] font-mono hover:underline"
                        style="color: <?php echo e($cfg['accent_primary']); ?>;"
                    >
                        Digital Love Letter by Maja Flower Atelier
                    </a>
                </div>
            </footer>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/digital-story/templates/love-letter/online-love-letter.blade.php ENDPATH**/ ?>