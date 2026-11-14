<x-layouts.admin title="Edit Cerita Pelanggan" header="Edit Cerita Pelanggan">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.stories.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-primary hover:text-primary-dark transition font-mono">
            <span>← Kembali ke Daftar Cerita</span>
        </a>
    </div>

    <div
        x-data="{
            name: '{{ old('customer_name', addslashes($story->customer_name)) }}',
            event: '{{ old('event_title', addslashes($story->event_title)) }}',
            story: `{{ old('story', addslashes($story->story)) }}`,
            rating: {{ old('rating', $story->rating) }},
            previewImage: '{{ $story->image_url }}'
        }"
        class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start"
    >
        <!-- Form Column (Left) -->
        <div class="lg:col-span-7 bg-surface p-6 sm:p-8 rounded-3xl border border-primary/10 shadow-xs">
            <h3 class="font-heading text-lg font-bold text-dark mb-1">Edit Cerita Pelanggan: {{ $story->customer_name }}</h3>
            <p class="text-xs text-dark/60 font-body mb-6">Perbarui detail cerita, ulasan bintang, atau foto polaroid untuk momen berharga ini.</p>

            <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Customer Name -->
                <div>
                    <label for="customer_name" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                        Nama Pelanggan / Pasangan <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_name"
                        id="customer_name"
                        required
                        x-model="name"
                        value="{{ old('customer_name', $story->customer_name) }}"
                        placeholder="Contoh: Clara & Rangga atau Kevin Pratama"
                        class="w-full bg-cream-light/60 border border-dark/15 rounded-xl px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body @error('customer_name') border-rose-500 @enderror"
                    />
                    @error('customer_name')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event / Occasion Title -->
                <div>
                    <label for="event_title" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                        Momen / Nama Acara <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="event_title"
                        id="event_title"
                        required
                        x-model="event"
                        value="{{ old('event_title', $story->event_title) }}"
                        placeholder="Contoh: Wisuda UI, Anniversary 4th, Graduation ITB"
                        class="w-full bg-cream-light/60 border border-dark/15 rounded-xl px-4 py-2.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body @error('event_title') border-rose-500 @enderror"
                    />
                    @error('event_title')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating & Sort Order Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Rating -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                            Rating Kepuasan <span class="text-rose-600">*</span>
                        </label>
                        <div class="flex items-center gap-2 pt-1">
                            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                <button
                                    type="button"
                                    @click="rating = star"
                                    class="text-2xl transition cursor-pointer"
                                    :class="star <= rating ? 'text-amber-400 scale-110' : 'text-dark/20 hover:text-amber-300'"
                                >
                                    ★
                                </button>
                            </template>
                            <span class="font-mono text-xs font-semibold text-dark/70 ml-2" x-text="rating + ' Bintang'"></span>
                        </div>
                        <input type="hidden" name="rating" :value="rating" />
                        @error('rating')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                            Urutan Tampil (Prioritas)
                        </label>
                        <input
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            value="{{ old('sort_order', $story->sort_order) }}"
                            min="0"
                            class="w-full bg-cream-light/60 border border-dark/15 rounded-xl px-4 py-2 text-xs text-dark focus:outline-none focus:border-primary font-mono @error('sort_order') border-rose-500 @enderror"
                        />
                        <span class="text-[10px] text-dark/40 font-mono mt-1 block">Angka lebih kecil tampil lebih awal</span>
                        @error('sort_order')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Photo Upload with Preview -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                        Foto Polaroid Buket Pelanggan
                    </label>
                    <div class="relative border-2 border-dashed border-primary/30 hover:border-primary rounded-2xl bg-white/60 p-5 text-center transition duration-200">
                        <input
                            type="file"
                            name="image"
                            id="story_image"
                            accept="image/*"
                            @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    previewImage = URL.createObjectURL(file);
                                }
                            "
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        />
                        <div class="flex flex-col items-center gap-2">
                            <img :src="previewImage" alt="Preview" class="h-32 w-32 object-cover rounded-xl shadow-md border border-cream-dark" />
                            <span class="text-xs text-primary font-medium">Klik atau seret file gambar baru untuk mengganti foto</span>
                            <span class="text-[10px] text-dark/40">Format: JPG, PNG, WEBP hingga 10MB</span>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Story Textarea -->
                <div>
                    <label for="story" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
                        Kisah / Isi Ulasan Testimoni Pelanggan <span class="text-rose-600">*</span>
                    </label>
                    <textarea
                        name="story"
                        id="story"
                        rows="4"
                        required
                        x-model="story"
                        placeholder="Contoh: Buket bunganya wangi sekali dan wrapping-nya sangat rapi..."
                        class="w-full bg-cream-light/60 border border-dark/15 rounded-xl px-4 py-3 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body leading-relaxed @error('story') border-rose-500 @enderror"
                    >{{ old('story', $story->story) }}</textarea>
                    @error('story')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Published Toggle -->
                <div class="pt-2 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="is_published"
                        id="is_published"
                        value="1"
                        {{ old('is_published', $story->is_published) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-dark/20 text-primary focus:ring-primary cursor-pointer"
                    />
                    <label for="is_published" class="text-xs font-medium text-dark cursor-pointer">
                        Tampilkan di halaman utama website (Status Aktif)
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex items-center gap-3">
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-xl bg-primary text-cream font-semibold text-xs hover:bg-primary-dark transition shadow-md cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.stories.index') }}" class="px-5 py-2.5 rounded-xl bg-dark/5 hover:bg-dark/10 text-dark font-medium text-xs transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Live Preview Polaroid Card (Right Column) -->
        <div class="lg:col-span-5 sticky top-28">
            <div class="p-6 rounded-3xl bg-cream-light/80 border border-primary/20 shadow-sm">
                <span class="text-[10px] font-mono uppercase tracking-wider text-dark/50 block mb-3 font-semibold">
                    Live Preview Polaroid di Halaman Depan:
                </span>

                <div class="bg-surface p-4 pb-6 rounded-2xl shadow-xl border border-dark/10 rotate-[-1.5deg] max-w-sm mx-auto">
                    <!-- Polaroid Image -->
                    <div class="w-full aspect-square bg-cream-light rounded-xl overflow-hidden mb-4 border border-dark/10 flex items-center justify-center">
                        <img :src="previewImage" alt="Preview Polaroid" class="w-full h-full object-cover" />
                    </div>

                    <!-- Stars -->
                    <div class="flex items-center text-amber-400 text-xs mb-2">
                        <template x-for="i in 5" :key="i">
                            <span x-text="i <= rating ? '★' : '☆'" :class="i <= rating ? 'text-amber-400' : 'text-dark/20'"></span>
                        </template>
                    </div>

                    <!-- Quote -->
                    <p class="font-body text-xs text-dark/80 italic leading-relaxed" x-text="story ? '&quot;' + story + '&quot;' : '&quot;Kisah dan pengalaman manis pelanggan Maja Flower akan ditampilkan di sini...&quot;'"></p>

                    <!-- Footer of polaroid -->
                    <div class="mt-3 pt-3 border-t border-dark/10 flex items-center justify-between">
                        <span class="font-heading text-sm font-bold text-primary" x-text="name || 'Nama Pelanggan'"></span>
                        <span class="font-mono text-[10px] text-dark/50" x-text="event || 'Momen Acara'"></span>
                    </div>
                </div>

                <p class="text-[11px] text-dark/50 font-mono text-center mt-4">
                    💡 Efek kemiringan polaroid dan bayangan akan menyesuaikan secara otomatis di halaman utama.
                </p>
            </div>
        </div>
    </div>
</x-layouts.admin>
