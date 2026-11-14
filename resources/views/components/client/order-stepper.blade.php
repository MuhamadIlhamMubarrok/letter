@php
    $isEn = app()->getLocale() === 'en';
    $steps = [
        [
            'number' => '01',
            'badge' => $isEn ? 'CONSULTATION & CONCEPT' : 'KONSULTASI & KONSEP',
            'title' => $isEn ? 'Consultation & Concept Ideation' : 'Konsultasi & Penentuan Konsep',
            'desc' => $isEn
                ? 'Share your event needs, reference photos, color tones, and primary flower type (fresh, artificial, or dried flowers).'
                : 'Konsultasikan ide buket impian Anda bersama florist profesional Maja Flower.',
            'items' => $isEn
                ? [
                    'Moment / Event: Birthday, graduation, anniversary, proposal, or sweet surprise.',
                    'Style & Mood: Send photo references or desired flower & color combinations.',
                    'Flower Variety: Fresh cut flowers (limited daily quota), high-grade artificial, or preserved dried flowers.',
                ]
                : [
                    'Momen / Acara: Ulang tahun, kelulusan, anniversary, atau sekadar kejutan.',
                    'Gaya & Nuansa: Kirimkan referensi foto atau kombinasi warna/bunga favorit.',
                    'Jenis Bunga: Pilih bunga segar (kuota harian terbatas), artificial/palsu premium, atau dried flowers.',
                ],
            'icon' => 'concept',
        ],
        [
            'number' => '02',
            'badge' => $isEn ? 'BUDGET & SIZE' : 'BUDGET & UKURAN',
            'title' => $isEn ? 'Budget Determination & Size Options' : 'Penentuan Budget & Spesifikasi Ukuran',
            'desc' => $isEn
                ? 'Provide your estimated budget. We will offer size alternatives and suitable flower combinations.'
                : 'Sampaikan estimasi anggaran Anda. Kami sediakan opsi ukuran dan paduan bunga terbaik.',
            'items' => $isEn
                ? [
                    'Flexible Budget: Crafted to maximize visual volume and botanical balance.',
                    'Size Selection: Small (Petite), Medium (Editorial Standard), or Large (Big Size).',
                ]
                : [
                    'Budget Fleksibel: Sampaikan estimasi budget yang ingin Anda alokasikan.',
                    'Pilihan Ukuran: Tersedia opsi ukuran Small, Medium, atau Large (Big Size).',
                    'Rekomendasi Bunga: Kami rekomendasikan komposisi bunga yang paling pas.',
                ],
            'icon' => 'budget',
        ],
        [
            'number' => '03',
            'badge' => $isEn ? 'DETAIL & RECAP' : 'DETAIL & REKAP',
            'title' => $isEn ? 'Greeting Card & Order Form' : 'Kartu Ucapan & Rincian Pesanan (Order Form)',
            'desc' => $isEn
                ? 'We record recipient information, delivery schedule, and heartfelt message card notes.'
                : 'Pencatatan rincian pengiriman, ucapan personal, serta rekapitulasi invoice pesanan.',
            'items' => $isEn
                ? [
                    'Recipient Details: Address, recipient contact, and desired delivery slot.',
                    'Heartfelt Message Card: Free printed textured card with poetic or custom typography.',
                    'Order Form Recap: Clear breakdown of items and total cost for your approval.',
                ]
                : [
                    'Data Penerima: Detail penerima, alamat pengiriman, dan tanggal/jam sampai.',
                    'Kartu Ucapan: Kami cetak pesan tulus Anda di kartu bertekstur elegan.',
                    'Rincian Pesanan: Order form lengkap beserta total biaya untuk Anda tinjau & setujui.',
                ],
            'icon' => 'recap',
        ],
        [
            'number' => '04',
            'badge' => $isEn ? 'DOWN PAYMENT' : 'DOWN PAYMENT',
            'title' => $isEn ? 'Down Payment (DP) Confirmation' : 'Pembayaran Uang Muka (DP)',
            'desc' => $isEn
                ? 'Confirm your order by submitting a down payment to lock atelier crafting schedule and stem allocation.'
                : 'Pembayaran DP untuk mengunci jadwal pengerjaan dan alokasi bunga segar yang terbatas.',
            'items' => $isEn
                ? [
                    'Slot Guarantee: Secures dedicated florist crafting time in our daily studio slots.',
                    'Stem Allocation: Reserves limited fresh stems specifically for your custom arrangement.',
                ]
                : [
                    'Kunci Slot Rangkai: Mengamankan antrean pengerjaan di studio Maja Flower.',
                    'Alokasi Bunga Segar: Menjaga ketersediaan tangkai bunga segar yang kuotanya terbatas.',
                ],
            'icon' => 'payment',
        ],
        [
            'number' => '05',
            'badge' => $isEn ? 'CRAFTING & PREVIEW' : 'PROSES RANGKAI & PREVIEW',
            'title' => $isEn ? 'Artisan Crafting & Photo/Video Preview' : 'Proses Merangkai & Foto Konfirmasi Preview',
            'desc' => $isEn
                ? 'Our florists carefully arrange the bouquet and provide preview photos/videos before delivery.'
                : 'Florist merangkai sesuai konsep dan mengirimkan foto preview resolusi tinggi.',
            'items' => $isEn
                ? [
                    'Artisan Arranging: Handcrafted with botanical precision according to agreed brief.',
                    'High-Res Preview: Photo/video sent directly to you to ensure all details are perfect.',
                ]
                : [
                    'Proses Rangkai: Perangkai kami mulai merangkai sesuai konsep yang disepakati.',
                    'Foto/Video Preview: Hasil akhir difoto & dikonfirmasi sebelum dikirim/diambil.',
                ],
            'icon' => 'preview',
        ],
        [
            'number' => '06',
            'badge' => $isEn ? 'FINAL PAYMENT' : 'PELUNASAN SISA',
            'title' => $isEn ? 'Final Balance Settlement' : 'Pelunasan Sisa Pembayaran',
            'desc' => $isEn
                ? 'Settle the remaining payment balance once the preview photos have received your full approval.'
                : 'Pelunasan sisa tagihan setelah foto preview hasil rangkaian disetujui.',
            'items' => $isEn
                ? [
                    'Zero-Surprise: You pay the remainder only after approving the preview.',
                    'Hand-off Readiness: Order is instantly routed for packing and departure.',
                ]
                : [
                    'Approval First: Pelunasan dilakukan setelah Anda menyetujui foto preview.',
                    'Siap Kirim: Buket langsung diproses untuk serah terima atau dijemput kurir.',
                ],
            'icon' => 'settlement',
        ],
        [
            'number' => '07',
            'badge' => $isEn ? 'DISPATCH / PICK-UP' : 'PENGIRIMAN / AMBIL',
            'title' => $isEn ? 'Safe Delivery / Self Pick-up' : 'Pengiriman / Serah Terima',
            'desc' => $isEn
                ? 'Choose express instant courier with protective packaging or pick up directly at our studio.'
                : 'Pengiriman via kurir instan terlindung atau pengambilan mandiri langsung di studio.',
            'items' => $isEn
                ? [
                    'Instant Courier: Hydrated protective packaging delivered on schedule.',
                    'Self Pick-up: Convenient pickup at Maja Flower Studio at agreed timing.',
                ]
                : [
                    'Pengiriman Kurir: Buket lunas dipacking aman lalu dikirim via kurir instan.',
                    'Self Pick-up: Buket siap diambil langsung di studio sesuai jam kesepakatan.',
                ],
            'icon' => 'delivery',
        ],
    ];
