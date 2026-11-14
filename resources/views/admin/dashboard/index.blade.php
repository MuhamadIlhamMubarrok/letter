<x-layouts.admin title="Dashboard Florist" header="Ringkasan Studio & Buckflow Sync">

    <!-- 1. MOBILE-FRIENDLY QUICK ACTION BAR -->
    <div class="mb-6 overflow-x-auto touch-scroll pb-1 -mx-4 px-4 sm:mx-0 sm:px-0">
        <div class="flex items-center gap-2.5 min-w-max">
            <!-- Action 1: Buckflow ERP -->
            <a
                href="{{ $buckflowAppUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-primary text-cream hover:bg-primary-dark font-mono text-xs font-semibold shadow-xs transition active:scale-95"
            >
                <span>⚡</span>
                <span>Buka Buckflow ERP ↗</span>
            </a>

            <!-- Action 2: Fresh Flowers Quick Update -->
            <a
                href="{{ route('admin.fresh-flowers.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-50 text-emerald-950 border border-emerald-300 hover:bg-emerald-100 font-mono text-xs font-semibold transition active:scale-95"
            >
                <span>🌸</span>
                <span>Update Stok Bunga Segar</span>
            </a>

            <!-- Action 3: Add Bouquet -->
            <a
                href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-surface border border-dark/15 text-dark hover:bg-cream font-mono text-xs font-semibold transition active:scale-95"
            >
                <span>💐</span>
                <span>+ Tambah Buket</span>
            </a>

            <!-- Action 4: Categories / Series -->
            <a
                href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-surface border border-dark/15 text-dark hover:bg-cream font-mono text-xs font-semibold transition active:scale-95"
            >
                <span>🏷️</span>
                <span>Kategori Series</span>
            </a>

            <!-- Action 5: Customer Stories -->
            <a
                href="{{ route('admin.stories.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-surface border border-dark/15 text-dark hover:bg-cream font-mono text-xs font-semibold transition active:scale-95"
            >
                <span>📷</span>
                <span>Momen Bahagia</span>
            </a>
        </div>
    </div>

    <!-- 2. STAT CARDS OVERVIEW (Responsive 2-Col Mobile to 5-Col Desktop) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <!-- Stat 1: Total Products -->
        <a href="{{ route('admin.products.index') }}" class="p-4 sm:p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs hover:border-primary/30 transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] sm:text-xs uppercase tracking-wider text-dark/50">Katalog Buket</span>
                <span class="p-1 rounded-xl bg-primary/10 text-primary flex items-center justify-center w-7 h-7 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('general/logo.png') }}" alt="Maja Flower Logo" class="h-3.5 w-auto object-contain">
                </span>
            </div>
            <div class="mt-2.5">
                <span class="font-mono text-xl sm:text-2xl font-bold text-dark">{{ $stats['total_products'] }}</span>
                <span class="text-[10px] sm:text-[11px] text-dark/60 block mt-0.5">Item terdaftar</span>
            </div>
        </a>

        <!-- Stat 2: Fresh Flowers In Stock -->
        <a href="{{ route('admin.fresh-flowers.index') }}" class="p-4 sm:p-5 rounded-3xl bg-emerald-50/70 border border-emerald-200/80 shadow-xs hover:border-emerald-400 hover:shadow-sm transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] sm:text-xs uppercase tracking-wider text-emerald-900 font-semibold">Bunga Segar</span>
                <span class="p-1 rounded-xl bg-emerald-200/80 text-emerald-900 group-hover:scale-110 transition-transform text-sm">🌸</span>
            </div>
            <div class="mt-2.5">
                <div class="flex items-baseline gap-1">
                    <span class="font-mono text-xl sm:text-2xl font-bold text-emerald-950">{{ $freshFlowersCount }}</span>
                    <span class="text-[10px] font-mono text-emerald-800">Varian</span>
                </div>
                <span class="text-[10px] sm:text-[11px] text-emerald-700/90 block mt-0.5 font-mono truncate">{{ $totalFreshStems }} tangkai ready →</span>
            </div>
        </a>

        <!-- Stat 3: Active Orders (From Buckflow ERP) -->
        <a href="{{ $buckflowAppUrl }}" target="_blank" rel="noopener noreferrer" class="p-4 sm:p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs hover:border-primary/30 transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] sm:text-xs uppercase tracking-wider text-dark/50">Pesanan Aktif (ERP)</span>
                <span class="p-1 rounded-xl bg-amber-100 text-amber-800 text-sm group-hover:scale-110 transition-transform">⏳</span>
            </div>
            <div class="mt-2.5">
                <span class="font-mono text-xl sm:text-2xl font-bold text-amber-800">{{ $stats['active_orders'] }}</span>
                <span class="text-[10px] sm:text-[11px] text-dark/60 block mt-0.5 font-mono">Buckflow Live Sync ↗</span>
            </div>
        </a>

        <!-- Stat 4: Customer Stories -->
        <a
            href="{{ route('admin.stories.index') }}"
            class="p-4 sm:p-5 rounded-3xl bg-purple-50/90 border border-purple-200 shadow-xs transition group flex flex-col justify-between"
        >
            <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] sm:text-xs uppercase tracking-wider text-purple-900 font-bold">Momen Bahagia</span>
                <span class="p-1 rounded-xl bg-purple-200 text-purple-900 text-sm">📸</span>
            </div>
            <div class="mt-2.5">
                <span class="font-mono text-xl sm:text-2xl font-bold text-purple-950">{{ $storiesCount }}</span>
                <span class="text-[10px] sm:text-[11px] text-purple-800/90 block mt-0.5 font-medium">Cerita terbit</span>
            </div>
        </a>

        <!-- Stat 5: Completed Orders & Revenue -->
        <div class="p-4 sm:p-5 rounded-3xl bg-surface border border-primary/10 shadow-xs col-span-2 sm:col-span-1 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] sm:text-xs uppercase tracking-wider text-dark/50">Pesanan Selesai</span>
                <span class="p-1 rounded-xl bg-emerald-100 text-emerald-800 text-sm">✓</span>
            </div>
            <div class="mt-2.5">
                <span class="font-mono text-xl sm:text-2xl font-bold text-emerald-800">{{ $stats['completed_orders'] }}</span>
                <span class="text-[10px] sm:text-[11px] text-dark/60 block mt-0.5 font-mono truncate">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- 3. RECENT ORDERS SECTION (DUAL VIEW: MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-dark/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-heading text-base sm:text-lg font-bold text-dark flex items-center gap-2">
                    <span>Pesanan Terbaru (Buckflow ERP Sync)</span>
                </h3>
                <p class="text-[11px] sm:text-xs text-dark/60">Data transaksi buket dibaca langsung secara live dari basis data Buckflow ERP</p>
            </div>
            <a href="{{ $buckflowAppUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary/10 hover:bg-primary/20 text-primary font-mono text-xs font-semibold transition self-start sm:self-auto">
                <span>Kelola di Buckflow ERP ↗</span>
            </a>
        </div>

        <!-- 3A. MOBILE CARD VIEW (< md screens) -->
        <div class="block md:hidden p-4 space-y-3.5 bg-cream-light/30">
            @forelse ($recentOrders as $order)
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', (string) $order->customer_phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                    $waOrderMsg = urlencode("Halo {$order->customer_name}, kami dari Florist Maja Flower ingin mengonfirmasi pesanan buket Anda dengan nomor resi: {$order->tracking_code}.");
                    $itemSummary = $order->items->first()?->product?->name ?? 'Custom Bouquet';
                @endphp
                <div class="p-4 rounded-2xl bg-white border border-dark/10 shadow-xs space-y-3">
                    <!-- Top: Resi Code with 1-Tap Copy + Status Badge -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono font-bold text-xs text-primary">{{ $order->tracking_code }}</span>
                            <button
                                type="button"
                                @click="copyText('{{ $order->tracking_code }}', 'Nomor Resi')"
                                class="p-1 rounded-lg bg-cream hover:bg-cream-dark text-dark/60 hover:text-dark text-[10px] font-mono border border-dark/10"
                                title="Salin Kode Resi"
                            >
                                📋
                            </button>
                        </div>

                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono border font-semibold {{ $order->status_badge }}">
                            ● {{ $order->status_label }}
                        </span>
                    </div>

                    <!-- Bouquet & Price -->
                    <div class="flex items-baseline justify-between pt-1 border-t border-dark/5">
                        <span class="text-xs font-heading font-bold text-dark truncate">{{ $itemSummary }}</span>
                        <span class="font-mono text-xs font-bold text-primary">{{ $order->formatted_total_price }}</span>
                    </div>

                    <!-- Customer & Recipient Info -->
                    <div class="grid grid-cols-2 gap-2 text-[11px] p-2.5 rounded-xl bg-cream-light/60">
                        <div>
                            <span class="block text-[9px] font-mono text-dark/40 uppercase">Pemesan</span>
                            <span class="font-semibold text-dark truncate block">{{ $order->customer_name }}</span>
                            @if ($cleanPhone)
                                <a
                                    href="https://wa.me/{{ $cleanPhone }}?text={{ $waOrderMsg }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1 text-[10px] font-mono text-emerald-700 hover:underline font-bold mt-0.5"
                                >
                                    <span>💬 Chat WA</span>
                                </a>
                            @endif
                        </div>
                        <div>
                            <span class="block text-[9px] font-mono text-dark/40 uppercase">Target Deadline</span>
                            <span class="text-[10px] font-mono text-dark/70 block mt-1">
                                {{ $order->deadline_at ? $order->deadline_at->format('d/m H:i') : 'Sesuai kesepakatan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Link & Photo Indicator -->
                    <div class="flex items-center justify-between pt-1">
                        @if ($order->qc_photo_url)
                            <span class="inline-flex items-center gap-1 text-[10px] font-mono text-brand-indigo bg-brand-indigo/10 px-2 py-0.5 rounded-full font-semibold">
                                <span>📸</span>
                                <span>Foto QC Ada</span>
                            </span>
                        @else
                            <span class="text-[10px] font-mono text-dark/40 italic">Menunggu foto QC</span>
                        @endif

                        <a
                            href="{{ route('tracking.index', ['code' => $order->tracking_code]) }}"
                            target="_blank"
                            class="inline-flex items-center px-3 py-1.5 rounded-xl bg-primary text-cream hover:bg-primary-dark font-mono text-xs font-semibold shadow-xs transition"
                        >
                            Lacak Publik ↗
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-dark/40 font-mono text-xs">
                    Belum ada pesanan terbaru dari Buckflow ERP.
                </div>
            @endforelse
        </div>

        <!-- 3B. DESKTOP TABLE VIEW (>= md screens) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead class="bg-cream-light/60 font-mono text-[11px] uppercase tracking-wider text-dark/60 border-b border-dark/10">
                    <tr>
                        <th class="py-3 px-6">Resi / Tracking Code</th>
                        <th class="py-3 px-6">Pemesan & Kontak</th>
                        <th class="py-3 px-6">Rangkaian Bunga</th>
                        <th class="py-3 px-6">Target Selesai</th>
                        <th class="py-3 px-6">Total Nilai</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Lacak Publik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark/5">
                    @forelse ($recentOrders as $order)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', (string) $order->customer_phone);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waOrderMsg = urlencode("Halo {$order->customer_name}, kami dari Florist Maja Flower ingin mengonfirmasi pesanan buket Anda dengan nomor resi: {$order->tracking_code}.");
                            $itemSummary = $order->items->first()?->product?->name ?? 'Custom Bouquet';
                        @endphp
                        <tr class="hover:bg-cream/40 transition">
                            <td class="py-4 px-6 font-mono font-bold text-primary">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('tracking.index', ['code' => $order->tracking_code]) }}" target="_blank" class="hover:underline">
                                        {{ $order->tracking_code }}
                                    </a>
                                    <button
                                        type="button"
                                        @click="copyText('{{ $order->tracking_code }}', 'Nomor Resi')"
                                        class="p-1 rounded bg-cream hover:bg-cream-dark text-dark/60 hover:text-dark text-[10px]"
                                        title="Salin Resi"
                                    >
                                        📋
                                    </button>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-dark">{{ $order->customer_name }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-dark/50">{{ $order->customer_phone }}</span>
                                    @if ($cleanPhone)
                                        <a
                                            href="https://wa.me/{{ $cleanPhone }}?text={{ $waOrderMsg }}"
                                            target="_blank"
                                            class="text-emerald-700 hover:text-emerald-900 font-mono text-[10px] font-bold"
                                            title="Hubungi via WhatsApp"
                                        >
                                            💬 WA
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-dark font-medium">{{ $itemSummary }}</span>
                                @if ($order->items->count() > 1)
                                    <span class="block text-[10px] text-dark/50 font-mono">+{{ $order->items->count() - 1 }} item lainnya</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-mono text-dark/70">
                                {{ $order->deadline_at ? $order->deadline_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="py-4 px-6 font-mono font-semibold text-primary">
                                {{ $order->formatted_total_price }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-mono border {{ $order->status_badge }}">
                                    ● {{ $order->status_label }}
                                </span>
                                @if ($order->qc_photo_url)
                                    <span class="inline-block mt-1 text-[10px] font-mono text-brand-indigo bg-brand-indigo/10 px-1.5 py-0.5 rounded">
                                        Foto QC Ada
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a
                                    href="{{ route('tracking.index', ['code' => $order->tracking_code]) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl bg-primary text-cream hover:bg-primary-dark font-mono text-[11px] transition shadow-xs"
                                >
                                    Lacak Publik ↗
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-dark/40 font-mono">
                                Belum ada pesanan terbaru dari Buckflow ERP.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
