<x-layouts.admin title="Edit Bunga Segar" header="Edit Spesimen Bunga Segar (Daily Cold Room)">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.fresh-flowers.index') }}" class="text-xs font-mono text-primary hover:underline flex items-center gap-1">
            <span>← Kembali ke Inventaris Bunga Segar</span>
        </a>
    </div>

    <div
        x-data="{
            name: '{{ old('name', addslashes($flower->name)) }}',
            botanical: '{{ old('botanical_name', addslashes($flower->botanical_name ?? '')) }}',
            origin: '{{ old('origin', addslashes($flower->origin ?? '')) }}',
            colorName: '{{ old('color_name', addslashes($flower->color_name)) }}',
            colorHex: '{{ old('color_hex', $flower->color_hex) }}',
            stock: {{ old('stock_stems', $flower->stock_stems) }},
            status: '{{ old('status', $flower->status) }}',
            price: '{{ old('price_per_stem', $flower->price_per_stem ?? '') }}',
            vaseLife: '{{ old('vase_life', addslashes($flower->vase_life ?? '')) }}',
            aroma: '{{ old('aroma_note', addslashes($flower->aroma_note ?? '')) }}',
            imagePreview: '{{ $flower->image_url }}',
            handleImage(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.imagePreview = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            statusLabel() {
                if (this.status === 'ready') return 'Ready Hari Ini';
                if (this.status === 'limited') return 'Sisa Sedikit';
                return 'Habis / Restock Besok';
            },
            statusBadgeClass() {
                if (this.status === 'ready') return 'bg-emerald-50 text-emerald-800 border-emerald-200';
                if (this.status === 'limited') return 'bg-amber-50 text-amber-800 border-amber-200';
                return 'bg-slate-100 text-slate-600 border-slate-200';
            },
            formatRupiah(val) {
                if (!val) return 'Konsultasi Florist';
                return 'Rp ' + Number(val).toLocaleString('id-ID') + ' / tangkai';
            }
        }"
        class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start"
    >
        <!-- Form Area (Left) -->
        <div class="lg:col-span-7 bg-surface rounded-3xl border border-primary/10 shadow-xs p-6 sm:p-8">
            <h3 class="font-heading text-lg font-bold text-dark mb-1">Perbarui Spesimen Bunga</h3>
            <p class="text-xs text-dark/60 mb-6">Ubah data bunga potong, kuota stok tangkai, atau ganti foto dokumentasi spesimen.</p>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.fresh-flowers.update', $flower->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Name & Botanical Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Nama Bunga <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            x-model="name"
                            required
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Nama Ilmiah / Botani (Opsional)
                        </label>
                        <input
                            type="text"
                            name="botanical_name"
                            x-model="botanical"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>
                </div>

                <!-- Origin & Farm -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Asal Perkebunan / Negara
                        </label>
                        <input
                            type="text"
                            name="origin"
                            x-model="origin"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Estimasi Harga / Tangkai (Rp)
                        </label>
                        <input
                            type="number"
                            name="price_per_stem"
                            x-model="price"
                            min="0"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>
                </div>

                <!-- Color Palette: Name and Hex Picker -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Nama Nuansa Warna <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="color_name"
                            x-model="colorName"
                            required
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Kode Hex Warna <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input
                                type="color"
                                name="color_hex_picker"
                                x-model="colorHex"
                                class="w-10 h-10 p-1 rounded-xl border border-dark/20 cursor-pointer bg-white"
                            >
                            <input
                                type="text"
                                name="color_hex"
                                x-model="colorHex"
                                required
                                class="flex-1 px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs font-mono focus:outline-none focus:border-primary uppercase"
                            >
                        </div>
                    </div>
                </div>

                <!-- Stock Count & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Jumlah Tangkai Ready <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="stock_stems"
                            x-model.number="stock"
                            required
                            min="0"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-mono font-bold"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Status Ketersediaan <span class="text-rose-500">*</span>
                        </label>
                        <select
                            name="status"
                            x-model="status"
                            required
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                            <option value="ready">Ready Hari Ini</option>
                            <option value="limited">Sisa Sedikit / Limited Stock</option>
                            <option value="sold_out">Habis / Restock Besok</option>
                        </select>
                    </div>
                </div>

                <!-- Vase Life & Aroma Note -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Daya Tahan di Vas (Vase Life)
                        </label>
                        <input
                            type="text"
                            name="vase_life"
                            x-model="vaseLife"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                            Karakteristik Aroma (Aroma Note)
                        </label>
                        <input
                            type="text"
                            name="aroma_note"
                            x-model="aroma"
                            class="w-full px-4 py-2.5 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body"
                        >
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                        Catatan Florist & Karakteristik Bunga
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full px-4 py-3 rounded-2xl bg-cream-light/60 border border-dark/15 text-xs focus:outline-none focus:border-primary font-body resize-y"
                    >{{ old('description', $flower->description) }}</textarea>
                </div>

                <!-- Current & New Image -->
                <div>
                    <label class="block font-mono text-[11px] uppercase tracking-wider text-dark/70 mb-1.5 font-semibold">
                        Ganti Foto Spesimen Bunga (Opsional)
                    </label>
                    <div class="flex items-center gap-4 mb-2">
                        <img src="{{ $flower->image_url }}" alt="Foto Lama" class="w-16 h-16 object-cover rounded-2xl border border-dark/15">
                        <span class="text-[11px] text-dark/60 font-mono">Foto saat ini digunakan jika tidak mengunggah file baru.</span>
                    </div>
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        @change="handleImage"
                        class="w-full text-xs text-dark/60 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-mono file:font-semibold file:bg-primary file:text-cream hover:file:bg-primary-dark cursor-pointer"
                    >
                </div>

                <!-- Visibility & Sort Order -->
                <div class="pt-2 border-t border-dark/10 flex flex-wrap items-center justify-between gap-4">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $flower->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-primary focus:ring-primary border-dark/20"
                        >
                        <span class="text-xs font-medium text-dark">Tampilkan di Beranda (Homepage)</span>
                    </label>

                    <div class="flex items-center gap-2">
                        <label class="font-mono text-[11px] text-dark/60">Urutan Tampil:</label>
                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $flower->sort_order) }}"
                            min="0"
                            class="w-16 px-2.5 py-1 rounded-xl border border-dark/20 text-xs font-mono text-center"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex items-center gap-3">
                    <x-ui.button type="submit" variant="primary" size="lg" class="flex-1 shadow-md">
                        <span>Perbarui Data Bunga Segar</span>
                        <span class="ml-2">✓</span>
                    </x-ui.button>

                    <a href="{{ route('admin.fresh-flowers.index') }}" class="px-5 py-3 rounded-full bg-cream hover:bg-cream-dark text-dark border border-dark/15 font-mono text-xs font-semibold transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Live Specimen Card Preview (Right) -->
        <div class="lg:col-span-5 sticky top-8 space-y-4">
            <div class="flex items-center justify-between">
                <span class="font-mono text-xs uppercase tracking-wider text-secondary-dark font-semibold">
                    Live Preview di Beranda
                </span>
                <span class="text-[11px] font-mono text-dark/50">Tampilan Cold Room Vault</span>
            </div>

            <!-- Botanical Specimen Card -->
            <div class="bg-surface dark:bg-night-card rounded-3xl border border-primary/15 dark:border-night-border shadow-xl p-5 overflow-hidden transition-all duration-300">
                <!-- Status Badge Header -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span
                            class="w-3.5 h-3.5 rounded-full border border-dark/15 shadow-xs"
                            :style="'background-color: ' + colorHex"
                        ></span>
                        <span class="text-[11px] font-mono text-dark/70 dark:text-cream/70 font-semibold" x-text="colorName"></span>
                    </div>

                    <span
                        class="px-2.5 py-1 rounded-full text-[10px] font-mono border font-semibold flex items-center gap-1.5"
                        :class="statusBadgeClass()"
                    >
                        <span
                            class="w-2 h-2 rounded-full"
                            :class="status === 'ready' ? 'bg-emerald-500' : (status === 'limited' ? 'bg-amber-500 animate-pulse' : 'bg-slate-400')"
                        ></span>
                        <span x-text="statusLabel()"></span>
                    </span>
                </div>

                <!-- Specimen Image Frame -->
                <div class="relative rounded-2xl overflow-hidden aspect-square mb-4 bg-cream-dark/20 shadow-inner group">
                    <img
                        :src="imagePreview"
                        :alt="name"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    >
                    <div class="absolute bottom-2.5 left-2.5 px-3 py-1 rounded-full bg-dark/70 backdrop-blur-md text-cream text-[10px] font-mono">
                        <span x-text="'📍 ' + origin"></span>
                    </div>
                </div>

                <!-- Botanical Meta -->
                <div class="space-y-1.5">
                    <span class="font-serif italic text-xs text-secondary-dark dark:text-accent block" x-text="botanical"></span>
                    <h4 class="font-heading text-lg font-bold text-dark dark:text-cream leading-tight" x-text="name"></h4>

                    <!-- Specs Pill Matrix -->
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <div class="p-2.5 rounded-xl bg-cream-light/60 dark:bg-white/5 border border-dark/5 dark:border-white/5">
                            <span class="block text-[9px] font-mono text-dark/40 dark:text-cream/40 uppercase">Stok Siap Rangkai</span>
                            <span class="font-mono text-xs font-bold text-primary dark:text-accent" x-text="stock + ' Tangkai Ready'"></span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-cream-light/60 dark:bg-white/5 border border-dark/5 dark:border-white/5">
                            <span class="block text-[9px] font-mono text-dark/40 dark:text-cream/40 uppercase">Vase Life (Ketahanan)</span>
                            <span class="font-mono text-xs font-semibold text-dark/80 dark:text-cream/80" x-text="'⏳ ' + vaseLife"></span>
                        </div>
                    </div>

                    <!-- Aroma & Price -->
                    <div class="pt-2 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-dark/70 dark:text-cream/70 italic" x-text="'🌸 ' + aroma"></span>
                        <span class="font-mono font-bold text-primary dark:text-accent text-sm" x-text="formatRupiah(price)"></span>
                    </div>

                    <!-- Action Button Preview -->
                    <div class="pt-3">
                        <div class="w-full py-2.5 rounded-xl bg-primary/10 text-primary text-center font-mono text-xs font-semibold border border-primary/20">
                            Pesan Buket Bunga Ini via WhatsApp →
                        </div>
                    </div>
                </div>
            </div>

            <!-- Atelier Cold Room Info Tip -->
            <div class="p-4 rounded-2xl bg-surface/70 border border-dark/10 text-xs text-dark/60 space-y-1">
                <span class="font-mono font-semibold text-primary block">💡 Status Stok:</span>
                <p>Status 'Ready Hari Ini', 'Sisa Sedikit', dan kuota tangkai akan langsung diperbarui di board homepage setelah formulir ini disimpan.</p>
            </div>
        </div>
    </div>
</x-layouts.admin>
