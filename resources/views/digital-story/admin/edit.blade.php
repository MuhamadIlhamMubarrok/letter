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
            x-data="{ submitting: false }"
            @submit="submitting = true"
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

            <!-- Content Details (Khusus Love Letter) -->
            <div
                x-show="storyType === 'love_letter'"
                class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4"
            >
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <i class="fa-solid fa-heart text-accent"></i>
                    <h2 class="font-heading text-lg font-bold text-cream">Data Surat Cinta &amp; Kenangan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Penerima *</label>
                        <input
                            type="text"
                            name="recipient_name"
                            value="{{ old('recipient_name', $story->recipient_name) }}"
                            :required="storyType === 'love_letter'"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Pemesan / Pengirim *</label>
                        <input
                            type="text"
                            name="sender_name"
                            value="{{ old('sender_name', $story->sender_name) }}"
                            :required="storyType === 'love_letter'"
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
                            :required="storyType === 'love_letter'"
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
                        :required="storyType === 'love_letter'"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-3 text-xs text-cream leading-relaxed focus:outline-none focus:border-primary"
                    >{{ old('message', $story->message) }}</textarea>
                </div>
            </div>

            <!-- WEDDING INVITATION SPECIALIZED SECTIONS (KHUSUS UNDANGAN PERNIKAHAN) -->
            @php
                $meta = is_array($story->metadata) ? $story->metadata : [];
            @endphp
            <div x-show="storyType === 'wedding_invitation'" class="space-y-6">
                <!-- Data & Foto Kedua Mempelai -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-5">
                    <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🤵🏻👰🏻</span>
                            <div>
                                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Data Mempelai</span>
                                <h2 class="font-heading text-lg font-bold text-cream">Data &amp; Foto Mempelai Pria &amp; Wanita</h2>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-primary/30 border border-primary/50 text-accent font-mono text-xs font-semibold">
                            Profil Pasangan
                        </span>
                    </div>

                    <!-- Judul Undangan & Hari H -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-border-subtle">
                        <div>
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Judul Undangan Pernikahan</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title', $story->title) }}"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary"
                            >
                        </div>
                        <div>
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Hari H (Target Countdown &amp; Kalender) *</label>
                            <input
                                type="datetime-local"
                                name="event_date"
                                value="{{ old('event_date', $story->event_date ? $story->event_date->format('Y-m-d\TH:i') : '') }}"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- KOLOM MEMPELAI PRIA -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-4">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-lg">🤵🏻</span>
                                <span>Mempelai Pria (Groom)</span>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Lengkap &amp; Gelar</label>
                                <input
                                    type="text"
                                    name="groom_full_name"
                                    value="{{ old('groom_full_name', $meta['groom_full_name'] ?? $story->sender_name) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Panggilan</label>
                                    <input
                                        type="text"
                                        name="groom_nickname"
                                        value="{{ old('groom_nickname', $meta['groom_nickname'] ?? $story->sender_name) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Username Instagram</label>
                                    <input
                                        type="text"
                                        name="groom_instagram"
                                        value="{{ old('groom_instagram', $meta['groom_instagram'] ?? '') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Orang Tua</label>
                                <input
                                    type="text"
                                    name="groom_parents"
                                    value="{{ old('groom_parents', $meta['groom_parents'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Bio / Kutipan Singkat</label>
                                <input
                                    type="text"
                                    name="groom_bio"
                                    value="{{ old('groom_bio', $meta['groom_bio'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Ganti Foto Mempelai Pria</label>
                                @if(!empty($meta['groom_photo']))
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="{{ str_starts_with($meta['groom_photo'], 'http') ? $meta['groom_photo'] : asset($meta['groom_photo']) }}" class="w-12 h-12 rounded-xl object-cover border border-primary">
                                        <span class="text-[11px] font-mono text-neutral-400">Foto saat ini tersimpan</span>
                                    </div>
                                @endif
                                <input
                                    type="file"
                                    name="groom_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-xs font-mono text-neutral-300 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                                >
                                <span class="font-mono text-[10px] text-emerald-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah</span>
                            </div>
                        </div>

                        <!-- KOLOM MEMPELAI WANITA -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-4">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-lg">👰🏻</span>
                                <span>Mempelai Wanita (Bride)</span>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Lengkap &amp; Gelar</label>
                                <input
                                    type="text"
                                    name="bride_full_name"
                                    value="{{ old('bride_full_name', $meta['bride_full_name'] ?? $story->recipient_name) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Panggilan</label>
                                    <input
                                        type="text"
                                        name="bride_nickname"
                                        value="{{ old('bride_nickname', $meta['bride_nickname'] ?? $story->recipient_name) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Username Instagram</label>
                                    <input
                                        type="text"
                                        name="bride_instagram"
                                        value="{{ old('bride_instagram', $meta['bride_instagram'] ?? '') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Orang Tua</label>
                                <input
                                    type="text"
                                    name="bride_parents"
                                    value="{{ old('bride_parents', $meta['bride_parents'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Bio / Kutipan Singkat</label>
                                <input
                                    type="text"
                                    name="bride_bio"
                                    value="{{ old('bride_bio', $meta['bride_bio'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Ganti Foto Mempelai Wanita</label>
                                @if(!empty($meta['bride_photo']))
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="{{ str_starts_with($meta['bride_photo'], 'http') ? $meta['bride_photo'] : asset($meta['bride_photo']) }}" class="w-12 h-12 rounded-xl object-cover border border-primary">
                                        <span class="text-[11px] font-mono text-neutral-400">Foto saat ini tersimpan</span>
                                    </div>
                                @endif
                                <input
                                    type="file"
                                    name="bride_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-xs font-mono text-neutral-300 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                                >
                                <span class="font-mono text-[10px] text-emerald-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Waktu & Lokasi Akad & Resepsi -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-5">
                    <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🕌🏛️</span>
                            <div>
                                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Lokasi &amp; Waktu</span>
                                <h2 class="font-heading text-lg font-bold text-cream">Data Akad Nikah &amp; Resepsi Pernikahan</h2>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-primary/30 border border-primary/50 text-accent font-mono text-xs font-semibold">
                            Venue &amp; Maps
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- AKAD NIKAH -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-3.5">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-base">💍</span>
                                <span>1. Akad Nikah / Pemberkatan</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Akad</label>
                                    <input
                                        type="date"
                                        name="ceremony_date"
                                        value="{{ old('ceremony_date', $meta['ceremony_date'] ?? '') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Waktu / Jam Akad</label>
                                    <input
                                        type="text"
                                        name="wedding_ceremony_time"
                                        value="{{ old('wedding_ceremony_time', $meta['ceremony_time'] ?? '') }}"
                                        placeholder="08.00 - 10.00 WIB"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Masjid / Gedung Akad</label>
                                <input
                                    type="text"
                                    name="ceremony_venue_name"
                                    value="{{ old('ceremony_venue_name', $meta['ceremony_venue'] ?? ($meta['venue_name'] ?? '')) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Alamat Lengkap Akad</label>
                                <input
                                    type="text"
                                    name="ceremony_venue_address"
                                    value="{{ old('ceremony_venue_address', $meta['ceremony_venue_address'] ?? ($meta['venue_address'] ?? '')) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Link Google Maps Akad</label>
                                <input
                                    type="url"
                                    name="ceremony_maps_url"
                                    value="{{ old('ceremony_maps_url', $meta['ceremony_maps_url'] ?? ($meta['maps_url'] ?? '')) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>

                        <!-- RESEPSI -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-3.5">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-base">🎉</span>
                                <span>2. Resepsi Pernikahan</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Resepsi</label>
                                    <input
                                        type="date"
                                        name="reception_date"
                                        value="{{ old('reception_date', $meta['reception_date'] ?? '') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Waktu / Jam Resepsi</label>
                                    <input
                                        type="text"
                                        name="wedding_reception_time"
                                        value="{{ old('wedding_reception_time', $meta['reception_time'] ?? '') }}"
                                        placeholder="11.00 - 14.00 WIB"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Ballroom / Gedung Resepsi</label>
                                <input
                                    type="text"
                                    name="wedding_venue_name"
                                    value="{{ old('wedding_venue_name', $meta['venue_name'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Alamat Lengkap Resepsi</label>
                                <input
                                    type="text"
                                    name="wedding_venue_address"
                                    value="{{ old('wedding_venue_address', $meta['venue_address'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Link Google Maps Resepsi</label>
                                <input
                                    type="url"
                                    name="wedding_maps_url"
                                    value="{{ old('wedding_maps_url', $meta['maps_url'] ?? '') }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amplop Digital & Rekening -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">💳🎁</span>
                            <div>
                                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Amplop Digital</span>
                                <h2 class="font-heading text-lg font-bold text-cream">Rekening Bank Kedua Mempelai &amp; Kirim Kado</h2>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- REKENING 1 -->
                        <div class="bg-night-bg/80 border border-border-subtle rounded-2xl p-4 space-y-3">
                            <span class="font-mono text-xs text-accent font-bold block">Rekening Mempelai 1</span>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-1">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Bank / E-Wallet</label>
                                    <input
                                        type="text"
                                        name="bank_1_name"
                                        value="{{ old('bank_1_name', $meta['bank_1_name'] ?? ($meta['bank_1']['bank'] ?? 'BCA')) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Nomor Rekening</label>
                                    <input
                                        type="text"
                                        name="bank_1_number"
                                        value="{{ old('bank_1_number', $meta['bank_1_number'] ?? ($meta['bank_bca_number'] ?? ($meta['bank_1']['number'] ?? ''))) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary font-mono"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_1_holder"
                                    value="{{ old('bank_1_holder', $meta['bank_1_holder'] ?? ($meta['bank_bca_holder'] ?? ($meta['bank_1']['holder'] ?? ''))) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>

                        <!-- REKENING 2 -->
                        <div class="bg-night-bg/80 border border-border-subtle rounded-2xl p-4 space-y-3">
                            <span class="font-mono text-xs text-accent font-bold block">Rekening Mempelai 2</span>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-1">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Bank / E-Wallet</label>
                                    <input
                                        type="text"
                                        name="bank_2_name"
                                        value="{{ old('bank_2_name', $meta['bank_2_name'] ?? ($meta['bank_2']['bank'] ?? 'Mandiri')) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Nomor Rekening</label>
                                    <input
                                        type="text"
                                        name="bank_2_number"
                                        value="{{ old('bank_2_number', $meta['bank_2_number'] ?? ($meta['bank_mandiri_number'] ?? ($meta['bank_2']['number'] ?? ''))) }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary font-mono"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_2_holder"
                                    value="{{ old('bank_2_holder', $meta['bank_2_holder'] ?? ($meta['bank_mandiri_holder'] ?? ($meta['bank_2']['holder'] ?? ''))) }}"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Alamat Pengiriman Kado Fisik</label>
                        <input
                            type="text"
                            name="gift_delivery_address"
                            value="{{ old('gift_delivery_address', $meta['gift_delivery_address'] ?? ($meta['gift_address']['address'] ?? '')) }}"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary"
                        >
                    </div>
                </div>

                <!-- Kutipan Ayat & Pesan Sambutan -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                        <span class="text-xl">📖</span>
                        <h2 class="font-heading text-lg font-bold text-cream">Kutipan Doa / Ayat Suci &amp; Sambutan</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Kutipan Ayat Suci / Doa Pernikahan</label>
                            <textarea
                                name="holy_verse_text"
                                rows="3"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary leading-relaxed"
                            >{{ old('holy_verse_text', $meta['holy_verse_text'] ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Sumber Kutipan</label>
                            <input
                                type="text"
                                name="holy_verse_source"
                                value="{{ old('holy_verse_source', $meta['holy_verse_source'] ?? '(QS. Ar-Rum: 21)') }}"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Teks Sambutan Undangan / Kisah Perjalanan Cinta</label>
                        <textarea
                            name="message"
                            rows="4"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-3 text-xs text-cream focus:outline-none focus:border-primary leading-relaxed"
                        >{{ old('message', $story->message) }}</textarea>
                    </div>
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
                    :disabled="submitting"
                    class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold uppercase tracking-wider transition duration-200 shadow-md cursor-pointer active:scale-95 disabled:opacity-50 flex items-center gap-2"
                >
                    <i class="fa-solid fa-spinner fa-spin" x-show="submitting" x-cloak></i>
                    <i class="fa-solid fa-floppy-disk text-accent" x-show="!submitting"></i>
                    <span x-show="!submitting">Simpan Perubahan &amp; Update CMS</span>
                    <span x-show="submitting" x-cloak>Menyimpan Perubahan...</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
