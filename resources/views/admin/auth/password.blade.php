<x-layouts.admin title="Ganti Kata Sandi — Maja Flower">
    <x-slot:header>
        Keamanan Akun & Ganti Kata Sandi
    </x-slot:header>

    <div class="space-y-6 max-w-5xl mx-auto">
        <!-- Top Nav & Breadcrumbs -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-border-subtle">
            <div>
                <a href="{{ route('admin.digital-stories.index') }}" class="text-xs font-mono text-neutral-400 hover:text-cream flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Pipeline CMS</span>
                </a>
                <h1 class="font-heading text-xl sm:text-2xl font-bold text-cream tracking-tight mt-1 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-accent text-lg"></i>
                    <span>Keamanan Akun & Kata Sandi</span>
                </h1>
                <p class="text-xs text-neutral-400 mt-1 max-w-2xl">
                    Perbarui kata sandi akun operator secara berkala untuk menjaga keamanan data pesanan dan privasi client.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left: Form Ganti Password -->
            <div class="lg:col-span-7">
                <div
                    x-data="{
                        showCurrent: false,
                        showNew: false,
                        showConfirm: false
                    }"
                    class="bg-night-surface rounded-2xl border border-border-subtle shadow-xl p-6 sm:p-7 space-y-6"
                >
                    <!-- User Profile Preview Card -->
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-night-bg border border-border-subtle">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-primary to-secondary text-cream flex items-center justify-center font-bold font-mono text-base shadow-md shrink-0">
                            {{ strtoupper(substr($user->name ?? 'O', 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="font-heading text-sm sm:text-base font-bold text-cream truncate">{{ $user->name ?? 'Operator CMS' }}</h3>
                                <span class="px-2 py-0.5 rounded-full bg-primary/30 border border-primary/40 text-accent text-[10px] font-mono font-bold uppercase">{{ $user->role ?? 'Admin' }}</span>
                            </div>
                            <p class="font-mono text-xs text-neutral-400 truncate mt-0.5">{{ $user->email }}</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-xs space-y-1">
                            <div class="font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-triangle-exclamation text-rose-400"></i>
                                <span>Gagal memperbarui kata sandi:</span>
                            </div>
                            @foreach ($errors->all() as $error)
                                <p class="ml-4">• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- 1. Current Password -->
                        <div>
                            <label for="current_password" class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">
                                Kata Sandi Saat Ini <span class="text-rose-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    :type="showCurrent ? 'text' : 'password'"
                                    id="current_password"
                                    name="current_password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan kata sandi lama Anda"
                                    class="w-full px-4 py-2.5 pr-10 rounded-xl bg-night-bg border {{ $errors->has('current_password') ? 'border-rose-500' : 'border-border-subtle' }} text-xs text-cream focus:outline-none focus:border-primary transition"
                                />
                                <button
                                    type="button"
                                    @click="showCurrent = !showCurrent"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-cream text-xs p-1"
                                >
                                    <i class="fa-solid" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2. New Password -->
                        <div>
                            <label for="password" class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">
                                Kata Sandi Baru <span class="text-rose-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    :type="showNew ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Minimal 8 karakter kombinasi huruf & angka"
                                    class="w-full px-4 py-2.5 pr-10 rounded-xl bg-night-bg border {{ $errors->has('password') ? 'border-rose-500' : 'border-border-subtle' }} text-xs text-cream focus:outline-none focus:border-primary transition"
                                />
                                <button
                                    type="button"
                                    @click="showNew = !showNew"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-cream text-xs p-1"
                                >
                                    <i class="fa-solid" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-neutral-500 mt-1 font-mono">
                                Harus minimal 8 karakter, serta memiliki minimal 1 huruf dan 1 angka.
                            </p>
                        </div>

                        <!-- 3. Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">
                                Konfirmasi Kata Sandi Baru <span class="text-rose-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    :type="showConfirm ? 'text' : 'password'"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi kata sandi baru"
                                    class="w-full px-4 py-2.5 pr-10 rounded-xl bg-night-bg border {{ $errors->has('password_confirmation') ? 'border-rose-500' : 'border-border-subtle' }} text-xs text-cream focus:outline-none focus:border-primary transition"
                                />
                                <button
                                    type="button"
                                    @click="showConfirm = !showConfirm"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-cream text-xs p-1"
                                >
                                    <i class="fa-solid" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 flex items-center justify-between gap-3">
                            <a
                                href="{{ route('admin.digital-stories.index') }}"
                                class="px-5 py-2.5 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle font-mono text-xs font-semibold transition"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-primary/30 flex items-center gap-1.5 active:scale-95"
                            >
                                <i class="fa-solid fa-key text-xs"></i>
                                <span>Simpan Kata Sandi Baru</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Security Best Practices Card -->
            <div class="lg:col-span-5 space-y-4">
                <div class="p-6 rounded-2xl bg-night-surface border border-border-subtle shadow-xl space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-border-subtle">
                        <div class="w-8 h-8 rounded-lg bg-primary/30 text-accent border border-primary/40 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="font-heading text-sm font-bold text-cream">Standar Keamanan Kata Sandi</h3>
                            <p class="text-[11px] text-neutral-400">Panduan kata sandi kuat sistem</p>
                        </div>
                    </div>

                    <ul class="space-y-3 text-xs text-neutral-300">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-accent text-xs mt-0.5"></i>
                            <span><strong>Panjang Minimal:</strong> Setidaknya 8 karakter (disarankan 12 karakter atau lebih).</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-accent text-xs mt-0.5"></i>
                            <span><strong>Kombinasi Karakter:</strong> Wajib gabungan huruf (besar/kecil) dan angka.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-accent text-xs mt-0.5"></i>
                            <span><strong>Keunikan:</strong> Kata sandi baru tidak boleh sama dengan kata sandi lama.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-amber-400 text-xs mt-0.5"></i>
                            <span><strong>Hindari Pola Mudah:</strong> Jangan gunakan nama toko atau urutan angka berurutan.</span>
                        </li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-night-surface border border-border-subtle shadow-xl space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="font-mono text-xs font-bold uppercase tracking-wider text-accent">Proteksi Brute-Force Aktif</span>
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed">
                        Endpoint login dilindungi pembatasan rate limit otomatis (maksimal 5 percobaan per menit) untuk mencegah serangan kamus (brute-force).
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
