<x-layouts.admin title="Tambah Filosofi Bunga" header="Tambah Filosofi Bunga">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.philosophies.index') }}" class="text-xs font-mono text-primary hover:underline flex items-center gap-1 mb-1">
                    <span>← Kembali ke Daftar Filosofi</span>
                </a>
                <h1 class="font-heading text-2xl font-bold text-dark">Tambah Filosofi & Makna Bunga Baru</h1>
            </div>
        </div>

        <form action="{{ route('admin.philosophies.store') }}" method="POST" class="p-6 sm:p-8 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                <!-- Emoji or Icon -->
                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Ikon / Emoji <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="emoji_or_icon"
                        value="{{ old('emoji_or_icon', '🌹') }}"
                        required
                        placeholder="Contoh: 🌹, 🌻, 🪷"
                        class="w-full text-center text-xl rounded-2xl bg-cream-light/60 border border-dark/15 px-3 py-2.5 text-dark focus:outline-none focus:border-primary font-mono"
                    />
                    @error('emoji_or_icon')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Flower Name -->
                <div class="sm:col-span-5">
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Nama Bunga <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="flower_name"
                        value="{{ old('flower_name') }}"
                        required
                        placeholder="Contoh: Red Holland Rose"
                        class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs sm:text-sm text-dark focus:outline-none focus:border-primary font-body"
                    />
                    @error('flower_name')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Scientific Name -->
                <div class="sm:col-span-4">
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Nama Latin / Ilmiah
                    </label>
                    <input
                        type="text"
                        name="scientific_name"
                        value="{{ old('scientific_name') }}"
                        placeholder="Contoh: Rosa hybrida"
                        class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs text-dark focus:outline-none focus:border-primary font-mono italic"
                    />
                </div>
            </div>

            <!-- Meaning -->
            <div>
                <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                    Makna & Filosofi Utama <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="meaning"
                    value="{{ old('meaning') }}"
                    required
                    placeholder="Contoh: Cinta Sejati, Hasrat & Keberanian"
                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs sm:text-sm text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body font-semibold"
                />
                @error('meaning')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                    Penjelasan Naratif Filosofi <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="description"
                    rows="4"
                    required
                    placeholder="Ceritakan filosofi keindahan dan pesan emosional di balik bunga ini..."
                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 p-4 text-xs sm:text-sm text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body leading-relaxed"
                >{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Nomor Urutan Tampil
                    </label>
                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 1) }}"
                        min="0"
                        class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-2.5 text-xs text-dark font-mono"
                    />
                </div>

                <div class="flex items-center">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-cream-light/60 border border-dark/10 w-full mt-2 sm:mt-5">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            checked
                            class="w-4 h-4 text-primary rounded border-dark/20 focus:ring-primary"
                        />
                        <label for="is_active" class="text-xs text-dark font-medium cursor-pointer">
                            Tayangkan di seksi Filosofi beranda
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-dark/10 flex items-center justify-end gap-3">
                <a
                    href="{{ route('admin.philosophies.index') }}"
                    class="px-5 py-2.5 rounded-2xl bg-cream-light hover:bg-cream text-dark border border-dark/15 text-xs font-mono font-medium transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-bold text-xs font-body shadow-md hover:shadow-lg transition cursor-pointer active:scale-95"
                >
                    Simpan Filosofi Bunga
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
