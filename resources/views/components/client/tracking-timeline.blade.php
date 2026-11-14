@props(['order', 'allSteps'])

@php
    $currentStepIndex = $order->status_step;
@endphp

<div x-data="{ photoModalOpen: false }" class="space-y-8">
    <!-- Horizontal Stepper on Desktop / Vertical on Mobile -->
    <div class="relative bg-surface-light dark:bg-night-surface rounded-3xl border border-primary/10 dark:border-night-border p-6 sm:p-8 shadow-xs">
        <h3 class="font-heading text-base sm:text-lg font-bold text-dark dark:text-cream mb-6">
            Tahapan Pengerjaan Rangkaian Bunga:
        </h3>

        <!-- Desktop Stepper (4 Steps) -->
        <div class="hidden md:grid grid-cols-4 gap-2 relative">
            <!-- Connecting progress line -->
            <div class="absolute top-5 left-1/8 right-1/8 h-1 bg-dark/10 dark:bg-white/10 -z-0">
                <div class="h-full bg-primary dark:bg-accent transition-all duration-700"
                    style="width: {{ $currentStepIndex <= 1 ? 0 : (($currentStepIndex - 1) / 3) * 100 }}%"></div>
            </div>

            @foreach ($allSteps as $index => $step)
                @php
                    $stepNum = $index + 1;
                    $isPassed = $stepNum < $currentStepIndex;
                    $isCurrent = $stepNum === $currentStepIndex;
                    $isFuture = $stepNum > $currentStepIndex;
                @endphp

                <div class="flex flex-col items-center text-center relative z-10 px-1">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center font-mono text-xs font-bold transition-all duration-300 shadow-xs
                        {{ $isCurrent ? 'bg-primary dark:bg-accent dark:text-night-bg text-cream ring-4 ring-primary/20 scale-110' : '' }}
                        {{ $isPassed ? 'bg-secondary text-white' : '' }}
                        {{ $isFuture ? 'bg-surface-light dark:bg-night-card text-dark/40 dark:text-cream/40 border border-border-subtle dark:border-night-border' : '' }}">
                        @if ($isPassed)
                            ✓
                        @else
                            {{ $stepNum }}
                        @endif
                    </div>

                    <span
                        class="mt-2.5 text-xs font-medium leading-snug {{ $isCurrent ? 'text-primary dark:text-accent font-bold' : ($isPassed ? 'text-dark dark:text-cream' : 'text-dark/40 dark:text-cream/40') }}">
                        {{ $step['label'] }}
                    </span>

                    @if ($stepNum === 2 && $order->florist)
                        <span class="mt-1 text-[10px] font-mono text-secondary-dark dark:text-accent">
                            Oleh: {{ $order->florist->name }}
                        </span>
                    @endif

                    @if ($stepNum === 3 && $order->qc_photo_url)
                        <span
                            class="mt-1 px-2 py-0.5 rounded-full text-[10px] font-mono bg-brand-indigo/15 text-brand-indigo dark:text-cream border border-brand-indigo/30 animate-pulse">
                            Foto Tersedia
                        </span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Vertical Timeline for Mobile screens -->
        <div class="md:hidden space-y-4">
            @foreach ($allSteps as $index => $step)
                @php
                    $stepNum = $index + 1;
                    $isPassed = $stepNum < $currentStepIndex;
                    $isCurrent = $stepNum === $currentStepIndex;
                    $isFuture = $stepNum > $currentStepIndex;
                @endphp

                <div class="flex items-start gap-3">
                    <div
                        class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-mono text-xs font-bold
                        {{ $isCurrent ? 'bg-primary dark:bg-accent dark:text-night-bg text-cream ring-4 ring-primary/20' : '' }}
                        {{ $isPassed ? 'bg-secondary text-white' : '' }}
                        {{ $isFuture ? 'bg-surface-light dark:bg-night-card text-dark/40 dark:text-cream/40 border border-border-subtle dark:border-night-border' : '' }}">
                        @if ($isPassed)
                            ✓
                        @else
                            {{ $stepNum }}
                        @endif
                    </div>
                    <div>
                        <p
                            class="text-sm font-medium {{ $isCurrent ? 'text-primary dark:text-accent font-bold' : ($isPassed ? 'text-dark dark:text-cream' : 'text-dark/40 dark:text-cream/40') }}">
                            {{ $step['label'] }}
                        </p>
                        @if ($isCurrent)
                            <p class="text-xs text-primary/80 dark:text-accent/80 font-mono">Tahap Sedang Berjalan</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- PHOTO APPROVAL / QC PHOTO HIGHLIGHT SECTION -->
    @if ($order->qc_photo_url)
        <div
            class="p-6 md:p-8 rounded-3xl bg-brand-indigo/10 border-2 border-brand-indigo/30 shadow-md">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Photo Thumbnail -->
                <div class="relative w-full md:w-56 aspect-square rounded-2xl overflow-hidden bg-surface-light dark:bg-night-card shadow-sm border border-brand-indigo/25 flex-shrink-0 group cursor-pointer"
                    @click="photoModalOpen = true">
                    <img src="{{ $order->qc_photo_url }}" alt="Foto Hasil Rangkaian Buket"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
                    <div
                        class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-cream text-xs font-medium">
                        🔍 Klik untuk perbesar foto
                    </div>
                    <span
                        class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-mono bg-brand-indigo text-cream font-semibold">
                        Preview Florist
                    </span>
                </div>

                <!-- Approval Context and Action -->
                <div class="flex-1 space-y-3 text-center md:text-left" x-data="{ approving: false }">
                    <div
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-medium bg-brand-indigo/20 text-brand-indigo dark:text-cream">
                        📸 Quality Control & Approval Foto Buket
                    </div>
                    <h3 class="font-heading text-xl md:text-2xl font-bold text-dark dark:text-cream">
                        Buket Anda Sudah Selesai Dirangkai!
                    </h3>
                    <p class="text-xs md:text-sm text-dark/70 dark:text-cream/70 font-body leading-relaxed">
                        Florist kami baru saja menyelesaikan rangkaian buket pesanan Anda. Silakan periksa keindahan hasil karya sebelum kami membungkus atau mengirimkannya ke alamat tujuan.
                    </p>

                    @php
                        $approvalVal = $order->customer_approval_status;
                    @endphp

                    @if ($approvalVal === 'APPROVED')
                        <div
                            class="p-3 bg-brand-emerald/15 border border-brand-emerald/30 text-brand-emerald dark:text-cream rounded-xl text-xs font-medium flex items-center gap-2">
                            <span>✓</span> Anda telah menyetujui hasil rangkaian ini. Buket siap untuk proses serah terima atau pengiriman kurir.
                        </div>
                    @else
                        <!-- Interactive Approval Buttons with Anti Double-Click Protection -->
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <form action="{{ route('tracking.approval', $order->tracking_code) }}" method="POST" @submit="approving = true">
                                @csrf
                                <input type="hidden" name="action" value="APPROVE">
                                <button type="submit"
                                    :disabled="approving"
                                    class="px-5 py-2.5 rounded-full text-xs font-bold text-cream bg-primary hover:bg-primary-dark disabled:opacity-50 transition duration-200 shadow-sm cursor-pointer flex items-center gap-1.5">
                                    <span x-text="approving ? 'Memproses...' : '✓ Setujui Rangkaian'">✓ Setujui Rangkaian</span>
                                </button>
                            </form>

                            @php
                                $reviseMsg = urlencode(
                                    "Halo Florist Maja Flower, untuk pesanan resi {$order->tracking_code}, saya ingin konsultasikan sedikit revisi pada hasil buket: ",
                                );
                                $reviseWa = "https://wa.me/" . setting('whatsapp_number', '6285882119900') . "?text={$reviseMsg}";
                            @endphp

                            <a href="{{ $reviseWa }}" target="_blank"
                                class="px-5 py-2.5 rounded-full text-xs font-medium text-dark dark:text-cream bg-surface-light dark:bg-night-card hover:bg-cream-dark dark:hover:bg-white/10 border border-brand-indigo/30 transition duration-200 shadow-xs">
                                💬 Minta Penyesuaian via WA
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- High-Res Zoom Modal -->
        <div x-show="photoModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-dark/80 backdrop-blur-xs"
            @click.self="photoModalOpen = false">
            <div
                class="relative max-w-3xl w-full bg-surface-light dark:bg-night-surface rounded-3xl overflow-hidden shadow-2xl p-4 border border-dark/10 dark:border-night-border">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-mono text-xs font-bold text-primary dark:text-accent">Preview Resolusi Tinggi —
                        {{ $order->tracking_code }}</span>
                    <button @click="photoModalOpen = false"
                        class="text-dark/50 dark:text-cream/50 hover:text-dark dark:hover:text-cream text-lg font-bold">✕</button>
                </div>
                <img src="{{ $order->qc_photo_url }}" alt="Foto Buket Detail"
                    class="w-full max-h-[75vh] object-contain rounded-2xl bg-cream-light dark:bg-night-card" />
            </div>
        </div>
    @endif

    <!-- READY FOR PICK-UP HIGHLIGHT CARD -->
    @if ($order->status?->value === 'ready' && $order->isPickup())
        <div class="p-6 md:p-8 rounded-3xl bg-brand-amber/10 border-2 border-brand-amber/40 shadow-md">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-brand-amber/20 text-brand-amber dark:text-cream flex items-center justify-center text-3xl shrink-0 shadow-inner">
                    🏬
                </div>
                <div class="flex-1 text-center md:text-left space-y-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-bold bg-brand-amber/20 text-brand-amber dark:text-cream">
                        <span>✨</span>
                        <span>Buket Siap Diambil di Studio</span>
                    </div>
                    <h3 class="font-heading text-xl md:text-2xl font-bold text-dark dark:text-cream">
                        Buket Bunga Anda Sudah Siap di Studio Maja!
                    </h3>
                    <p class="text-xs md:text-sm text-dark/75 dark:text-cream/80 font-body leading-relaxed">
                        Rangkaian pesanan Anda telah selesai dikemas rapi dan siap diserahkan. Silakan kunjungi studio kami dan tunjukkan nomor resi <strong>{{ $order->tracking_code }}</strong> kepada florist kami.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center gap-3 justify-center md:justify-start">
                        <a href="https://maps.google.com/?q={{ urlencode(setting('address', 'Maja Flower')) }}" target="_blank" rel="noopener noreferrer"
                            class="px-5 py-2.5 rounded-full text-xs font-mono font-bold text-cream bg-primary hover:bg-primary-dark transition shadow-xs flex items-center gap-1.5">
                            <span>📍 Buka Petunjuk Arah Peta</span>
                            <span>↗</span>
                        </a>
                        @php
                            $otwWa = "https://wa.me/" . setting('whatsapp_number', '6285882119900') . "?text=" . urlencode("Halo Florist Maja Flower, saya sedang menuju studio untuk mengambil buket pesanan saya (Resi: {$order->tracking_code}).");
                        @endphp
                        <a href="{{ $otwWa }}" target="_blank" rel="noopener noreferrer"
                            class="px-5 py-2.5 rounded-full text-xs font-mono font-bold text-brand-emerald dark:text-cream bg-brand-emerald/15 hover:bg-brand-emerald/25 border border-brand-emerald/30 transition shadow-xs flex items-center gap-1.5">
                            <span>💬 Konfirmasi OTW via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($order->status?->value === 'completed')
        <div class="p-6 md:p-8 rounded-3xl bg-brand-emerald/15 border border-brand-emerald/30 shadow-xs flex items-center gap-4">
            <span class="text-3xl shrink-0">🌸</span>
            <div>
                <h4 class="font-heading text-lg font-bold text-brand-emerald dark:text-cream">
                    Pesanan Telah Selesai & Diterima
                </h4>
                <p class="text-xs text-dark/70 dark:text-cream/70 font-body mt-0.5">
                    Terima kasih telah mempercayakan momen bahagia Anda bersama Maja Flower. Semoga keindahan rangkaian bunga ini membawa kebahagiaan!
                </p>
            </div>
        </div>
    @endif

    <!-- Timeline History Log -->
    <div
        class="p-6 rounded-3xl bg-surface-light dark:bg-night-surface border border-primary/10 dark:border-night-border shadow-xs">
        <h4 class="font-heading text-lg font-medium text-dark dark:text-cream mb-4 flex items-center gap-2">
            <span>Riwayat Perjalanan Pesanan</span>
            <span
                class="font-mono text-xs text-dark/50 dark:text-cream/50 font-normal">({{ $order->timelines->count() }}
                tahap tercatat)</span>
        </h4>

        <div
            class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-primary/20 dark:before:bg-primary/40">
            @forelse ($order->timelines as $timeline)
                <div class="relative">
                    <div
                        class="absolute -left-[27px] top-1 w-3 h-3 rounded-full bg-primary dark:bg-accent ring-4 ring-cream dark:ring-night-surface">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-1">
                        <span class="text-xs font-mono font-bold text-primary dark:text-accent">
                            {{ $timeline->status_title }}
                        </span>
                        <span class="text-[11px] font-mono text-dark/40 dark:text-cream/40">
                            {{ $timeline->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    @if ($timeline->notes)
                        <p class="mt-1 text-xs text-dark/70 dark:text-cream/70 font-body leading-relaxed">
                            {{ $timeline->notes }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-xs text-dark/40 dark:text-cream/40 font-mono">Belum ada catatan pembaruan.</p>
            @endforelse
        </div>
    </div>
</div>
