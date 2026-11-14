<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-locked">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($story->title); ?> — Undangan Elegan Royal Emerald & Gold | Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        [x-cloak] { display: none !important; }
        .font-royal { font-family: 'Cinzel', Georgia, serif; }
        .font-serif-luxury { font-family: 'Playfair Display', Georgia, serif; }

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

        /* Gold vinyl rotation keyframe */
        @keyframes vinyl-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-gold-vinyl {
            animation: vinyl-spin 8s linear infinite;
        }
        .paused {
            animation-play-state: paused !important;
        }

        /* Gold shimmer shimmer */
        @keyframes gold-shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-gold {
            background: linear-gradient(90deg, rgba(212,175,55,0) 0%, rgba(245,215,127,0.4) 50%, rgba(212,175,55,0) 100%);
            background-size: 200% 100%;
            animation: gold-shimmer 3.5s infinite;
        }

        /* Sleek Gold Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.4); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(212, 175, 55, 0.75); }
        * { scrollbar-width: thin; scrollbar-color: rgba(212, 175, 55, 0.4) transparent; }
    </style>

    <script>
        if (window.location.hash) {
            window.history.replaceState(null, null, window.location.pathname + window.location.search);
        }
        window.scrollTo(0, 0);
    </script>
</head>

<?php
    $guestName = request()->query('to', request()->query('guest', request()->query('u', request()->query('nama'))));
    $displayGuest = $guestName ? trim($guestName) : 'Distinguished Guests';

    $meta = is_array($story->metadata) ? $story->metadata : [];

    $groomNickname = $meta['groom_nickname'] ?? 'Leonardo';
    $brideNickname = $meta['bride_nickname'] ?? 'Kimberly';

    $groomFullName = $meta['groom_full_name'] ?? ($story->sender_name ?: 'Leonardo Adisurya, B.B.A.');
    $groomParents = $meta['groom_parents'] ?? 'Putra pertama dari Bpk. William Adisurya & Ibu Jessica Widjaja';
    $groomInstagram = $meta['groom_instagram'] ?? '@leonardo.adisurya';
    $groomBio = $meta['groom_bio'] ?? 'Visionary leader, world traveler, and fiercely devoted to Kimberly.';
    $groomPhoto = $meta['groom_photo'] ?? 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80';

    $brideFullName = $meta['bride_full_name'] ?? ($story->recipient_name ?: 'Kimberly Anastasia, B.Des.');
    $brideParents = $meta['bride_parents'] ?? 'Putri tunggal dari Bpk. Alexander Tan & Ibu Michelle Kusuma';
    $brideInstagram = $meta['bride_instagram'] ?? '@kimberly.anastasia';
    $brideBio = $meta['bride_bio'] ?? 'Art director, graceful soul, and the golden light of Leonardo’s universe.';
    $bridePhoto = $meta['bride_photo'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80';

    $eventDate = $story->event_date ?? \Carbon\Carbon::now()->addDays(28)->setHour(9)->setMinute(0);
    $eventDateIso = $eventDate->toIso8601String();
    $eventFormattedDate = $eventDate->translatedFormat('l, d F Y');

    $ceremonyTime = $meta['ceremony_time'] ?? '09.00 - 11.00 WIB';
    $ceremonyVenue = $meta['venue_name'] ?? 'The Emerald Grand Ballroom & Glasshouse Maja';
    $ceremonyAddress = $meta['venue_address'] ?? 'Jl. Jenderal Sudirman Kav. 52-53, SCBD, Jakarta Selatan';

    $receptionTime = $meta['reception_time'] ?? '18.30 - 22.00 WIB';
    $receptionVenue = $meta['venue_name'] ?? 'The Emerald Grand Ballroom & Glasshouse Maja';
    $receptionAddress = $meta['venue_address'] ?? 'Jl. Jenderal Sudirman Kav. 52-53, SCBD, Jakarta Selatan';

    $mapsUrl = $meta['maps_url'] ?? 'https://maps.google.com/?q=Jakarta';

    $audioTrack = $story->audio_url ?: ($story->audio_path ?: 'https://assets.mixkit.co/music/preview/mixkit-wedding-acoustic-guitar-384.mp3');
    $audioTitle = $story->audio_title ?: 'Grand Nocturne in Gold (Royal Piano)';

    $bcaNumber = $meta['bank_bca_number'] ?? '8020 8899 00';
    $bcaHolder = $meta['bank_bca_holder'] ?? 'Leonardo Adisurya';
    $mandiriNumber = $meta['bank_mandiri_number'] ?? '137 00 9988 776';
    $mandiriHolder = $meta['bank_mandiri_holder'] ?? 'Kimberly Anastasia';
?>

<body
    x-data="weddingLuxuryApp({
        eventDate: '<?php echo e($eventDateIso); ?>',
        audioUrl: '<?php echo e($audioTrack); ?>',
        audioTitle: '<?php echo e(addslashes($audioTitle)); ?>',
        slug: '<?php echo e($story->slug); ?>',
        isDemo: <?php echo e(isset($isDemo) && $isDemo ? 'true' : 'false'); ?>

    })"
    class="<?php echo e(request()->has('embed') ? 'bg-[#091510]' : 'bg-[#040A07]'); ?> text-[#FBF8EE] font-sans antialiased min-h-screen selection:bg-[#D4AF37] selection:text-black relative overflow-x-hidden scroll-locked"
>
    
    <?php if(isset($isDemo) && $isDemo): ?>
        <?php echo $__env->make('digital-story.components.demo-banner', ['template' => $template, 'isDemo' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <audio
        x-ref="audioPlayer"
        src="<?php echo e($audioTrack); ?>"
        preload="auto"
        loop
    ></audio>

    
    <div
        x-show="toastOpen"
        x-cloak
        x-transition
        class="fixed top-5 inset-x-0 mx-auto z-50 w-max max-w-sm px-4 py-2.5 rounded-xl bg-[#091510]/95 border border-[#D4AF37] text-[#D4AF37] shadow-2xl flex items-center gap-2.5 font-royal text-xs font-bold uppercase tracking-wider backdrop-blur-md"
    >
        <span class="text-base text-[#D4AF37]">✨</span>
        <span x-text="toastMessage"></span>
    </div>

    
    
    
    <section
        x-ref="coverSection"
        x-show="isCoverVisible"
        x-transition:leave="transition-all duration-1000 ease-in-out"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gradient-to-b from-[#040A07] via-[#091510] to-[#040A07]"
    >
        <div class="w-full max-w-[440px] bg-[#091510]/90 backdrop-blur-xl rounded-[32px] border border-[#D4AF37]/50 p-7 text-center shadow-2xl relative overflow-hidden">
            
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-[#D4AF37]/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-[#D4AF37]/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#D4AF37]/10 border border-[#D4AF37]/40 text-[#D4AF37] font-royal text-[10px] uppercase tracking-widest mb-4">
                <span>✨</span>
                <span>The Royal Celebration</span>
                <span>✨</span>
            </div>

            <h1 class="font-royal text-4xl sm:text-5xl text-[#F5D77F] leading-tight tracking-wider mb-1">
                <?php echo e($groomNickname); ?> & <?php echo e($brideNickname); ?>

            </h1>
            <p class="font-royal text-[10px] text-[#A3B899] uppercase tracking-widest font-semibold mb-6">
                A Union of Love & Eternity
            </p>

            
            <div class="relative w-44 h-56 mx-auto mb-6">
                <div class="w-full h-full rounded-t-full overflow-hidden border-2 border-[#D4AF37] shadow-xl p-1 bg-[#13221B]">
                    <img src="<?php echo e($groomPhoto); ?>" alt="Mempelai" class="w-full h-full object-cover rounded-t-full">
                </div>
                <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-[#091510] border border-[#D4AF37] text-[#D4AF37] font-royal text-[10px] tracking-widest font-bold shadow-lg">
                    EST. 2026
                </div>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/35 rounded-2xl p-4 mb-6 backdrop-blur-md">
                <p class="font-royal text-[10px] text-[#A3B899] uppercase tracking-widest mb-1">
                    Cordially Invited VIP Guest:
                </p>
                <p class="font-serif-luxury text-lg font-bold text-[#F5D77F] tracking-wide truncate">
                    <?php echo e($displayGuest); ?>

                </p>
            </div>

            
            <button
                type="button"
                @click="openInvitation()"
                class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-[#D4AF37] via-[#F5D77F] to-[#D4AF37] text-[#091510] font-royal text-xs font-bold uppercase tracking-widest shadow-xl shadow-[#D4AF37]/20 hover:scale-102 transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95"
            >
                <span class="text-sm">✨</span>
                <span>Open Royal Invitation</span>
                <span class="text-xs">✦</span>
            </button>

            <p class="font-royal text-[10px] text-[#A3B899] mt-3 tracking-wider">
                *Tap to open the grand celebration and play symphony
            </p>
        </div>
    </section>

    
    
    
    <main
        id="mainContainer"
        class="max-w-[480px] mx-auto min-h-screen bg-[#091510] <?php echo e(request()->has('embed') ? '' : 'shadow-2xl border-x border-[#D4AF37]/25'); ?> relative overflow-hidden pb-24"
    >
        
        <div
            x-show="isUnlocked"
            x-cloak
            class="fixed top-5 right-5 z-40"
        >
            <button
                type="button"
                @click="toggleAudio()"
                class="w-11 h-11 rounded-full bg-[#13221B]/90 border border-[#D4AF37]/60 shadow-xl backdrop-blur-md flex items-center justify-center text-[#D4AF37] hover:scale-105 active:scale-95 transition cursor-pointer"
                :title="isPlaying ? 'Pause Music' : 'Play Music'"
            >
                <div :class="isPlaying ? 'animate-gold-vinyl' : 'paused'">
                    <i class="fa-solid fa-compact-disc text-xl text-[#F5D77F]"></i>
                </div>
            </button>
        </div>

        
        <nav
            x-show="isUnlocked"
            x-cloak
            class="fixed bottom-3 inset-x-0 mx-auto z-40 max-w-[440px] px-3"
        >
            <div class="bg-[#091510]/95 border border-[#D4AF37]/40 backdrop-blur-xl rounded-2xl py-2 px-2 shadow-2xl flex items-center justify-around text-[#A3B899]">
                <a href="#cover" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">✨</span>
                    <span>Cover</span>
                </a>
                <a href="#mempelai" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">👑</span>
                    <span>Couple</span>
                </a>
                <a href="#acara" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">📅</span>
                    <span>Events</span>
                </a>
                <a href="#galeri" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">📸</span>
                    <span>Gallery</span>
                </a>
                <a href="#kado" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">🎁</span>
                    <span>Gift</span>
                </a>
                <a href="#rsvp" class="flex flex-col items-center hover:text-[#D4AF37] transition text-[10px] font-royal font-bold uppercase">
                    <span class="text-sm">✍️</span>
                    <span>RSVP</span>
                </a>
            </div>
        </nav>

        
        
        
        <section id="cover" class="relative pt-12 pb-10 px-6 text-center">
            <div class="inline-flex items-center gap-2 text-xs font-royal text-[#D4AF37] uppercase tracking-widest mb-3">
                <span>✦ The Royal Wedding ✦</span>
            </div>

            <h1 class="font-royal text-5xl text-[#F5D77F] mb-1">
                <?php echo e($groomNickname); ?> & <?php echo e($brideNickname); ?>

            </h1>
            <p class="font-royal text-xs font-semibold text-[#A3B899] tracking-widest uppercase mb-6">
                <?php echo e($eventFormattedDate); ?>

            </p>

            
            <div class="relative w-56 h-76 mx-auto mb-6">
                <div class="w-full h-full rounded-t-full overflow-hidden border-2 border-[#D4AF37] shadow-2xl p-1 bg-[#13221B]">
                    <img src="<?php echo e($bridePhoto); ?>" alt="Prewed" class="w-full h-full object-cover rounded-t-full">
                </div>
            </div>

            
            <div class="bg-[#13221B]/80 border border-[#D4AF37]/30 rounded-2xl p-5 shadow-xs max-w-sm mx-auto text-center backdrop-blur-md">
                <p class="font-serif-luxury text-xs italic text-[#D1DEC9] leading-relaxed">
                    "Two souls with but a single thought, two hearts that beat as one. With grace and devotion, we begin our eternal voyage."
                </p>
                <p class="font-royal text-[11px] font-bold text-[#D4AF37] mt-2 uppercase tracking-widest">
                    — The Holy Union —
                </p>
            </div>
        </section>

        
        
        
        <section id="mempelai" class="py-10 px-6 space-y-6">
            <div class="text-center">
                <span class="font-royal text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Honored Couple</span>
                <h2 class="font-royal text-2xl font-bold text-[#F5D77F] mt-0.5">The Bride & The Groom</h2>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-6 shadow-sm text-center relative backdrop-blur-md">
                <div class="w-28 h-36 mx-auto rounded-t-full overflow-hidden border-2 border-[#D4AF37] shadow-sm mb-3">
                    <img src="<?php echo e($groomPhoto); ?>" alt="<?php echo e($groomFullName); ?>" class="w-full h-full object-cover">
                </div>
                <h3 class="font-royal text-xl font-bold text-[#F5D77F]"><?php echo e($groomFullName); ?></h3>
                <p class="font-royal text-xs text-[#A3B899] mt-1"><?php echo e($groomParents); ?></p>
                <p class="font-serif-luxury text-xs text-[#D1DEC9] mt-2 italic px-3">"<?php echo e($groomBio); ?>"</p>
                <?php if($groomInstagram): ?>
                    <a
                        href="https://instagram.com/<?php echo e(ltrim($groomInstagram, '@')); ?>"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#091510] border border-[#D4AF37]/40 text-[#D4AF37] font-royal text-xs mt-3 hover:bg-[#D4AF37]/15 transition"
                    >
                        <i class="fa-brands fa-instagram text-xs"></i>
                        <span><?php echo e($groomInstagram); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            
            <div class="flex items-center justify-center gap-3 text-[#D4AF37]">
                <div class="h-px w-20 bg-[#D4AF37]/40"></div>
                <span class="font-royal text-base font-bold">✦ & ✦</span>
                <div class="h-px w-20 bg-[#D4AF37]/40"></div>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-6 shadow-sm text-center relative backdrop-blur-md">
                <div class="w-28 h-36 mx-auto rounded-t-full overflow-hidden border-2 border-[#D4AF37] shadow-sm mb-3">
                    <img src="<?php echo e($bridePhoto); ?>" alt="<?php echo e($brideFullName); ?>" class="w-full h-full object-cover">
                </div>
                <h3 class="font-royal text-xl font-bold text-[#F5D77F]"><?php echo e($brideFullName); ?></h3>
                <p class="font-royal text-xs text-[#A3B899] mt-1"><?php echo e($brideParents); ?></p>
                <p class="font-serif-luxury text-xs text-[#D1DEC9] mt-2 italic px-3">"<?php echo e($brideBio); ?>"</p>
                <?php if($brideInstagram): ?>
                    <a
                        href="https://instagram.com/<?php echo e(ltrim($brideInstagram, '@')); ?>"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#091510] border border-[#D4AF37]/40 text-[#D4AF37] font-royal text-xs mt-3 hover:bg-[#D4AF37]/15 transition"
                    >
                        <i class="fa-brands fa-instagram text-xs"></i>
                        <span><?php echo e($brideInstagram); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </section>

        
        
        
        <section id="acara" class="py-10 px-6 space-y-6 bg-[#040A07]/70 border-y border-[#D4AF37]/25">
            <div class="text-center">
                <span class="font-royal text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Ceremony & Gala</span>
                <h2 class="font-royal text-2xl font-bold text-[#F5D77F] mt-0.5">Date & Location</h2>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-5 shadow-sm text-center backdrop-blur-md">
                <p class="font-royal text-xs font-bold text-[#A3B899] uppercase tracking-widest mb-3">
                    Countdown to the Grand Celebration ⏳
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <div class="bg-[#091510] border border-[#D4AF37]/35 rounded-2xl p-2.5">
                        <span class="font-royal text-2xl font-bold text-[#F5D77F] block" x-text="days">0</span>
                        <span class="font-royal text-[10px] text-[#A3B899]">Days</span>
                    </div>
                    <div class="bg-[#091510] border border-[#D4AF37]/35 rounded-2xl p-2.5">
                        <span class="font-royal text-2xl font-bold text-[#F5D77F] block" x-text="hours">0</span>
                        <span class="font-royal text-[10px] text-[#A3B899]">Hours</span>
                    </div>
                    <div class="bg-[#091510] border border-[#D4AF37]/35 rounded-2xl p-2.5">
                        <span class="font-royal text-2xl font-bold text-[#F5D77F] block" x-text="minutes">0</span>
                        <span class="font-royal text-[10px] text-[#A3B899]">Minutes</span>
                    </div>
                    <div class="bg-[#091510] border border-[#D4AF37]/35 rounded-2xl p-2.5">
                        <span class="font-royal text-2xl font-bold text-[#F5D77F] block" x-text="seconds">0</span>
                        <span class="font-royal text-[10px] text-[#A3B899]">Seconds</span>
                    </div>
                </div>

                
                <?php
                    $calTitle = rawurlencode($story->title);
                    $calDates = $eventDate->format('Ymd\THis\Z') . '/' . $eventDate->copy()->addHours(5)->format('Ymd\THis\Z');
                    $calLocation = rawurlencode($ceremonyVenue . ', ' . $ceremonyAddress);
                    $calDetails = rawurlencode("The Royal Wedding {$story->title}\nView details: " . url()->current());
                    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calDates}&details={$calDetails}&location={$calLocation}";
                ?>
                <a
                    href="<?php echo e($googleCalUrl); ?>"
                    target="_blank"
                    class="mt-3.5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#091510] border border-[#D4AF37]/50 text-[#F5D77F] font-royal text-xs font-bold hover:bg-[#D4AF37]/15 transition shadow-xs"
                >
                    <i class="fa-solid fa-calendar-plus text-[#D4AF37]"></i>
                    <span>Add to Google Calendar</span>
                </a>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-5 shadow-sm space-y-3 backdrop-blur-md">
                <div class="flex items-center gap-2">
                    <span class="text-[#D4AF37] text-lg font-royal">✦</span>
                    <h3 class="font-royal text-lg font-bold text-[#F5D77F]">The Holy Matrimony</h3>
                </div>
                <div class="text-xs text-[#D1DEC9] space-y-1 font-royal">
                    <p><i class="fa-regular fa-calendar text-[#D4AF37] w-4"></i> <?php echo e($eventFormattedDate); ?></p>
                    <p><i class="fa-regular fa-clock text-[#D4AF37] w-4"></i> <?php echo e($ceremonyTime); ?></p>
                    <p><i class="fa-solid fa-location-dot text-[#D4AF37] w-4"></i> <strong><?php echo e($ceremonyVenue); ?></strong></p>
                    <p class="text-[11px] text-[#A3B899] pl-4"><?php echo e($ceremonyAddress); ?></p>
                </div>
                <a
                    href="<?php echo e($mapsUrl); ?>"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-[#D4AF37] via-[#F5D77F] to-[#D4AF37] text-[#091510] font-royal text-xs font-bold uppercase tracking-wider hover:opacity-95 transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Google Maps Directions</span>
                </a>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-5 shadow-sm space-y-3 backdrop-blur-md">
                <div class="flex items-center gap-2">
                    <span class="text-[#D4AF37] text-lg font-royal">✦</span>
                    <h3 class="font-royal text-lg font-bold text-[#F5D77F]">The Royal Gala Dinner</h3>
                </div>
                <div class="text-xs text-[#D1DEC9] space-y-1 font-royal">
                    <p><i class="fa-regular fa-calendar text-[#D4AF37] w-4"></i> <?php echo e($eventFormattedDate); ?></p>
                    <p><i class="fa-regular fa-clock text-[#D4AF37] w-4"></i> <?php echo e($receptionTime); ?></p>
                    <p><i class="fa-solid fa-location-dot text-[#D4AF37] w-4"></i> <strong><?php echo e($receptionVenue); ?></strong></p>
                    <p class="text-[11px] text-[#A3B899] pl-4"><?php echo e($receptionAddress); ?></p>
                </div>
                <a
                    href="<?php echo e($mapsUrl); ?>"
                    target="_blank"
                    class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-[#D4AF37] via-[#F5D77F] to-[#D4AF37] text-[#091510] font-royal text-xs font-bold uppercase tracking-wider hover:opacity-95 transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Google Maps Directions</span>
                </a>
            </div>
        </section>

        
        
        
        <section id="galeri" class="py-10 px-6 space-y-5">
            <div class="text-center">
                <span class="font-royal text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Visual Archives</span>
                <h2 class="font-royal text-2xl font-bold text-[#F5D77F] mt-0.5">Pre-Wedding Gallery</h2>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <?php $__empty_1 = true; $__currentLoopData = $story->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        @click="openLightbox('<?php echo e($item->url); ?>', '<?php echo e(addslashes($item->caption ?? '')); ?>')"
                        class="bg-[#13221B]/90 p-2 rounded-2xl border border-[#D4AF37]/40 shadow-sm hover:scale-102 transition cursor-pointer"
                    >
                        <div class="aspect-square rounded-xl overflow-hidden mb-1.5 border border-[#D4AF37]/20">
                            <img src="<?php echo e($item->url); ?>" alt="<?php echo e($item->caption); ?>" class="w-full h-full object-cover">
                        </div>
                        <?php if($item->caption): ?>
                            <p class="font-royal text-[10px] text-[#D1DEC9] text-center truncate px-1">
                                <?php echo e($item->caption); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-2 text-center py-8 bg-[#13221B] rounded-2xl border border-[#D4AF37]/30">
                        <span class="text-3xl text-[#D4AF37]">📸</span>
                        <p class="font-royal text-xs text-[#A3B899] mt-2">Visual gallery will be unveiled soon.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        
        
        
        <section id="kado" class="py-10 px-6 space-y-5 bg-[#040A07]/70 border-t border-[#D4AF37]/25">
            <div class="text-center">
                <span class="font-royal text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Wedding Registry</span>
                <h2 class="font-royal text-2xl font-bold text-[#F5D77F] mt-0.5">Digital Gift & Blessings</h2>
                <p class="font-serif-luxury text-xs text-[#A3B899] max-w-xs mx-auto mt-1 leading-relaxed">
                    Your presence and blessings are our greatest treasure. For distinguished guests wishing to send a digital gift:
                </p>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/50 rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <span class="font-royal text-xs font-bold text-[#F5D77F] uppercase tracking-wider">Bank BCA Platinum</span>
                    <i class="fa-solid fa-credit-card text-[#D4AF37]"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#FBF8EE] tracking-wider"><?php echo e($bcaNumber); ?></p>
                <p class="font-royal text-xs text-[#A3B899]">a.n <?php echo e($bcaHolder); ?></p>
                <button
                    type="button"
                    @click="copyText('<?php echo e($bcaNumber); ?>', 'BCA account number copied!')"
                    class="w-full py-2 rounded-xl bg-[#091510] text-[#F5D77F] border border-[#D4AF37]/40 font-royal text-xs font-bold uppercase tracking-wider hover:bg-[#D4AF37]/15 transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="fa-regular fa-copy"></i>
                    <span>Copy Account Number</span>
                </button>
            </div>

            
            <div class="bg-[#13221B]/90 border border-[#D4AF37]/50 rounded-3xl p-5 shadow-sm space-y-2 relative overflow-hidden backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <span class="font-royal text-xs font-bold text-[#F5D77F] uppercase tracking-wider">Bank Mandiri Priority</span>
                    <i class="fa-solid fa-wallet text-[#D4AF37]"></i>
                </div>
                <p class="font-mono text-base font-bold text-[#FBF8EE] tracking-wider"><?php echo e($mandiriNumber); ?></p>
                <p class="font-royal text-xs text-[#A3B899]">a.n <?php echo e($mandiriHolder); ?></p>
                <button
                    type="button"
                    @click="copyText('<?php echo e($mandiriNumber); ?>', 'Mandiri account number copied!')"
                    class="w-full py-2 rounded-xl bg-[#091510] text-[#F5D77F] border border-[#D4AF37]/40 font-royal text-xs font-bold uppercase tracking-wider hover:bg-[#D4AF37]/15 transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="fa-regular fa-copy"></i>
                    <span>Copy Account Number</span>
                </button>
            </div>
        </section>

        
        
        
        <section id="rsvp" class="py-10 px-6 space-y-5">
            <div class="text-center">
                <span class="font-royal text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">RSVP Confirmation</span>
                <h2 class="font-royal text-2xl font-bold text-[#F5D77F] mt-0.5">Guestbook & Warm Wishes</h2>
            </div>

            
            <form
                @submit.prevent="submitRsvp()"
                class="bg-[#13221B]/90 border border-[#D4AF37]/40 rounded-3xl p-5 shadow-sm space-y-4 backdrop-blur-md"
            >
                <div>
                    <label class="block font-royal text-xs font-bold text-[#F5D77F] mb-1">Your Full Name</label>
                    <input
                        type="text"
                        x-model="formGuestName"
                        required
                        placeholder="Enter your name..."
                        class="w-full bg-[#091510] border border-[#D4AF37]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#FBF8EE] focus:outline-none focus:border-[#D4AF37]"
                    >
                </div>

                <div>
                    <label class="block font-royal text-xs font-bold text-[#F5D77F] mb-1.5">Attendance Status</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-royal flex flex-col items-center gap-1"
                            :class="formAttendance === 'attending' ? 'bg-[#D4AF37] text-[#091510] border-[#D4AF37]' : 'bg-[#091510] text-[#A3B899] border-[#D4AF37]/30'">
                            <input type="radio" value="attending" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">✦</span>
                            <span class="text-[10px] font-bold uppercase">Attending</span>
                        </label>
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-royal flex flex-col items-center gap-1"
                            :class="formAttendance === 'maybe' ? 'bg-[#D4AF37] text-[#091510] border-[#D4AF37]' : 'bg-[#091510] text-[#A3B899] border-[#D4AF37]/30'">
                            <input type="radio" value="maybe" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">⌛</span>
                            <span class="text-[10px] font-bold uppercase">Uncertain</span>
                        </label>
                        <label class="p-2.5 rounded-xl border cursor-pointer text-center text-xs font-royal flex flex-col items-center gap-1"
                            :class="formAttendance === 'absent' ? 'bg-[#D4AF37] text-[#091510] border-[#D4AF37]' : 'bg-[#091510] text-[#A3B899] border-[#D4AF37]/30'">
                            <input type="radio" value="absent" x-model="formAttendance" class="sr-only">
                            <span class="text-sm">✉️</span>
                            <span class="text-[10px] font-bold uppercase">Regrets</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-royal text-xs font-bold text-[#F5D77F] mb-1">Number of Guests</label>
                    <select
                        x-model="formGuestCount"
                        class="w-full bg-[#091510] border border-[#D4AF37]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#FBF8EE] focus:outline-none focus:border-[#D4AF37]"
                    >
                        <option value="1">1 Person</option>
                        <option value="2">2 Persons</option>
                        <option value="3">3 Persons</option>
                        <option value="4">4 Persons</option>
                    </select>
                </div>

                <div>
                    <label class="block font-royal text-xs font-bold text-[#F5D77F] mb-1">Warm Wishes & Blessings</label>
                    <textarea
                        x-model="formWishes"
                        required
                        rows="3"
                        placeholder="Write your prayers and warm wishes..."
                        class="w-full bg-[#091510] border border-[#D4AF37]/40 rounded-xl px-3.5 py-2.5 text-xs text-[#FBF8EE] focus:outline-none focus:border-[#D4AF37]"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    :disabled="isSubmittingRsvp"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-[#D4AF37] via-[#F5D77F] to-[#D4AF37] text-[#091510] font-royal text-xs font-bold uppercase tracking-wider shadow-lg transition flex items-center justify-center gap-1.5 cursor-pointer disabled:opacity-50"
                >
                    <span x-show="!isSubmittingRsvp">✨ Submit RSVP & Wishes</span>
                    <span x-show="isSubmittingRsvp" x-cloak>Submitting...</span>
                </button>
            </form>

            
            <div class="space-y-3">
                <h4 class="font-royal text-xs font-bold text-[#A3B899] uppercase tracking-wider">
                    VIP Guest Blessings (<span x-text="rsvps.length"></span>)
                </h4>
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    <template x-for="(w, idx) in rsvps" :key="idx">
                        <div class="bg-[#13221B]/80 border border-[#D4AF37]/30 rounded-2xl p-3.5 shadow-xs space-y-1 backdrop-blur-md">
                            <div class="flex items-center justify-between">
                                <span class="font-royal text-sm font-bold text-[#F5D77F]" x-text="w.guest_name"></span>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[9px] font-royal font-bold uppercase"
                                    :class="w.attendance_status === 'attending' ? 'bg-[#D4AF37]/20 text-[#F5D77F]' : 'bg-red-900/30 text-red-300'"
                                    x-text="w.attendance_status === 'attending' ? 'Attending' : 'Regrets'"
                                ></span>
                            </div>
                            <p class="text-xs text-[#D1DEC9] font-serif-luxury italic leading-relaxed" x-text="w.wishes"></p>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        
        <footer class="py-8 text-center border-t border-[#D4AF37]/30 space-y-1">
            <p class="font-royal text-2xl text-[#F5D77F]"><?php echo e($groomNickname); ?> & <?php echo e($brideNickname); ?></p>
            <p class="font-royal text-xs text-[#A3B899]">Digital Invitation by Maja Flower Studio</p>
        </footer>

        
        <div
            x-show="lightboxOpen"
            x-cloak
            @click.self="closeLightbox()"
            class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
        >
            <div class="relative max-w-sm w-full bg-[#13221B] rounded-3xl p-3 text-center border border-[#D4AF37]">
                <button
                    type="button"
                    @click="closeLightbox()"
                    class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#D4AF37] text-[#091510] flex items-center justify-center font-bold text-xs shadow-md"
                >✕</button>
                <img :src="lightboxImg" class="w-full rounded-2xl aspect-square object-cover mb-2">
                <p class="font-royal text-xs text-[#D1DEC9]" x-text="lightboxCaption"></p>
            </div>
        </div>
    </main>

    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('weddingLuxuryApp', (config) => ({
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
                formGuestName: '<?php echo e(addslashes($displayGuest)); ?>',
                formAttendance: 'attending',
                formGuestCount: '1',
                formWishes: '',
                isSubmittingRsvp: false,
                rsvps: <?php echo json_encode($story->rsvps ?? [], 15, 512) ?>,

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
                        this.showToast('VIP RSVP submitted (Demo Mode)! ✨');
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
                            this.showToast(data.message || 'Thank you for your blessings!');
                            this.formWishes = '';
                        }
                    })
                    .catch(() => {
                        this.isSubmittingRsvp = false;
                        this.showToast('Failed to submit RSVP. Please retry.');
                    });
                }
            }));
        });
    </script>
</body>
</html>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/digital-story/templates/wedding/elegant-luxury.blade.php ENDPATH**/ ?>