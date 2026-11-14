@props([
    'media' => [],
])

@if(!empty($media) && count($media) > 0)
<div
    x-data="{
        lightboxOpen: false,
        currentIndex: 0,
        photos: {{ Js::from(collect($media)->map(fn($m) => [
            'url' => $m->file_url,
            'caption' => $m->caption ?? '',
            'name' => $m->file_name,
        ])) }},
        openLightbox(index) {
            this.currentIndex = index;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = '';
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.photos.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
        }
    }"
    @keydown.escape.window="closeLightbox()"
    @keydown.right.window="if(lightboxOpen) next()"
    @keydown.left.window="if(lightboxOpen) prev()"
    class="w-full my-8"
>
    <!-- Section Title -->
    <div class="text-center mb-6">
        <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold">Galeri Kenangan Polaroid</span>
        <h4 class="font-heading text-xl md:text-2xl font-bold text-cream mt-1">Momen Terindah Kita</h4>
        <div class="w-12 h-0.5 bg-accent/30 mx-auto mt-2 rounded-full"></div>
    </div>

    <!-- Polaroid Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 px-2 max-w-4xl mx-auto">
        @php
            $rotations = ['-rotate-2', 'rotate-2', '-rotate-1', 'rotate-1', '-rotate-3', 'rotate-3'];
        @endphp

        @foreach($media as $index => $item)
            @php
                $tilt = $rotations[$index % count($rotations)];
            @endphp
            <div
                @click="openLightbox({{ $index }})"
                class="group relative bg-[#FDFBF7] p-3 pb-5 rounded-sm shadow-xl hover:shadow-2xl transition-all duration-300 transform {{ $tilt }} hover:rotate-0 hover:scale-105 cursor-pointer border border-[#E3DC9E]/60 select-none"
            >
                <!-- Washi Tape Decorative Header -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#FAF8E8]/90 backdrop-blur-xs border border-dark/10 shadow-xs rotate-1 pointer-events-none opacity-85 z-10"></div>

                <!-- Photo Container -->
                <div class="aspect-square w-full overflow-hidden bg-night-bg relative rounded-xs">
                    <img
                        src="{{ $item->file_url }}"
                        alt="{{ $item->caption ?? 'Kenangan Polaroid' }}"
                        loading="lazy"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-primary-dark/10 group-hover:opacity-0 transition-opacity"></div>
                </div>

                <!-- Handwritten Style Caption -->
                <div class="mt-3 px-1 text-center">
                    <p class="font-body text-xs text-dark/85 italic leading-tight truncate">
                        {{ $item->caption ?: 'Kenangan Bersama 🌸' }}
                    </p>
                    <span class="font-mono text-[9px] text-dark-muted block mt-1">
                        #{{ $index + 1 }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Fullscreen Lightbox Modal -->
    <template x-teleport="body">
        <div
            x-show="lightboxOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-night-bg/95 backdrop-blur-md p-4 select-none"
        >
            <!-- Close Button -->
            <button
                @click="closeLightbox()"
                type="button"
                class="absolute top-5 right-5 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-cream flex items-center justify-center font-bold text-lg transition cursor-pointer"
            >
                ✕
            </button>

            <!-- Navigation Controls -->
            <button
                x-show="photos.length > 1"
                @click.stop="prev()"
                type="button"
                class="absolute left-4 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-cream flex items-center justify-center text-xl transition cursor-pointer"
            >
                ‹
            </button>

            <button
                x-show="photos.length > 1"
                @click.stop="next()"
                type="button"
                class="absolute right-4 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 text-cream flex items-center justify-center text-xl transition cursor-pointer"
            >
                ›
            </button>

            <!-- Lightbox Main Polaroid Container -->
            <div
                @click.outside="closeLightbox()"
                class="relative max-w-xl w-full bg-[#FAF8E8] p-4 pb-6 rounded-md shadow-2xl border border-cream-dark text-dark mx-auto"
            >
                <div class="max-h-[70vh] overflow-hidden rounded bg-night-bg flex items-center justify-center">
                    <img
                        :src="photos[currentIndex]?.url"
                        :alt="photos[currentIndex]?.caption"
                        class="max-h-[70vh] w-auto max-w-full object-contain mx-auto"
                    >
                </div>

                <div class="mt-4 text-center px-4">
                    <p class="font-heading text-sm sm:text-base text-dark italic" x-text="photos[currentIndex]?.caption || 'Kenangan Spesial 🌸'"></p>
                    <p class="font-mono text-[10px] text-dark-muted mt-1" x-text="`Foto ${currentIndex + 1} dari ${photos.length}`"></p>
                </div>
            </div>
        </div>
    </template>
</div>
@endif
