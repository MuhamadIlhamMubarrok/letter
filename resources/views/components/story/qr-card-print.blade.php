@props([
    'story',
    'size' => 'a6', // 'a6' or 'business-card'
])

@php
    $isA6 = $size === 'a6';
    $qrSvg = null;
    if ($story->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($story->qr_code_path)) {
        $qrSvg = \Illuminate\Support\Facades\Storage::disk('public')->get($story->qr_code_path);
        // Strip xml declaration if present for direct inline SVG embedding
        $qrSvg = preg_replace('/<\?xml.*?\?>/i', '', $qrSvg);
    }
@endphp

<div class="print-card-wrapper relative bg-[#FAF8E8] text-dark font-body select-none border border-[#E3DC9E] shadow-lg rounded-2xl overflow-hidden {{ $isA6 ? 'w-[105mm] min-h-[148mm] p-6' : 'w-[90mm] min-h-[55mm] p-4' }} mx-auto">
    <!-- Subtle Botanical Floral Corner Watermark -->
    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-primary/5 pointer-events-none"></div>
    <div class="absolute -bottom-6 -left-6 w-24 h-24 rounded-full bg-secondary/10 pointer-events-none"></div>

    <div class="relative z-10 flex flex-col justify-between h-full">
        <!-- 1. Header / Atelier Branding -->
        <div class="text-center border-b border-primary/15 pb-2">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-primary"></span>
                <span class="font-heading font-bold tracking-wider text-primary text-xs uppercase">Maja Flower Studio</span>
                <span class="w-2 h-2 rounded-full bg-primary"></span>
            </div>
            <div class="inline-block px-2.5 py-0.5 rounded-full bg-primary/10 text-primary-dark font-mono text-[9px] uppercase tracking-widest font-semibold">
                {{ $story->story_type->label() }}
            </div>
        </div>

        <!-- 2. Card Core: Names, Date & QR Code -->
        <div class="my-3 flex {{ $isA6 ? 'flex-col items-center text-center' : 'flex-row items-center justify-between gap-3' }}">
            <!-- Left Info (or Top on A6) -->
            <div class="{{ $isA6 ? 'mb-3' : 'flex-1 text-left' }}">
                <p class="font-mono text-[10px] uppercase text-dark-muted tracking-wider">Untuk:</p>
                <h3 class="font-heading font-bold text-dark {{ $isA6 ? 'text-lg leading-snug' : 'text-sm leading-tight' }} text-primary">
                    {{ $story->recipient_name }}
                </h3>

                <p class="font-mono text-[10px] uppercase text-dark-muted tracking-wider mt-1">Dari:</p>
                <p class="font-body font-semibold text-dark text-xs">
                    {{ $story->sender_name }}
                </p>

                @if($story->event_date)
                    <p class="font-mono text-[9px] text-dark-muted mt-1.5 flex items-center {{ $isA6 ? 'justify-center' : '' }} gap-1">
                        <span>🗓️</span>
                        <span>{{ $story->event_date->translatedFormat('d F Y') }}</span>
                    </p>
                @endif
            </div>

            <!-- QR Code Section -->
            <div class="flex flex-col items-center shrink-0">
                <div class="bg-white p-2 rounded-xl shadow-xs border border-primary/20 flex items-center justify-center {{ $isA6 ? 'w-36 h-36' : 'w-24 h-24' }}">
                    @if($qrSvg)
                        <div class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:object-contain">
                            {!! $qrSvg !!}
                        </div>
                    @else
                        <div class="font-mono text-[9px] text-brand-danger text-center p-1">QR Belum Digenerate</div>
                    @endif
                </div>
                <span class="font-mono text-[8px] text-dark-muted mt-1 tracking-wider uppercase">
                    ID: {{ $story->slug }}
                </span>
            </div>
        </div>

        <!-- 3. Instructions & Footer -->
        <div class="text-center pt-2 border-t border-primary/15">
            <p class="text-[9px] font-body text-dark/80 italic leading-tight">
                "Pindai kode QR dengan kamera ponsel Anda untuk membuka kenangan digital kami 🌸"
            </p>
            <p class="font-mono text-[8px] text-primary-dark mt-1 font-semibold">
                {{ url('/s/' . $story->slug) }}
            </p>
        </div>
    </div>

    <!-- Scissor / Cutting Guide Marker (Dashed border guide) -->
    <div class="cut-guide absolute inset-0 border border-dashed border-dark/20 pointer-events-none rounded-2xl"></div>
</div>
