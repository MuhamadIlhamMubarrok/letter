<x-layouts.client>
    <section class="py-10 xs:py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 xs:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="text-center mb-10">
                <span
                    class="font-mono text-xs uppercase tracking-widest text-secondary-dark dark:text-accent font-semibold">{{ __('messages.tracking_subtitle') }}</span>
                <h1 class="font-heading text-3xl xs:text-4xl md:text-5xl font-normal text-dark dark:text-cream mt-2">
                    {{ __('messages.tracking_title') }}
                </h1>
                <p class="text-xs sm:text-sm text-dark/75 dark:text-cream/75 font-body mt-2 max-w-lg mx-auto">
                    {{ __('messages.tracking_desc') }}
                </p>
            </div>

            <!-- Search Form Card -->
            <div
                class="bg-surface-light dark:bg-night-surface rounded-3xl border border-primary/15 dark:border-night-border shadow-lg p-6 sm:p-8 mb-10"
                x-data="{ searching: false }">
                <form action="{{ route('tracking.index') }}" method="GET" @submit="searching = true" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="code" value="{{ $code ?? '' }}" required
                            placeholder="Masukkan Nomor Resi (misal: BF-XXXX-XXXX) atau No. HP..."
                            class="w-full rounded-2xl bg-cream-light/60 dark:bg-night-card border border-dark/20 dark:border-night-border px-5 py-3.5 text-xs sm:text-sm text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 font-mono focus:outline-none focus:border-primary dark:focus:border-accent shadow-2xs" />
                    </div>
                    <button type="submit" :disabled="searching"
                        class="px-7 py-3.5 rounded-2xl bg-primary hover:bg-primary-dark disabled:opacity-50 text-cream font-semibold text-xs sm:text-sm font-body transition duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <span x-text="searching ? 'Mencari...' : 'Lacak Pesanan'">Lacak Pesanan</span>
                        <span class="font-serif text-sm">→</span>
                    </button>
                </form>

                <!-- Privacy Protection Notice -->
                <div
                    class="mt-4 pt-4 border-t border-border-subtle dark:border-night-border flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-dark/60 dark:text-cream/60">
                    <span class="flex items-center gap-1.5 text-[11px] font-mono">
                        <span class="text-brand-emerald dark:text-accent">🔒</span>
                        <span>Enkripsi Privasi Aktif: Nomor resi unik diberikan secara rahasia kepada Anda saat pesanan terdaftar.</span>
                    </span>
                    <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode('Halo Florist Maja Flower, saya ingin menanyakan nomor resi pesanan buket saya.') }}"
                        target="_blank"
                        class="text-[11px] font-mono text-primary dark:text-accent hover:underline font-semibold">
                        Lupa / Butuh No. Resi? Chat Florist →
                    </a>
                </div>
            </div>

            <!-- Feedback Alert after customer approval -->
            @if (session('status_message'))
                <div
                    class="mb-8 p-4 rounded-2xl bg-brand-emerald/15 border border-brand-emerald/30 text-brand-emerald dark:text-cream text-xs sm:text-sm font-medium flex items-center gap-3 shadow-xs">
                    <span class="text-brand-emerald dark:text-accent text-lg">✓</span>
                    <span>{{ session('status_message') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-8 p-4 rounded-2xl bg-brand-danger/15 border border-brand-danger/30 text-brand-danger dark:text-cream text-xs sm:text-sm font-medium flex items-center gap-3 shadow-xs">
                    <span class="text-brand-danger dark:text-cream text-lg">✕</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tracking Result Display -->
            @if ($order)
                <div class="space-y-8">

                    <!-- Order Overview Card -->
                    <div
                        class="bg-surface-light dark:bg-night-surface rounded-3xl border border-primary/15 dark:border-night-border shadow-md p-6 sm:p-8 relative overflow-hidden">
                        
                        <!-- Privacy watermarked strip -->
                        <div
                            class="flex items-center justify-between bg-primary/5 dark:bg-white/5 -mx-6 -mt-6 sm:-mx-8 sm:-mt-8 px-6 sm:px-8 py-2.5 mb-6 border-b border-border-subtle dark:border-night-border text-[10px] font-mono text-dark/60 dark:text-cream/60">
                            <span class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-emerald animate-pulse"></span>
                                <span>Enkripsi Privasi Aktif: Data Pribadi Disamarkan Otomatis</span>
                            </span>
                            <span class="hidden sm:inline font-mono">Maja Flower x Buckflow ERP Live Sync</span>
                        </div>

                        <!-- Header Resi & Status -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-border-subtle dark:border-night-border gap-4">
                            <div>
                                <span
                                    class="text-[11px] font-mono uppercase tracking-widest text-secondary-dark dark:text-accent">Nomor Resi Buket</span>
                                <h2 class="font-mono text-2xl font-bold text-primary dark:text-accent mt-0.5">
                                    {{ $order->tracking_code }}
                                </h2>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="px-3.5 py-1.5 rounded-full text-xs font-mono font-semibold border {{ $order->status_badge }}">
                                    ● {{ $order->status_label }}
                                </span>
                                @if ($order->isPickup())
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-mono font-semibold bg-brand-amber/15 text-brand-amber dark:text-cream border border-brand-amber/30 flex items-center gap-1.5 shadow-2xs">
                                        <span>🏬</span>
                                        <span>Ambil di Studio</span>
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-mono font-semibold bg-secondary/15 text-secondary-dark dark:text-accent border border-secondary/30 flex items-center gap-1.5 shadow-2xs">
                                        <span>🛵</span>
                                        <span>Kirim Kurir</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Masked Info Grid for Privacy -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-6 text-xs font-body">
                            <div>
                                <span
                                    class="text-dark/50 dark:text-cream/50 font-mono text-[11px] block uppercase">Pemesan:</span>
                                <p class="font-semibold text-dark dark:text-cream mt-0.5">
                                    {{ $order->masked_customer_name }}
                                </p>
                                <span
                                    class="font-mono text-dark/60 dark:text-cream/60">{{ $order->masked_customer_phone }}</span>
                            </div>
                            <div>
                                <span
                                    class="text-dark/50 dark:text-cream/50 font-mono text-[11px] block uppercase">Target Selesai / Kirim:</span>
                                <p class="font-mono font-bold text-primary dark:text-accent mt-0.5">
                                    @if ($order->deadline_at)
                                        {{ $order->deadline_at->format('d M Y, H:i') }} WIB
                                    @else
                                        Sesuai Jadwal Studio
                                    @endif
                                </p>
                                <span class="text-dark/60 dark:text-cream/60 text-[11px] font-mono">
                                    Metode: {{ $order->delivery_method_label }}
                                </span>
                            </div>
                            <div>
                                <span
                                    class="text-dark/50 dark:text-cream/50 font-mono text-[11px] block uppercase">Total Nilai Pesanan:</span>
                                <p class="font-mono text-base font-bold text-primary dark:text-accent mt-0.5">
                                    {{ $order->formatted_total_price }}
                                </p>
                                <span class="font-mono text-[11px] text-secondary-dark dark:text-accent">
                                    Status Bayar: {{ strtoupper((string) ($order->payment_status?->value ?? $order->payment_status ?? 'PAID')) }}
                                </span>
                            </div>
                        </div>

                        <!-- Rincian Produk Buket yang Dipesan -->
                        @if ($order->items->isNotEmpty())
                            <div class="mt-6 pt-6 border-t border-border-subtle dark:border-night-border">
                                <span class="text-xs font-semibold uppercase tracking-wider font-mono text-secondary-dark dark:text-accent block mb-3">
                                    Rincian Rangkaian Buket:
                                </span>
                                <div class="space-y-2.5">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl bg-cream-light/60 dark:bg-night-card border border-border-subtle dark:border-night-border">
                                            <div class="flex items-center gap-3">
                                                @if ($item->product?->resolved_image_url)
                                                    <img src="{{ $item->product->resolved_image_url }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-xl object-cover border border-border-subtle dark:border-night-border">
                                                @else
                                                    <div class="w-12 h-12 rounded-xl bg-surface-light dark:bg-night-surface border border-border-subtle dark:border-night-border flex items-center justify-center text-primary dark:text-accent">
                                                        <span class="text-xl">💐</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-heading font-bold text-dark dark:text-cream text-sm">
                                                        {{ $item->product?->name ?? 'Custom Florist Bouquet' }}
                                                    </h4>
                                                    <div class="text-xs text-dark/60 dark:text-cream/60 font-mono">
                                                        {{ $item->quantity }} pcs × {{ $item->formatted_price }}
                                                    </div>
                                                    @if ($item->customization_notes)
                                                        <p class="text-[11px] text-dark/70 dark:text-cream/70 italic font-body mt-0.5">
                                                            Catatan: {{ $item->customization_notes }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="font-mono font-bold text-primary dark:text-accent text-xs sm:text-sm text-right shrink-0">
                                                {{ $item->formatted_subtotal }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Greeting Card & Lokasi/Kurir Info -->
                        <div
                            class="mt-6 pt-6 border-t border-border-subtle dark:border-night-border grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                            
                            <!-- Delivery or Pickup Details -->
                            @if ($order->isPickup())
                                <div
                                    class="p-5 rounded-2xl bg-brand-amber/10 border border-brand-amber/30 text-dark dark:text-cream">
                                    <div class="flex items-center justify-between mb-2">
                                        <span
                                            class="font-mono text-xs font-bold text-brand-amber dark:text-cream uppercase tracking-wider flex items-center gap-1.5">
                                            <span>🏬</span>
                                            <span>Lokasi Pengambilan (Studio Maja)</span>
                                        </span>
                                        <span
                                            class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-brand-amber/20 text-brand-amber dark:text-cream font-semibold">
                                            Self Pick-up
                                        </span>
                                    </div>
                                    <p class="text-dark dark:text-cream font-medium text-xs sm:text-sm leading-relaxed">
                                        {{ setting('address', 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan (12180)') }}
                                    </p>
                                    <div
                                        class="mt-3 pt-3 border-t border-brand-amber/20 flex flex-wrap items-center justify-between gap-2 text-xs">
                                        <span class="font-mono text-dark/70 dark:text-cream/70 text-[11px]">
                                            ⏰ {{ setting('operating_hours', 'Buka Setiap Hari: 08.00 - 20.00 WIB') }}
                                        </span>
                                        <a href="https://maps.google.com/?q={{ urlencode(setting('address', 'Maja Flower')) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="font-mono text-primary dark:text-accent font-semibold hover:underline inline-flex items-center gap-1 text-[11px]">
                                            <span>📍 Petunjuk Arah Peta</span>
                                            <span>↗</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="p-4 rounded-2xl bg-cream-light/60 dark:bg-night-card border border-border-subtle dark:border-night-border">
                                    <span
                                        class="font-mono text-[10px] text-dark/50 dark:text-cream/50 uppercase tracking-wider block mb-1">
                                        Wilayah Tujuan / Pengiriman
                                    </span>
                                    <p class="text-dark/80 dark:text-cream/80 font-body leading-relaxed">
                                        {{ $order->masked_delivery_address }}
                                    </p>
                                    @if ($order->courier_name)
                                        <div class="mt-2 pt-2 border-t border-border-subtle dark:border-night-border font-mono text-[11px] text-primary dark:text-accent">
                                            🛵 Kurir: <strong>{{ $order->courier_name }}</strong>
                                            @if ($order->courier_tracking_url)
                                                <a href="{{ $order->courier_tracking_url }}" target="_blank" class="ml-2 underline font-semibold">Lacak Kurir ↗</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Greeting Card Note -->
                            <div
                                class="p-4 rounded-2xl bg-cream-light/60 dark:bg-night-card border border-border-subtle dark:border-night-border">
                                <span
                                    class="font-mono text-[10px] text-dark/50 dark:text-cream/50 uppercase tracking-wider block mb-1">Kartu Ucapan</span>
                                <p class="text-dark/80 dark:text-cream/80 italic font-body leading-relaxed">
                                    {{ $order->greeting_card_message ? '"' . \Illuminate\Support\Str::limit($order->greeting_card_message, 80, '... [Disimpan rahasia untuk kartu penerima]') . '"' : 'Tanpa pesan kartu ucapan.' }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- STEPPER & TIMELINE COMPONENT WITH PHOTO APPROVAL -->
                    <x-client.tracking-timeline :order="$order" :allSteps="$allSteps" />

                </div>
            @elseif($code)
                <!-- No Order Found State -->
                <div
                    class="text-center py-12 bg-surface-light dark:bg-night-surface rounded-3xl border border-dashed border-brand-danger/40 p-8">
                    <span class="text-4xl block mb-2">🔍</span>
                    <h3 class="font-heading text-xl font-medium text-dark dark:text-cream">Pesanan Tidak Ditemukan</h3>
                    <p class="text-xs text-dark/60 dark:text-cream/60 font-body mt-2 max-w-sm mx-auto">
                        Nomor resi <strong class="font-mono">{{ $code }}</strong> tidak ditemukan dalam basis data sistem Buckflow kami. Pastikan nomor pesanan atau nomor HP sudah benar.
                    </p>
                    <div class="mt-6">
                        <a href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}" target="_blank"
                            class="px-5 py-2.5 rounded-full text-xs font-semibold text-cream bg-primary hover:bg-primary-dark shadow-md transition">
                            Tanyakan ke WhatsApp Florist →
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>
</x-layouts.client>
