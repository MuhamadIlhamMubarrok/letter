@props([
    'initialAudioUrl' => null,
    'initialAudioTitle' => '',
    'initialStartSec' => 0,
    'initialEndSec' => null,
])

<div
    x-data="{
        audioSrc: @js($initialAudioUrl),
        audioTitle: @js($initialAudioTitle ?? ''),
        startSec: {{ (float) ($initialStartSec ?? 0) }},
        endSec: {{ $initialEndSec !== null && $initialEndSec !== '' ? (float) $initialEndSec : 'null' }},
        isPlaying: false,
        isTestingCut: false,
        currentTime: 0,
        duration: 0,
        audioElement: null,

        init() {
            this.audioElement = this.$refs.trimmerAudio;
            if (this.audioSrc) {
                this.setupAudioListeners();
            }
        },

        handleFileUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (this.audioSrc && this.audioSrc.startsWith('blob:')) {
                try { URL.revokeObjectURL(this.audioSrc); } catch(err) {}
            }

            this.audioSrc = URL.createObjectURL(file);
            if (!this.audioTitle) {
                this.audioTitle = file.name.replace(/\.[^/.]+$/, '');
            }

            this.isPlaying = false;
            this.isTestingCut = false;
            this.currentTime = 0;
            this.duration = 0;

            this.$nextTick(() => {
                this.setupAudioListeners();
            });
        },

        setupAudioListeners() {
            const el = this.$refs.trimmerAudio;
            if (!el) return;
            this.audioElement = el;

            el.onloadedmetadata = () => {
                this.duration = Math.floor(el.duration || 0);
            };

            el.ontimeupdate = () => {
                this.currentTime = el.currentTime;
                if (this.isTestingCut && this.endSec !== null && el.currentTime >= this.endSec) {
                    el.currentTime = this.startSec;
                    el.play().catch(() => {});
                }
            };

            el.onended = () => {
                this.isPlaying = false;
                this.isTestingCut = false;
            };

            el.onpause = () => {
                this.isPlaying = false;
            };

            el.onplay = () => {
                this.isPlaying = true;
            };
        },

        togglePlay() {
            const el = this.$refs.trimmerAudio;
            if (!el) return;
            this.isTestingCut = false;
            if (this.isPlaying) {
                el.pause();
            } else {
                el.play().catch(() => {});
            }
        },

        testCutSection() {
            const el = this.$refs.trimmerAudio;
            if (!el) return;
            el.currentTime = this.startSec;
            this.isTestingCut = true;
            el.play().catch(() => {});
        },

        seekAudio(val) {
            const el = this.$refs.trimmerAudio;
            if (!el) return;
            el.currentTime = parseFloat(val);
        },

        setStartFromCurrent() {
            const sec = Math.floor(this.currentTime);
            this.startSec = sec;
            if (this.endSec !== null && this.endSec <= this.startSec) {
                this.endSec = null;
            }
        },

        setEndFromCurrent() {
            const sec = Math.ceil(this.currentTime);
            if (sec > this.startSec) {
                this.endSec = sec;
            }
        },

        resetToFull() {
            this.startSec = 0;
            this.endSec = null;
            const el = this.$refs.trimmerAudio;
            if (el) {
                el.currentTime = 0;
            }
        },

        adjustStart(delta) {
            this.startSec = Math.max(0, this.startSec + delta);
            const el = this.$refs.trimmerAudio;
            if (el) {
                el.currentTime = this.startSec;
            }
        },

        adjustEnd(delta) {
            if (this.endSec === null && this.duration > 0) {
                this.endSec = this.duration;
            }
            if (this.endSec !== null) {
                this.endSec = Math.max(this.startSec + 1, this.endSec + delta);
            }
        },

        formatTime(seconds) {
            if (!seconds || isNaN(seconds) || seconds < 0) return '00:00';
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        }
    }"
    class="space-y-4"
