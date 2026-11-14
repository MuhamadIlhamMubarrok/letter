<x-layouts.admin title="Pengaturan Toko & Konten" header="Pengaturan Informasi Toko & Atelier">
    <!-- Header Overview -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-dark flex items-center gap-2.5">
                <span>⚙️ Pengaturan Konten & Informasi Toko</span>
            </h1>
            <p class="text-xs sm:text-sm text-dark/60 mt-1 max-w-2xl">
                Kelola semua data dinamis yang tampil di halaman publik: banner pengumuman topbar, nomor WhatsApp florist, jam operasional, alamat, tautan media sosial, serta statistik studio.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a
                href="{{ route('admin.password.edit') }}"
                class="px-4 py-2.5 rounded-2xl bg-white hover:bg-cream-light text-primary border border-primary/25 text-xs font-mono font-bold transition flex items-center gap-1.5 shadow-2xs"
            >
                <span>🔐 Ganti Password</span>
            </a>

            <a
                href="{{ route('home') }}"
                target="_blank"
                class="px-4 py-2.5 rounded-2xl bg-cream-light hover:bg-cream text-dark border border-dark/15 text-xs font-mono font-bold transition flex items-center gap-1.5"
            >
                <span>Lihat Tampilan Toko ↗</span>
            </a>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: 1. Topbar & Announcement + 2. Jam Operasional + 3. Hero Metrics -->
            <div class="lg:col-span-6 space-y-6">

                <!-- 1. TOPBAR ANNOUNCEMENT CARD -->
                <div class="p-6 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-dark/10">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl">📢</span>
                            <div>
                                <h3 class="font-heading text-base font-bold text-dark">Strip Pengumuman Topbar</h3>
                                <p class="text-[11px] text-dark/60">Banner berjalan di bagian paling atas halaman website</p>
                            </div>
                        </div>

                        <!-- Toggle Active -->
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="announcement_active"
                                value="1"
                                class="sr-only peer"
                                {{ ($settings['announcement_active']->value ?? '1') == '1' ? 'checked' : '' }}
                            />
                            <div class="w-11 h-6 bg-dark/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Teks Pengumuman (Header Announcement)</label>
                            <input
                                type="text"
                                name="announcement_text"
                                value="{{ old('announcement_text', $settings['announcement_text']->value ?? '') }}"
                                placeholder="Contoh: 🌸 SAMEDAY DELIVERY SE-JABODETABEK • LIVE PHOTO APPROVAL"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Link Tautan Pengumuman (Opsional)</label>
                            <input
                                type="url"
                                name="announcement_link"
                                value="{{ old('announcement_link', $settings['announcement_link']->value ?? '') }}"
                                placeholder="Contoh: https://wa.me/6285882119900"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-mono"
                            />
                        </div>
                    </div>
                </div>

                <!-- 2. JAM BUKA & OPERASIONAL CARD -->
                <div class="p-6 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-dark/10">
                        <span class="text-2xl">⏱️</span>
                        <div>
                            <h3 class="font-heading text-base font-bold text-dark">Jam Operasional & Status Atelier</h3>
                            <p class="text-[11px] text-dark/60">Tampil di announcement bar, navigasi, dan footer</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Jam Operasional Studio</label>
                            <input
                                type="text"
                                name="operating_hours"
                                value="{{ old('operating_hours', $settings['operating_hours']->value ?? '08:00 - 20:00 WIB (Buka Setiap Hari)') }}"
                                placeholder="Contoh: 08:00 - 20:00 WIB (Setiap Hari)"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Status Buka Live (Pill Status)</label>
                            <input
                                type="text"
                                name="operating_status_text"
                                value="{{ old('operating_status_text', $settings['operating_status_text']->value ?? 'Atelier Buka & Beroperasi Normal') }}"
                                placeholder="Contoh: Atelier Buka & Beroperasi Normal"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary"
                            />
                        </div>
                    </div>
                </div>

                <!-- 3. HERO TICKER & METRICS -->
                <div class="p-6 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-dark/10">
                        <span class="text-2xl">✨</span>
                        <div>
                            <h3 class="font-heading text-base font-bold text-dark">Hero Ticker & Statistik Studio</h3>
                            <p class="text-[11px] text-dark/60">Badge dan metrik bukti kualitas di beranda website</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Badge Ticker Hero</label>
                            <input
                                type="text"
                                name="hero_ticker_text"
                                value="{{ old('hero_ticker_text', $settings['hero_ticker_text']->value ?? 'ATELIER OPEN • KUOTA FRESH FLOWER TERBATAS') }}"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Metrik Buket Terkurasi</label>
                                <input
                                    type="text"
                                    name="hero_stat_curated"
                                    value="{{ old('hero_stat_curated', $settings['hero_stat_curated']->value ?? '12.4k+ Buket Terkurasi') }}"
                                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Metrik Rating & Ulasan</label>
                                <input
                                    type="text"
                                    name="hero_stat_rating"
                                    value="{{ old('hero_stat_rating', $settings['hero_stat_rating']->value ?? '★ 4.9/5 (1.8k+ Ulasan)') }}"
                                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                                />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: 4. WhatsApp & Kontak + 5. Media Sosial Resmi -->
            <div class="lg:col-span-6 space-y-6">

                <!-- 4. WHATSAPP & KONTAK CARD -->
                <div class="p-6 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-dark/10">
                        <span class="text-2xl">💬</span>
                        <div>
                            <h3 class="font-heading text-base font-bold text-dark">Kontak & WhatsApp Florist</h3>
                            <p class="text-[11px] text-dark/60">Tujuan konsultasi, pemesanan kustom, dan floating chat button</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">
                                Nomor WhatsApp Florist <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="whatsapp_number"
                                required
                                value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '6285882119900') }}"
                                placeholder="Gunakan kode negara tanpa spasi/tanda plus, contoh: 6285882119900"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                            <p class="text-[10px] text-dark/50 mt-1 font-mono">Format: 628xxx (digunakan di tombol WA, navbar, floating button, dan checkout)</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Template Pesan WhatsApp Default</label>
                            <textarea
                                name="whatsapp_default_message"
                                rows="2"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 p-3 text-xs text-dark font-body"
                            >{{ old('whatsapp_default_message', $settings['whatsapp_default_message']->value ?? 'Halo Florist Maja Flower, saya ingin berkonsultasi pemesanan buket no 1 di maja.') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Email Studio</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $settings['email']->value ?? 'florist@majaflower.com') }}"
                                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Link Google Maps</label>
                                <input
                                    type="url"
                                    name="google_maps_url"
                                    value="{{ old('google_maps_url', $settings['google_maps_url']->value ?? 'https://maps.google.com/?q=Jakarta+Selatan') }}"
                                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">Alamat Fisik Atelier</label>
                            <textarea
                                name="address"
                                rows="2"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 p-3 text-xs text-dark font-body"
                            >{{ old('address', $settings['address']->value ?? 'Jl. Maja Botanical No. 18, Kebayoran Baru, Jakarta Selatan, 12180') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. MEDIA SOSIAL RESMI CARD -->
                <div class="p-6 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-dark/10">
                        <span class="text-2xl">🌐</span>
                        <div>
                            <h3 class="font-heading text-base font-bold text-dark">Akun Media Sosial Resmi</h3>
                            <p class="text-[11px] text-dark/60">Tampil di footer website dan profil studio</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">URL Instagram (@maja.flwr)</label>
                            <input
                                type="url"
                                name="instagram_url"
                                value="{{ old('instagram_url', $settings['instagram_url']->value ?? 'https://www.instagram.com/maja.flwr/') }}"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">URL TikTok (@maja_flowers)</label>
                            <input
                                type="url"
                                name="tiktok_url"
                                value="{{ old('tiktok_url', $settings['tiktok_url']->value ?? 'https://www.tiktok.com/@maja_flowers') }}"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">URL Threads</label>
                            <input
                                type="url"
                                name="threads_url"
                                value="{{ old('threads_url', $settings['threads_url']->value ?? 'https://www.threads.com/@maja.flwr?hl=id') }}"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-dark/80 font-mono mb-1.5">URL Facebook</label>
                            <input
                                type="url"
                                name="facebook_url"
                                value="{{ old('facebook_url', $settings['facebook_url']->value ?? 'https://web.facebook.com/profile.php?id=61570779759134&locale=id_ID') }}"
                                class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sticky Save Action Bar -->
        <div class="sticky bottom-16 md:bottom-6 z-30 p-4 rounded-3xl bg-white/95 backdrop-blur-xl border-2 border-primary/20 shadow-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                <span class="text-xs font-mono text-dark/70">Perubahan akan langsung tayang pada seluruh halaman website</span>
            </div>

            <button
                type="submit"
                class="px-6 py-3 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-bold text-xs sm:text-sm font-body shadow-lg hover:shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2"
            >
                <span>💾 Simpan Perubahan Pengaturan</span>
            </button>
        </div>
    </form>
</x-layouts.admin>
