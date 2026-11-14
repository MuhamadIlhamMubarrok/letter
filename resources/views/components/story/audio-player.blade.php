@props([
    'audioUrl',
    'title' => 'Alunan Kenangan Spesial',
    'artist' => 'Maja Flower Playlist',
])

@if($audioUrl)
<div
    x-data="{
        playing: false,
        duration: 0,
        currentTime: 0,
        audio: null,
        userInteracted: false,
        init() {
            this.audio = this.$refs.audioElement;
            this.audio.addEventListener('loadedmetadata', () => {
                this.duration = this.audio.duration;
            });
            this.audio.addEventListener('timeupdate', () => {
                this.currentTime = this.audio.currentTime;
            });
            this.audio.addEventListener('ended', () => {
                this.playing = false;
            });

            // Gentle attempt to play on user first scroll/click gesture
            const startPlaybackOnGesture = () => {
                if (!this.userInteracted && !this.playing) {
                    this.userInteracted = true;
                    this.playAudio();
                }
                window.removeEventListener('click', startPlaybackOnGesture);
                window.removeEventListener('touchstart', startPlaybackOnGesture);
            };
            window.addEventListener('click', startPlaybackOnGesture, { once: true });
            window.addEventListener('touchstart', startPlaybackOnGesture, { once: true });
        },
        togglePlay() {
            this.userInteracted = true;
            if (this.playing) {
                this.audio.pause();
                this.playing = false;
            } else {
                this.playAudio();
            }
        },
        playAudio() {
            this.audio.play().then(() => {
                this.playing = true;
            }).catch(err => {
                console.log('Autoplay prevented by browser, waiting for user gesture:', err);
                this.playing = false;
            });
        },
        seek(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const clickPos = (e.clientX - rect.left) / rect.width;
            this.audio.currentTime = clickPos * this.duration;
        },
        formatTime(seconds) {
            if (isNaN(seconds) || seconds <= 0) return '0:00';
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m}:${s < 10 ? '0' : ''}${s}`;
        }
    }"
    class="relative z-30 max-w-md mx-auto w-full"
>
    <audio x-ref="audioElement" src="{{ $audioUrl }}" preload="metadata" loop></audio>

    <div class="bg-night-card/90 backdrop-blur-md border border-night-border rounded-2xl p-3.5 shadow-2xl flex items-center gap-3">
        <!-- Vinyl Spinning Disc -->
        <button
            @click="togglePlay"
            type="button"
            class="relative w-12 h-12 rounded-full bg-dark flex items-center justify-center shrink-0 border border-white/10 shadow-inner group cursor-pointer"
        >
            <div
                class="w-10 h-10 rounded-full border border-dashed border-accent/40 flex items-center justify-center"
                :class="{ 'animate-spin': playing }"
                style="animation-duration: 4s;"
            >
                <div class="w-4 h-4 rounded-full bg-primary border-2 border-cream/80 flex items-center justify-center">
                    <span class="w-1 h-1 rounded-full bg-cream"></span>
                </div>
            </div>

            <!-- Play/Pause Overlay Icon -->
            <div class="absolute inset-0 flex items-center justify-center text-cream drop-shadow-md">
                <template x-if="!playing">
                    <svg class="w-5 h-5 ml-0.5 text-accent" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </template>
                <template x-if="playing">
                    <svg class="w-5 h-5 text-cream" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                </template>
            </div>
        </button>

        <!-- Track Information & Seekbar -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2 mb-1">
                <div class="truncate">
                    <p class="font-heading text-xs font-semibold text-cream truncate">
                        {{ $title }}
                    </p>
                    <p class="font-mono text-[9px] text-accent/80 truncate">
                        {{ $artist }}
                    </p>
                </div>

                <!-- Animated Equalizer Bars when playing -->
                <div class="flex items-end gap-0.5 h-3 shrink-0">
                    <span class="w-1 bg-accent rounded-full" :class="playing ? 'animate-bounce h-3' : 'h-1'"></span>
                    <span class="w-1 bg-secondary rounded-full" :class="playing ? 'animate-bounce h-2' : 'h-1'" style="animation-delay: 150ms;"></span>
                    <span class="w-1 bg-primary-light rounded-full" :class="playing ? 'animate-bounce h-3.5' : 'h-1'" style="animation-delay: 300ms;"></span>
                    <span class="w-1 bg-cream rounded-full" :class="playing ? 'animate-bounce h-2.5' : 'h-1'" style="animation-delay: 75ms;"></span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div
                @click="seek"
                class="w-full bg-night-surface rounded-full h-1.5 cursor-pointer overflow-hidden border border-white/5 relative"
            >
                <div
                    class="bg-gradient-to-r from-primary to-accent h-full rounded-full transition-all duration-100"
                    :style="`width: ${duration ? (currentTime / duration) * 100 : 0}%`"
                ></div>
            </div>

            <div class="flex justify-between items-center text-[9px] font-mono text-cream/50 mt-1">
                <span x-text="formatTime(currentTime)">0:00</span>
                <span x-text="formatTime(duration)">0:00</span>
            </div>
        </div>
    </div>
</div>
@endif
