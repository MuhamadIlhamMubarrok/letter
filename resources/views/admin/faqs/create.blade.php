<x-layouts.admin title="Tambah FAQ Baru" header="Tambah Pertanyaan FAQ">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.faqs.index') }}" class="text-xs font-mono text-primary hover:underline flex items-center gap-1 mb-1">
                    <span>← Kembali ke Daftar FAQ</span>
                </a>
                <h1 class="font-heading text-2xl font-bold text-dark">Tambah Pertanyaan & Jawaban Baru</h1>
            </div>
        </div>

        <form action="{{ route('admin.faqs.store') }}" method="POST" class="p-6 sm:p-8 rounded-3xl bg-white border border-primary/20 shadow-xs space-y-6">
            @csrf

            <!-- Question -->
            <div>
                <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                    Pertanyaan Pelanggan <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="question"
                    value="{{ old('question') }}"
                    required
                    placeholder="Contoh: Apakah buket bunga segar bisa dikirim di hari yang sama (Sameday)?"
                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs sm:text-sm text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body"
                />
                @error('question')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Kategori Topik <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="category"
                        value="{{ old('category', 'Pengiriman & Sameday') }}"
                        list="categoryList"
                        required
                        placeholder="Pilih atau ketik kategori baru"
                        class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs text-dark focus:outline-none focus:border-primary font-mono"
                    />
                    <datalist id="categoryList">
                        <option value="Pengiriman & Sameday">
                        <option value="Pemesanan & Foto Approval">
                        <option value="Bunga Segar & Ketahanan">
                        <option value="Custom & Bespoke">
                        <option value="Garansi & Pembayaran">
                    </datalist>
                    @error('category')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                        Nomor Urutan Tampil
                    </label>
                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 1) }}"
                        min="0"
                        class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 px-4 py-3 text-xs text-dark focus:outline-none focus:border-primary font-mono"
                    />
                </div>
            </div>

            <!-- Answer -->
            <div>
                <label class="block text-xs font-semibold text-dark/80 font-mono mb-2">
                    Jawaban Lengkap <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="answer"
                    rows="5"
                    required
                    placeholder="Tuliskan jawaban yang ramah, informatif, dan meyakinkan pelanggan..."
                    class="w-full rounded-2xl bg-cream-light/60 border border-dark/15 p-4 text-xs sm:text-sm text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body leading-relaxed"
                >{{ old('answer') }}</textarea>
                @error('answer')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-cream-light/60 border border-dark/10">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    checked
                    class="w-4 h-4 text-primary rounded border-dark/20 focus:ring-primary"
                />
                <label for="is_active" class="text-xs text-dark font-medium cursor-pointer">
                    Langsung tayangkan pertanyaan ini pada website publik
                </label>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-dark/10 flex items-center justify-end gap-3">
                <a
                    href="{{ route('admin.faqs.index') }}"
                    class="px-5 py-2.5 rounded-2xl bg-cream-light hover:bg-cream text-dark border border-dark/15 text-xs font-mono font-medium transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-bold text-xs font-body shadow-md hover:shadow-lg transition cursor-pointer active:scale-95"
                >
                    Simpan FAQ
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
