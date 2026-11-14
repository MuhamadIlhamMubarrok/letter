@props([
    'story',
    'theme' => 'dark'
])

@php
    $guestName = request()->query('to', request()->query('guest', request()->query('u', request()->query('nama'))));
    $isWedding = $story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION;
    $displayName = $guestName ?: ($isWedding ? 'Tamu Undangan Yang Berbahagia' : $story->recipient_name);
@endphp

<!-- INTERACTIVE PERSONAL WEDDING OPENING COVER -->
<div
    x-data="{
        coverOpened: false,
        openInvitation() {
            this.coverOpened = true;
            // Trigger audio autoplay if supported
            window.dispatchEvent(new CustomEvent('start-story-music'));
            // Unmute any audio players on the page
            const audioEl = document.querySelector('audio');
            if (audioEl) {
                audioEl.play().catch(() => {});
            }
        }
    }"
    class="relative"
>
    <!-- FULLSCREEN COVER OVERLAY -->
    <div
        x-show="!coverOpened"
        x-transition:leave="transition ease-spring duration-800 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-full scale-95 pointer-events-none"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-night-bg/95 backdrop-blur-xl text-center select-none overflow-y-auto"
    >
        <!-- Background Ambient Glow -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full bg-primary/30 blur-3xl"></div>
            <div class="absolute -bottom-32 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full bg-brand-amber/20 blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-md w-full my-auto space-y-6 px-4 py-8 rounded-3xl bg-night-surface/90 border border-primary/40 shadow-2xl backdrop-blur-md">
            <!-- Monogram / Wedding Badge -->
            <div class="w-16 h-16 mx-auto rounded-full bg-primary/40 border border-brand-amber/40 flex items-center justify-center text-2xl shadow-inner text-accent">
                💍
            </div>

            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-primary/30 border border-brand-amber/30 text-brand-amber font-mono text-[9px] uppercase tracking-[0.25em] font-semibold">
                    The Wedding Invitation
                </span>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-cream mt-2 tracking-tight">
                    {{ $story->title }}
                </h1>
                <p class="font-heading text-sm text-accent mt-1">
                    {{ $story->sender_name }} & {{ $story->recipient_name }}
                </p>
            </div>

            <!-- PERSONAL GUEST BADGE ON COVER -->
            <div class="bg-night-bg/90 border border-brand-amber/40 rounded-2xl p-5 shadow-inner space-y-1">
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-neutral-400 block">
                    Kepada Yth. Bapak/Ibu/Saudara/i:
                </span>
                <h2 class="font-heading text-xl sm:text-2xl font-bold text-cream tracking-tight">
                    {{ $displayName }}
                </h2>
                <span class="font-mono text-xs text-brand-amber font-medium block mt-1">
                    di Tempat
                </span>
            </div>

            <!-- OPEN BUTTON -->
            <div>
                <button
                    type="button"
                    @click="openInvitation()"
                    class="group inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-primary via-emerald-800 to-primary text-cream font-mono text-xs font-bold shadow-xl hover:shadow-primary/40 hover:scale-105 active:scale-95 transition-all duration-300 border border-white/20 cursor-pointer"
                >
                    <span class="text-base group-hover:rotate-12 transition-transform">💌</span>
                    <span>Buka Undangan</span>
                </button>
                <p class="font-mono text-[10px] text-neutral-400 mt-3">
                    *Sentuh tombol di atas untuk membuka undangan & memutar musik
                </p>
            </div>
        </div>
    </div>

    <!-- STATIONARY HEADER BADGE (Visible after cover opens) -->
    @if($guestName)
        <div class="max-w-md mx-auto my-4 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-night-surface/90 border border-brand-amber/40 shadow-md">
                <span class="text-accent text-xs">👑</span>
                <span class="font-mono text-xs text-neutral-300">
                    Undangan Personal: <strong class="text-cream font-bold">{{ $guestName }}</strong>
                </span>
            </div>
        </div>
    @endif
</div>
