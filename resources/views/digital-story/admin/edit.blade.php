<x-layouts.admin title="Edit Pesanan Surat & Undangan — Maja Flower">
    <x-slot:header>
        Edit & Tindak Lanjut Pesanan CMS
    </x-slot:header>

    <div
        x-data="{
            storyType: '{{ old('story_type', $story->story_type->value) }}',
            selectedTemplate: '{{ old('template_key', $story->template_key?->value ?? ($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION ? 'online_wedding' : 'online_love_letter')) }}'
        }"
        class="space-y-6 max-w-5xl mx-auto"
    >
        <!-- Top Nav & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-border-subtle">
            <div>
                <a href="{{ route('admin.digital-stories.index') }}" class="text-xs font-mono text-neutral-400 hover:text-cream flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Pipeline CMS</span>
                </a>
                <h1 class="font-heading text-xl sm:text-2xl font-bold text-cream tracking-tight mt-1">
                    Edit & Tindak Lanjut: {{ $story->title }}
                </h1>
                <div class="flex items-center gap-2 mt-1">
                    @if($story->order_code)
                        <span class="px-2.5 py-0.5 rounded-md bg-primary/30 border border-primary/40 text-accent font-mono text-xs font-bold">
                            {{ $story->order_code }}
                        </span>
                    @endif
                    <span class="font-mono text-xs text-neutral-400">/s/{{ $story->slug }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('admin.digital-stories.guests', $story) }}"
                    class="px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 border border-emerald-700/60 font-mono text-xs font-bold transition shadow-sm flex items-center gap-1.5"
                    title="Generator Link Tamu Undangan Personal"
                >
                    <i class="fa-solid fa-users-viewfinder text-emerald-400"></i>
                    <span>Tamu Personal</span>
                </a>
                @if($story->customer_phone)
                    <a
                        href="{{ $story->getWhatsAppFollowUpUrl() }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 border border-emerald-700/60 font-mono text-xs font-bold transition shadow-sm flex items-center gap-1.5"
                    >
                        <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                        <span>Follow-Up WA</span>
                    </a>
                @endif
                @if($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION)
                    <a
                        href="{{ route('admin.digital-stories.guests', $story) }}"
                        class="px-3.5 py-2 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 text-emerald-300 border border-emerald-600/70 font-mono text-xs font-semibold transition flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-users-viewfinder"></i>
                        <span>Generator Link Tamu</span>
                    </a>
                @else
                    <a
                        href="{{ $story->getPrintCardUrl() }}"
                        target="_blank"
                        class="px-3.5 py-2 rounded-xl bg-primary text-cream font-mono text-xs font-semibold hover:bg-primary-dark transition flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Kartu QR</span>
                    </a>
                @endif
            </div>
        </div>

        <form
            action="{{ route('admin.digital-stories.update', $story) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <!-- Order Information & Pipeline Status -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <i class="fa-solid fa-receipt text-accent"></i>
                    <h2 class="font-heading text-lg font-bold text-cream">Data Pesanan & Status Pengerjaan CMS</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nomor Pesanan Buket</label>
                        <input
                            type="text"
                            name="order_code"
                            value="{{ old('order_code', $story->order_code) }}"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-3 py-2 text-xs font-mono text-cream focus:outline-none focus:border-primary"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">No. WhatsApp Pemesan</label>
                        <input
                            type="text"
                            name="customer_phone"
                            value="{{ old('customer_phone', $story->customer_phone) }}"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-3 py-2 text-xs font-mono text-cream focus:outline-none focus:border-primary"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Status Pengerjaan CMS</label>
                        <select
                            name="fulfillment_status"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-3 py-2 text-xs font-body text-cream focus:outline-none focus:border-primary"
                        >
                            @foreach($fulfillmentStatuses as $fs)
                                <option value="{{ $fs->value }}" {{ old('fulfillment_status', $story->fulfillment_status?->value) === $fs->value ? 'selected' : '' }}>
                                    {{ $fs->icon() }} {{ $fs->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Paket Masa Aktif</label>
                        <select
                            name="duration_plan"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-3 py-2 text-xs font-body text-cream focus:outline-none focus:border-primary"
                        >
                            @foreach($durationPlans as $dp)
                                <option value="{{ $dp->value }}" {{ old('duration_plan', $story->duration_plan->value) === $dp->value ? 'selected' : '' }}>
                                    {{ $dp->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Catatan Khusus Florist</label>
                    <input
                        type="text"
                        name="notes"
                        value="{{ old('notes', $story->notes) }}"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs font-body text-cream focus:outline-none focus:border-primary"
                    >
                </div>
            </div>

            <!-- Template Switcher in CMS -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                    <div>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">CMS Template Switcher</span>
                        <h2 class="font-heading text-lg font-bold text-cream">Ganti Template Desain (1-Klik)</h2>
                    </div>
                    <a
                        href="{{ route('story.public.show', ['slug' => $story->slug]) }}"
                        target="_blank"
                        class="text-xs font-mono text-accent hover:underline flex items-center gap-1 font-semibold"
                    >
                        <span>Pratinjau Saat Ini</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $availableTemplates = $story->story_type === \App\Domains\DigitalStory\Enums\StoryType::LOVE_LETTER
                            ? $loveLetterTemplates
                            : $weddingTemplates;
                    @endphp

                    @foreach($availableTemplates as $tpl)
                        <label
                            class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between"
                            :class="selectedTemplate === '{{ $tpl->value }}' ? 'border-primary bg-primary/20 shadow-md ring-1 ring-primary/40' : 'border-border-subtle hover:border-primary/40 bg-night-bg'"
                        >
                            <input
                                type="radio"
                                name="template_key"
                                value="{{ $tpl->value }}"
                                x-model="selectedTemplate"
                                class="sr-only"
                            >
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="px-2 py-0.5 rounded-md bg-primary/30 text-accent font-mono text-[10px] font-bold border border-primary/40">
                                        {{ $tpl->badge() }}
                                    </span>
                                    <span
                                        class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                        :class="selectedTemplate === '{{ $tpl->value }}' ? 'border-accent bg-accent' : 'border-neutral-500'"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full bg-dark" x-show="selectedTemplate === '{{ $tpl->value }}'"></span>
                                    </span>
                                </div>
                                <h4 class="font-heading font-bold text-cream text-sm">{{ $tpl->title() }}</h4>
                                <p class="text-xs text-neutral-300 mt-1 leading-relaxed">{{ $tpl->description() }}</p>

                                <div class="mt-3 pt-2 border-t border-border-subtle flex items-center justify-between text-[11px] font-mono">
                                    <a
                                        href="{{ route('story.public.preview', ['templateKey' => $tpl->value]) }}"
                                        target="_blank"
                                        @click.stop
                                        class="text-accent hover:underline flex items-center gap-1 font-semibold"
                                        title="Buka contoh template live di tab baru"
                                    >
                                        <span>Contoh Live</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    <span class="text-neutral-500 text-[10px]">Klik untuk pilih</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Content Details -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <i class="fa-solid fa-heart text-accent"></i>
                    <h2 class="font-heading text-lg font-bold text-cream">Data Surat & Kenangan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Penerima *</label>
                        <input
                            type="text"
                            name="recipient_name"
                            value="{{ old('recipient_name', $story->recipient_name) }}"
                            required
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Pemesan / Pengirim *</label>
                        <input
                            type="text"
                            name="sender_name"
                            value="{{ old('sender_name', $story->sender_name) }}"
                            required
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Judul Cerita *</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $story->title) }}"
                            required
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Spesial</label>
                        <input
                            type="datetime-local"
                            name="event_date"
                            value="{{ old('event_date', $story->event_date ? $story->event_date->format('Y-m-d\TH:i') : '') }}"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Isi Pesan Surat Cinta *</label>
                    <textarea
                        name="message"
                        rows="6"
                        required
                        class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-3 text-xs text-cream leading-relaxed focus:outline-none focus:border-primary"
                    >{{ old('message', $story->message) }}</textarea>
                </div>
            </div>

            <!-- Existing Photos Gallery & Management -->
            @if($story->media && $story->media->count() > 0)
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                        <i class="fa-solid fa-images text-accent"></i>
                        <h2 class="font-heading text-lg font-bold text-cream">Foto Polaroid Tersimpan</h2>
                    </div>
                    <p class="text-xs text-neutral-400">
                        Centang kotak pada foto yang ingin dihapus dari galeri kenangan.
                    </p>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($story->media as $m)
                            <div class="bg-night-bg p-2.5 rounded-xl border border-border-subtle text-center relative group">
                                <img src="{{ $m->file_url }}" class="aspect-square object-cover w-full rounded-lg mb-2">
                                <p class="text-[10px] text-neutral-300 truncate">{{ $m->caption ?: 'Tanpa caption' }}</p>

                                <label class="mt-2 inline-flex items-center gap-1.5 text-[11px] font-mono text-rose-400 cursor-pointer">
                                    <input type="checkbox" name="delete_photos[]" value="{{ $m->id }}" class="rounded text-rose-500">
                                    <span>Hapus</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Upload Additional Photos -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <i class="fa-solid fa-cloud-arrow-up text-accent"></i>
                    <h2 class="font-heading text-lg font-bold text-cream">Unggah Foto Polaroid Tambahan</h2>
                </div>
                <p class="text-[11px] font-mono text-emerald-400/90 flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt text-accent"></i>
                    <span>Otomatis dikonversi ke format <strong>WEBP</strong> dan dikompresi <strong>&lt; 100 KB</strong> untuk loading ultra cepat.</span>
                </p>
                <input
                    type="file"
                    name="new_photos[]"
                    multiple
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full text-xs font-mono text-neutral-300 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                >
            </div>

            <!-- Audio Settings -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <i class="fa-solid fa-music text-accent"></i>
                    <h2 class="font-heading text-lg font-bold text-cream">Audio / Musik Latar</h2>
                </div>

                <div>
                    <x-story.audio-trimmer
                        :initialAudioUrl="old('audio_url', $story->audio_url)"
                        :initialAudioTitle="old('audio_title', $story->audio_title ?? '')"
                        :initialStartSec="(float) old('audio_start_sec', $story->audio_start_sec ?? 0)"
                        :initialEndSec="old('audio_end_sec', $story->audio_end_sec)"
                    />
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between p-4 bg-night-surface rounded-2xl border border-border-subtle shadow-xl">
                <a
                    href="{{ route('admin.digital-stories.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle font-mono text-xs font-semibold transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold uppercase tracking-wider transition duration-200 shadow-md cursor-pointer active:scale-95"
                >
                    Simpan Perubahan & Update CMS
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