@endphp

<div class="space-y-8">
    <!-- Responsive 7 Steps Flow Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach ($steps as $idx => $step)
            <div
                class="group relative flex flex-col justify-between p-5 sm:p-6 rounded-3xl bg-surface/90 dark:bg-night-card border border-primary/15 dark:border-night-border shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 {{ $idx === 6 ? 'md:col-span-2 lg:col-span-1 xl:col-span-1' : '' }}">
                <div>
                    <!-- Card Top Header: Step Number & Icon -->
                    <div class="flex items-center justify-between mb-3.5">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-mono text-2xl font-extrabold text-primary dark:text-accent tracking-tighter">
                                {{ $step['number'] }}
                            </span>
                            <span
                                class="text-[9px] font-mono px-2 py-0.5 rounded-full bg-cream-dark/60 dark:bg-night-surface text-secondary-dark dark:text-accent border border-primary/10 dark:border-night-border uppercase font-bold tracking-wider">
                                {{ $step['badge'] }}
                            </span>
                        </div>
                        <div
                            class="w-10 h-10 rounded-2xl bg-cream dark:bg-night-surface flex items-center justify-center text-primary dark:text-accent group-hover:bg-primary group-hover:text-cream dark:group-hover:bg-accent dark:group-hover:text-night-bg transition-colors duration-300 shrink-0">
                            @if ($step['icon'] === 'concept')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            @elseif ($step['icon'] === 'budget')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            @elseif ($step['icon'] === 'recap')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif ($step['icon'] === 'payment')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            @elseif ($step['icon'] === 'preview')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <circle cx="12" cy="13" r="3" stroke-width="1.8" />
                                </svg>
                            @elseif ($step['icon'] === 'settlement')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Step Title -->
                    <h4
                        class="font-heading text-base font-bold text-dark dark:text-cream group-hover:text-primary dark:group-hover:text-accent transition-colors leading-snug">
                        {{ $step['title'] }}
                    </h4>

                    <!-- Bullet Points of Requirements -->
                    <ul class="mt-3 space-y-1.5 text-[11px] text-dark/75 dark:text-cream/80 font-body">
                        @foreach ($step['items'] as $item)
                            <li class="flex items-start gap-1.5 leading-relaxed">
                                <span class="text-primary dark:text-accent font-bold mt-0.5 shrink-0">•</span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Footer Indicator -->
                <div
                    class="mt-4 pt-2.5 border-t border-dark/10 dark:border-night-border flex items-center justify-between text-[10px] font-mono text-dark/40 dark:text-cream/40">
                    <span>Tahap {{ $step['number'] }} dari 07</span>
                    <span
                        class="text-primary dark:text-accent font-serif group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Live Tracking / Cek Resi Buket Status Callout -->
    <div
        class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-primary/10 via-accent/15 to-secondary/15 dark:from-primary/20 dark:via-night-card dark:to-accent/10 border-2 border-primary/25 dark:border-accent/30 shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div
                class="w-14 h-14 rounded-2xl bg-primary text-cream flex items-center justify-center shrink-0 shadow-md">
                <span class="text-2xl">📦</span>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-mono text-xs uppercase tracking-wider text-primary dark:text-accent font-bold">
                        Live Tracking & Status Pengerjaan
                    </span>
                </div>
                <h4 class="font-heading text-lg sm:text-xl font-bold text-dark dark:text-cream">
                    Status Pengerjaan Bisa Dilihat di Halaman Cek Resi Buket
                </h4>
                <p class="text-xs text-dark/70 dark:text-cream/70 font-body mt-0.5 max-w-xl">
                    Pantau progress pesanan Anda secara transparan dari proses perangkaian, foto konfirmasi preview,
                    hingga serah terima kurir secara real-time.
                </p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 shrink-0 w-full md:w-auto">
            <x-ui.button href="{{ route('tracking.index') }}" variant="primary" size="md"
                class="w-full sm:w-auto shadow-md">
                <span>Cek Resi Buket Sekarang</span>
                <span class="ml-1.5 font-serif">→</span>
            </x-ui.button>
            <x-ui.button
                href="https://wa.me/{{ setting('whatsapp_number', '6285882119900') }}?text={{ urlencode('Halo Florist Maja Flower (Buket No 1 di Maja), saya ingin berkonsultasi mengenai custom buket.') }}"
                variant="outline" size="md" target="_blank" class="w-full sm:w-auto">
                <span>Konsultasi WA</span>
            </x-ui.button>
        </div>
    </div>
</div>