>
    <!-- Hidden inputs for backend submission -->
    <input type="hidden" name="audio_start_sec" :value="startSec">
    <input type="hidden" name="audio_end_sec" :value="endSec !== null ? endSec : ''">

    <!-- Upload Input and Title Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">
                Unggah File Lagu (MP3/WAV/M4A)
            </label>
            <input
                type="file"
                name="audio_file"
                accept="audio/mp3,audio/wav,audio/ogg,audio/m4a,audio/*"
                @change="handleFileUpload($event)"
                class="w-full text-xs font-mono text-neutral-300 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer bg-night-bg p-1.5 rounded-xl border border-border-subtle"
            >
            <p class="text-[10px] text-neutral-400 font-mono mt-1">
                Pilih file audio dari HP / komputer untuk langsung memotong bagian reff/intro.
            </p>
        </div>

        <div>
            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">
                Judul Lagu / Artis
            </label>
            <input
                type="text"
                name="audio_title"
                x-model="audioTitle"
                placeholder="Contoh: Glenn Fredly - Kisah Romantis"
                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
            >
        </div>
    </div>

    <!-- Hidden Audio Tag for Decoding & Playback -->
    <template x-if="audioSrc">
        <audio x-ref="trimmerAudio" :src="audioSrc" preload="metadata" class="hidden"></audio>
    </template>

    <!-- INTERACTIVE AUDIO TRIMMER / CUTTER WORKSPACE -->
    <div
        x-show="audioSrc"
        x-cloak
        class="rounded-2xl bg-gradient-to-br from-[#0c120c] via-night-bg to-[#121c12] border-2 border-primary/40 p-4 sm:p-5 shadow-2xl space-y-4"
    >
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-border-subtle">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary/30 text-accent flex items-center justify-center text-sm border border-primary/50 shrink-0">
                    <i class="fa-solid fa-scissors"></i>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-cream text-sm flex items-center gap-1.5">
                        <span>Editor Potong Lagu (Audio Trimmer)</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-accent/20 text-accent border border-accent/40 font-mono font-semibold">Live Cutter</span>
                    </h4>
                    <p class="text-[11px] text-neutral-300" x-text="audioTitle || 'Pratinjau Audio Musik'"></p>
                </div>
            </div>

            <!-- Time Display -->
            <div class="flex items-center gap-2 font-mono text-xs text-right">
                <span class="px-2.5 py-1 rounded-lg bg-night-surface border border-border-subtle text-accent font-bold" x-text="formatTime(currentTime) + ' / ' + formatTime(duration)">
                    00:00 / 00:00
                </span>
            </div>
        </div>

        <!-- Audio Scrubber & Main Player Control -->
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <!-- Play/Pause Button -->
                <button
                    type="button"
                    @click="togglePlay()"
                    class="w-10 h-10 rounded-xl bg-primary hover:bg-primary-dark text-cream flex items-center justify-center transition shadow-md shadow-primary/30 shrink-0 cursor-pointer active:scale-95"
                    :title="isPlaying ? 'Jeda Musik' : 'Putar Musik'"
                >
                    <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play text-xs pl-0.5'"></i>
                </button>

                <!-- Scrubber Slider -->
                <div class="flex-1 space-y-1">
                    <input
                        type="range"
                        min="0"
                        :max="duration > 0 ? duration : 100"
                        step="0.1"
                        :value="currentTime"
                        @input="seekAudio($event.target.value)"
                        class="w-full h-2 bg-neutral-800 rounded-lg appearance-none cursor-pointer accent-accent"
                    >
                    <div class="flex justify-between text-[10px] font-mono text-neutral-400">
                        <span>Mulai: <strong class="text-accent" x-text="formatTime(startSec)"></strong></span>
                        <span x-show="isTestingCut" class="text-amber-300 font-bold animate-pulse">● Sedang Menguji Bagian Cut</span>
                        <span>Selesai: <strong class="text-accent" x-text="endSec !== null ? formatTime(endSec) : 'Sampai Habis'"></strong></span>
                    </div>
                </div>

                <!-- Test Cut Section Button -->
                <button
                    type="button"
                    @click="testCutSection()"
                    class="px-3.5 py-2 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 text-emerald-300 border border-emerald-600/70 text-xs font-mono font-bold transition flex items-center gap-1.5 shadow-md active:scale-95 shrink-0 cursor-pointer"
                    :class="{ 'ring-2 ring-emerald-400': isTestingCut }"
                    title="Tes putar hanya bagian yang di-potong"
                >
                    <i class="fa-solid fa-play text-[10px]"></i>
                    <span>Tes Cut</span>
                </button>
            </div>
        </div>

        <!-- CUT SETTINGS DUAL-CARD (START POINT & END POINT) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            <!-- 1. START POINT CARD -->
            <div class="p-3.5 rounded-xl bg-night-surface/90 border border-border-subtle space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-semibold text-neutral-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-flag text-emerald-400 text-[11px]"></i>
                        <span>Titik Mulai Putar</span>
                    </span>
                    <span class="font-mono text-sm font-bold text-emerald-300" x-text="formatTime(startSec) + ' (' + Math.floor(startSec) + 's)'"></span>
                </div>

                <div class="flex items-center gap-1.5 flex-wrap">
                    <button
                        type="button"
                        @click="setStartFromCurrent()"
                        class="flex-1 py-1.5 px-2 rounded-lg bg-emerald-900/60 hover:bg-emerald-800 text-emerald-200 border border-emerald-700/60 text-[11px] font-mono font-semibold transition flex items-center justify-center gap-1 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-crosshairs text-[10px]"></i>
                        <span>Ambil Posisi Saat Ini</span>
                    </button>
                    <button
                        type="button"
                        @click="adjustStart(-5)"
                        class="py-1.5 px-2 rounded-lg bg-night-bg text-neutral-300 hover:text-white border border-border-subtle text-[10px] font-mono transition cursor-pointer"
                        title="Mundur 5 detik"
                    >-5s</button>
                    <button
                        type="button"
                        @click="adjustStart(5)"
                        class="py-1.5 px-2 rounded-lg bg-night-bg text-neutral-300 hover:text-white border border-border-subtle text-[10px] font-mono transition cursor-pointer"
                        title="Maju 5 detik"
                    >+5s</button>
                </div>
                <p class="text-[10px] text-neutral-400">Musik akan langsung mulai diputar pada detik ini saat undangan/surat dibuka.</p>
            </div>

            <!-- 2. END POINT CARD -->
            <div class="p-3.5 rounded-xl bg-night-surface/90 border border-border-subtle space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-semibold text-neutral-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-flag-checkered text-rose-400 text-[11px]"></i>
                        <span>Titik Selesai (Cut Off)</span>
                    </span>
                    <span class="font-mono text-sm font-bold text-rose-300" x-text="endSec !== null ? formatTime(endSec) + ' (' + Math.floor(endSec) + 's)' : 'Sampai Habis'"></span>
                </div>

                <div class="flex items-center gap-1.5 flex-wrap">
                    <button
                        type="button"
                        @click="setEndFromCurrent()"
                        class="flex-1 py-1.5 px-2 rounded-lg bg-rose-950/60 hover:bg-rose-900 text-rose-200 border border-rose-800/60 text-[11px] font-mono font-semibold transition flex items-center justify-center gap-1 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-location-crosshairs text-[10px]"></i>
                        <span>Ambil Posisi Saat Ini</span>
                    </button>
                    <button
                        type="button"
                        @click="resetToFull()"
                        class="py-1.5 px-2 rounded-lg bg-night-bg text-neutral-300 hover:text-white border border-border-subtle text-[10px] font-mono transition cursor-pointer"
                        title="Putar sampai habis"
                    >Sampai Habis</button>
                    <button
                        type="button"
                        @click="adjustEnd(-5)"
                        class="py-1.5 px-2 rounded-lg bg-night-bg text-neutral-300 hover:text-white border border-border-subtle text-[10px] font-mono transition cursor-pointer"
                    >-5s</button>
                    <button
                        type="button"
                        @click="adjustEnd(5)"
                        class="py-1.5 px-2 rounded-lg bg-night-bg text-neutral-300 hover:text-white border border-border-subtle text-[10px] font-mono transition cursor-pointer"
                    >+5s</button>
                </div>
                <p class="text-[10px] text-neutral-400">Ketika mencapai detik ini, musik akan otomatis mengulang kembali dari titik mulai (loop).</p>
            </div>
        </div>
    </div>
</div>
