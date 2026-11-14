<x-layouts.admin title="Tambah Buket Baru" header="Tambah Buket Baru ke Katalog">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-xs font-mono text-dark/60 hover:text-primary transition flex items-center gap-1">
                ← Kembali ke Daftar Buket
            </a>
        </div>

        <div class="bg-surface rounded-3xl border border-primary/10 shadow-sm p-6 sm:p-10">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.input
                        label="Nama Buket Bunga"
                        name="name"
                        required
                        placeholder="Contoh: Scarlet Velvet Symphony"
                    />

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 font-mono">
                                Kategori Buket <span class="text-rose-600">*</span>
                            </label>
                            <a href="{{ route('admin.categories.create') }}" target="_blank" class="text-[11px] font-mono text-primary hover:underline font-bold" title="Buka form tambah kategori di tab baru">
                                + Kategori Baru ↗
                            </a>
                        </div>
                        <select
                            name="category_id"
                            id="category_id"
                            required
                            class="w-full rounded-xl border border-dark/15 bg-white/90 px-4 py-2.5 text-xs sm:text-sm text-dark focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 outline-none"
                        >
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Price and Dimensions -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.input
                        label="Harga Satuan (Rupiah)"
                        name="price"
                        type="number"
                        step="1000"
                        min="0"
                        required
                        mono="true"
                        placeholder="350000"
                        hint="Nominal angka tanpa titik/koma (Contoh: 350000)"
                    />

                    <x-ui.input
                        label="Dimensi Buket (Tinggi x Lebar)"
                        name="dimensions"
                        mono="true"
                        placeholder="45 x 30 cm"
                        value="45 x 30 cm"
                    />
                </div>

                <!-- Flower Composition -->
                <x-ui.input
                    label="Komposisi & Varietas Bunga Utama"
                    name="flower_composition"
                    placeholder="Contoh: Mawar Merah Holland (15 tangkai), Baby's Breath, Eucalyptus Cinerea"
                    hint="Varietas bunga yang ditampilkan pada kartu detail produk."
                />

                <!-- Description -->
                <x-ui.textarea
                    label="Deskripsi Lengkap Buket"
                    name="description"
                    rows="4"
                    required
                    placeholder="Ceritakan filosofi, keunikan rangkaian, dan rekomendasi momen yang cocok untuk buket ini..."
                />

                <!-- Multi-image Upload -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5 font-mono">
                        Unggah Foto Produk Buket (Bisa lebih dari 1)
                    </label>
                    <x-ui.file-upload
                        name="images"
                        :multiple="true"
                        hint="Format JPG, PNG, WEBP hingga 5MB per file."
                    />
                </div>

                <!-- Flags: Bestseller and Availability -->
                <div class="pt-4 border-t border-dark/10 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl bg-cream-light/60 border border-dark/10 cursor-pointer hover:border-primary transition">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="rounded accent-primary text-primary h-4 w-4">
                        <div>
                            <span class="text-xs font-semibold text-dark block">Jadikan Koleksi Bestseller</span>
                            <span class="text-[11px] text-dark/50">Tampilkan di etalase pilihan beranda utama.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3.5 rounded-2xl bg-cream-light/60 border border-dark/10 cursor-pointer hover:border-primary transition">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', '1') ? 'checked' : '' }} class="rounded accent-primary text-primary h-4 w-4">
                        <div>
                            <span class="text-xs font-semibold text-dark block">Buket Tersedia (Ready Stock)</span>
                            <span class="text-[11px] text-dark/50">Status langsung siap dirangkai di studio.</span>
                        </div>
                    </label>
                </div>

                <!-- Action Button -->
                <div class="pt-6 border-t border-dark/10 flex items-center justify-end gap-3">
                    <x-ui.button href="{{ route('admin.products.index') }}" variant="cream" size="md">
                        Batal
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary" size="md">
                        Simpan ke Katalog Buket
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
