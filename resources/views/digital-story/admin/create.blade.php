<x-layouts.admin title="Input Pesanan Surat & Undangan — Maja Flower">
    <x-slot:header>
        Input & Proses Pesanan Surat / Undangan
    </x-slot:header>

    <div
        x-data="{
            storyType: '{{ old('story_type', request()->query('story_type', 'love_letter')) }}',
            selectedTemplate: '{{ old('template_key', request()->query('template_key', 'online_love_letter')) }}',
            durationPlan: '{{ old('duration_plan', '1_month') }}',
            theme: '{{ old('theme', 'romantic_rose') }}',
            fulfillmentStatus: '{{ old('fulfillment_status', 'drafting') }}',
            submitting: false,
            photos: [],
            selectType(type) {
                this.storyType = type;
                if (type === 'love_letter' && !['online_love_letter', 'vintage_envelope', 'midnight_rose', 'retro_polaroid', 'minimalist_aesthetic'].includes(this.selectedTemplate)) {
                    this.selectedTemplate = 'online_love_letter';
                } else if (type === 'wedding_invitation' && !['online_wedding'].includes(this.selectedTemplate)) {
                    this.selectedTemplate = 'online_wedding';
                }
            },
            handlePhotoSelection(e) {
                const files = Array.from(e.target.files);
                this.photos = [];
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.photos.push({
                            id: index,
                            url: event.target.result,
                            name: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }
        }"
        class="space-y-6 max-w-5xl mx-auto"
    >
        <!-- Top Nav Link -->
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <div>
                <a href="{{ route('admin.digital-stories.index') }}" class="text-xs font-mono text-neutral-400 hover:text-cream flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Pipeline CMS</span>
                </a>
                <h1 class="font-heading text-xl sm:text-2xl font-bold text-cream tracking-tight mt-1">
                    CMS Pemrosesan Pesanan Surat & Undangan
                </h1>
                <p class="text-xs text-neutral-400">
                    Input data pesanan buket, pilih template eksklusif, lengkapi konten kenangan, dan generate QR Code cetak.
                </p>
            </div>
        </div>

        <form
            action="{{ route('admin.digital-stories.store') }}"
            method="POST"
            enctype="multipart/form-data"
            @submit="submitting = true"
            class="space-y-6"
        >
            @csrf

            <!-- 1. IDENTITAS PESANAN BUKET & WHATSAPP PEMESAN -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                    <div>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 1</span>
                        <h2 class="font-heading text-lg font-bold text-cream">Data Pesanan Buket & Follow-Up</h2>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-primary/30 border border-primary/50 text-accent font-mono text-xs font-semibold">
                        CMS Order Follow-Up
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nomor Pesanan Buket (Order Code)</label>
                        <input
                            type="text"
                            name="order_code"
                            value="{{ old('order_code') }}"
                            placeholder="Contoh: MF-202611-0012"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary font-mono transition"
                        >
                        <span class="font-mono text-[10px] text-neutral-400 mt-1 block">Tercatat di sistem kasir/order florist</span>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nomor WhatsApp Pemesan</label>
                        <input
                            type="text"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary font-mono transition"
                        >
                        <span class="font-mono text-[10px] text-neutral-400 mt-1 block">Untuk 1-klik follow-up chat WA</span>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Status Awal di CMS</label>
                        <select
                            name="fulfillment_status"
                            x-model="fulfillmentStatus"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary font-mono transition cursor-pointer"
                        >
                            @foreach($fulfillmentStatuses as $fs)
                                <option value="{{ $fs->value }}">{{ $fs->icon() }} {{ $fs->label() }}</option>
                            @endforeach
                        </select>
                        <span class="font-mono text-[10px] text-neutral-400 mt-1 block">Tahapan progres pembuatan</span>
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Catatan Khusus Florist (Internal)</label>
                    <input
                        type="text"
                        name="notes"
                        value="{{ old('notes') }}"
                        placeholder="Contoh: Pemesan request lagu Glenn Fredly, buket dikirim jam 14.00"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                    >
                </div>
            </div>

            <!-- 2. PILIH TIPE SURAT / UNDANGAN -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 2</span>
                <h2 class="font-heading text-lg font-bold text-cream">Pilih Kategori Produk</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($storyTypes as $type)
                        <div
                            @click="selectType('{{ $type->value }}')"
                            class="p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between"
                            :class="storyType === '{{ $type->value }}' ? 'border-primary bg-primary/20 shadow-md ring-1 ring-primary/40' : 'border-border-subtle hover:border-primary/40 bg-night-bg'"
                        >
                            <input type="radio" name="story_type" value="{{ $type->value }}" x-model="storyType" class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-3xl">{{ $type->icon() }}</span>
                                <span
                                    class="w-4 h-4 rounded-full border-2 flex items-center justify-center"
                                    :class="storyType === '{{ $type->value }}' ? 'border-accent bg-accent' : 'border-neutral-500'"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-dark" x-show="storyType === '{{ $type->value }}'"></span>
                                </span>
                            </div>
                            <h3 class="font-heading font-bold text-cream text-base">{{ $type->label() }}</h3>
                            <p class="text-xs text-neutral-300 mt-1 leading-relaxed">{{ $type->description() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. KATALOG BANYAK TEMPLATE -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                    <div>
                        <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 3</span>
                        <h2 class="font-heading text-lg font-bold text-cream">Katalog Pilihan Template</h2>
                    </div>
                    <span class="text-xs font-mono text-neutral-400">Klik template untuk memilih</span>
                </div>

                <!-- Love Letter Templates Grid -->
                <div x-show="storyType === 'love_letter'" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($loveLetterTemplates as $tpl)
                        <label
                            class="relative p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between overflow-hidden"
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
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-primary/30 text-accent font-mono text-[10px] font-bold border border-primary/40">
                                        {{ $tpl->badge() }}
                                    </span>
                                    <span
                                        class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                        :class="selectedTemplate === '{{ $tpl->value }}' ? 'border-accent bg-accent' : 'border-neutral-500'"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full bg-dark" x-show="selectedTemplate === '{{ $tpl->value }}'"></span>
                                    </span>
                                </div>
                                <h4 class="font-heading font-bold text-cream text-sm sm:text-base">{{ $tpl->title() }}</h4>
                                <p class="text-xs text-neutral-300 mt-1 leading-relaxed">{{ $tpl->description() }}</p>

                                <div class="flex flex-wrap gap-1 mt-3">
                                    @foreach($tpl->features() as $feat)
                                        <span class="px-2 py-0.5 bg-night-surface text-neutral-300 rounded-md text-[9px] font-mono border border-border-subtle">
                                            <i class="fa-solid fa-check text-accent text-[8px] mr-0.5"></i> {{ $feat }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-border-subtle flex items-center justify-between text-[11px] font-mono">
                                    <a
                                        href="{{ route('story.public.preview', ['templateKey' => $tpl->value]) }}"
                                        target="_blank"
                                        @click.stop
                                        class="text-accent hover:underline flex items-center gap-1 font-semibold"
                                        title="Lihat contoh template live di tab baru"
                                    >
                                        <span>Contoh Live</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    <span class="text-neutral-500 text-[10px]">Klik untuk memilih</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <!-- Wedding Invitation Templates Grid -->
                <div x-show="storyType === 'wedding_invitation'" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($weddingTemplates as $tpl)
                        <label
                            class="relative p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex flex-col justify-between overflow-hidden"
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
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-secondary/20 text-accent font-mono text-[10px] font-bold border border-secondary/40">
                                        {{ $tpl->badge() }}
                                    </span>
                                    <span
                                        class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                        :class="selectedTemplate === '{{ $tpl->value }}' ? 'border-accent bg-accent' : 'border-neutral-500'"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full bg-dark" x-show="selectedTemplate === '{{ $tpl->value }}'"></span>
                                    </span>
                                </div>
                                <h4 class="font-heading font-bold text-cream text-sm sm:text-base">{{ $tpl->title() }}</h4>
                                <p class="text-xs text-neutral-300 mt-1 leading-relaxed">{{ $tpl->description() }}</p>

                                <div class="flex flex-wrap gap-1 mt-3">
                                    @foreach($tpl->features() as $feat)
                                        <span class="px-2 py-0.5 bg-night-surface text-neutral-300 rounded-md text-[9px] font-mono border border-border-subtle">
                                            <i class="fa-solid fa-check text-accent text-[8px] mr-0.5"></i> {{ $feat }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-border-subtle flex items-center justify-between text-[11px] font-mono">
                                    <a
                                        href="{{ route('story.public.preview', ['templateKey' => $tpl->value]) }}"
                                        target="_blank"
                                        @click.stop
                                        class="text-accent hover:underline flex items-center gap-1 font-semibold"
                                        title="Lihat contoh template live di tab baru"
                                    >
                                        <span>Contoh Live</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                    <span class="text-neutral-500 text-[10px]">Klik untuk memilih</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 4. PAKET MASA AKTIF HOSTING -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 4</span>
                <h2 class="font-heading text-lg font-bold text-cream">Pilih Paket Masa Aktif</h2>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($durationPlans as $plan)
                        <label
                            class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 text-center flex flex-col justify-between"
                            :class="durationPlan === '{{ $plan->value }}' ? 'border-primary bg-primary/20 shadow-md ring-1 ring-primary/40' : 'border-border-subtle hover:border-primary/40 bg-night-bg'"
                        >
                            <input type="radio" name="duration_plan" value="{{ $plan->value }}" x-model="durationPlan" class="sr-only">
                            <div>
                                <span class="font-heading text-sm font-bold text-cream block">{{ $plan->shortLabel() }}</span>
                                <span class="font-mono text-[11px] text-neutral-400 mt-0.5 block">
                                    {{ $plan->durationDays() ? $plan->durationDays() . ' Hari' : 'Selamanya' }}
                                </span>
                            </div>
                            <div class="mt-3 pt-2 border-t border-border-subtle">
                                <span class="font-mono font-bold text-xs text-accent block">{{ $plan->priceFormatted() }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 5. KONTEN PESAN, NAMA, & TANGGAL (KHUSUS LOVE LETTER) -->
            <div
                x-show="storyType === 'love_letter'"
                class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4"
            >
                <div class="flex items-center gap-2 border-b border-border-subtle pb-3">
                    <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 5</span>
                    <h2 class="font-heading text-lg font-bold text-cream">Konten Surat Cinta & Pasangan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Penerima (Pasangan Tercinta) *</label>
                        <input
                            type="text"
                            name="recipient_name"
                            value="{{ old('recipient_name') }}"
                            placeholder="Contoh: Dinda Permata"
                            :required="storyType === 'love_letter'"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Pemesan / Pengirim *</label>
                        <input
                            type="text"
                            name="sender_name"
                            value="{{ old('sender_name') }}"
                            placeholder="Contoh: Rian Pratama"
                            :required="storyType === 'love_letter'"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Judul Surat Kenangan *</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Untuk Dinda Tercinta di Hari Anniversary ke-3"
                            :required="storyType === 'love_letter'"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                        >
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Spesial (Jadian / Anniversary)</label>
                        <input
                            type="datetime-local"
                            name="event_date"
                            value="{{ old('event_date') }}"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary transition"
                        >
                    </div>
                </div>

                <div>
                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Isi Pesan Surat Kenangan *</label>
                    <textarea
                        name="message"
                        rows="6"
                        placeholder="Tuliskan ungkapan pesan cinta dan kenangan tulus Anda..."
                        :required="storyType === 'love_letter'"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-3 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary leading-relaxed transition"
                    >{{ old('message') }}</textarea>
                </div>
            </div>

            <!-- 5. WEDDING INVITATION SPECIALIZED SECTIONS (KHUSUS UNDANGAN PERNIKAHAN) -->
            <div x-show="storyType === 'wedding_invitation'" class="space-y-6">
                <!-- 5A. DATA & FOTO KEDUA MEMPELAI -->
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
                                value="{{ old('title') }}"
                                placeholder="Contoh: The Wedding of Daffa & Caca"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                            >
                            <span class="font-mono text-[10px] text-neutral-400 mt-1 block">Otomatis terisi jika dikosongkan</span>
                        </div>
                        <div>
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Tanggal Hari H (Target Countdown &amp; Kalender) *</label>
                            <input
                                type="datetime-local"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream focus:outline-none focus:border-primary transition"
                            >
                            <span class="font-mono text-[10px] text-neutral-400 mt-1 block">Digunakan untuk hitung mundur detik/hari acara</span>
                        </div>
                    </div>

                    <!-- Grid Dua Kolom: Mempelai Pria & Mempelai Wanita -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- KOLOM MEMPELAI PRIA -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-4">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-lg">🤵🏻</span>
                                <span>Mempelai Pria (Groom)</span>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Lengkap &amp; Gelar *</label>
                                <input
                                    type="text"
                                    name="groom_full_name"
                                    value="{{ old('groom_full_name') }}"
                                    placeholder="Contoh: Daffa Ramadhan, S.T."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Panggilan *</label>
                                    <input
                                        type="text"
                                        name="groom_nickname"
                                        value="{{ old('groom_nickname') }}"
                                        placeholder="Contoh: Daffa"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Username Instagram</label>
                                    <input
                                        type="text"
                                        name="groom_instagram"
                                        value="{{ old('groom_instagram') }}"
                                        placeholder="Contoh: @daffarmdhn"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Orang Tua</label>
                                <input
                                    type="text"
                                    name="groom_parents"
                                    value="{{ old('groom_parents') }}"
                                    placeholder="Contoh: Putra bungsu dari Bpk. Bambang Tri & Ibu Nurhayati"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Bio / Kutipan Singkat</label>
                                <input
                                    type="text"
                                    name="groom_bio"
                                    value="{{ old('groom_bio') }}"
                                    placeholder="Contoh: Pencinta kopi dan sosok paling sabar..."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Upload Foto Mempelai Pria</label>
                                <input
                                    type="file"
                                    name="groom_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-xs font-mono text-neutral-300 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                                >
                                <span class="font-mono text-[10px] text-emerald-400 mt-1 block">Otomatis WebP &lt; 100 KB</span>
                            </div>
                        </div>

                        <!-- KOLOM MEMPELAI WANITA -->
                        <div class="bg-night-bg/80 border border-primary/30 rounded-2xl p-4 sm:p-5 space-y-4">
                            <div class="flex items-center gap-2 text-accent font-heading font-bold text-sm border-b border-white/10 pb-2">
                                <span class="text-lg">👰🏻</span>
                                <span>Mempelai Wanita (Bride)</span>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Lengkap &amp; Gelar *</label>
                                <input
                                    type="text"
                                    name="bride_full_name"
                                    value="{{ old('bride_full_name') }}"
                                    placeholder="Contoh: Clarissa Putri, S.I.Kom."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Panggilan *</label>
                                    <input
                                        type="text"
                                        name="bride_nickname"
                                        value="{{ old('bride_nickname') }}"
                                        placeholder="Contoh: Caca"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Username Instagram</label>
                                    <input
                                        type="text"
                                        name="bride_instagram"
                                        value="{{ old('bride_instagram') }}"
                                        placeholder="Contoh: @clarissaptr"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Orang Tua</label>
                                <input
                                    type="text"
                                    name="bride_parents"
                                    value="{{ old('bride_parents') }}"
                                    placeholder="Contoh: Putri pertama dari Bpk. Rudi Hartono & Ibu Dewi Anggraeni"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Bio / Kutipan Singkat</label>
                                <input
                                    type="text"
                                    name="bride_bio"
                                    value="{{ old('bride_bio') }}"
                                    placeholder="Contoh: Pecinta bunga manis, pencipta keceriaan..."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Upload Foto Mempelai Wanita</label>
                                <input
                                    type="file"
                                    name="bride_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full text-xs font-mono text-neutral-300 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                                >
                                <span class="font-mono text-[10px] text-emerald-400 mt-1 block">Otomatis WebP &lt; 100 KB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5B. RANGKAIAN ACARA: AKAD NIKAH & RESEPSI -->
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
                        <!-- AKAD NIKAH / PEMBERKATAN -->
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
                                        value="{{ old('ceremony_date') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Waktu / Jam Akad</label>
                                    <input
                                        type="text"
                                        name="wedding_ceremony_time"
                                        value="{{ old('wedding_ceremony_time') }}"
                                        placeholder="08.00 - 10.00 WIB"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Masjid / Gedung Akad</label>
                                <input
                                    type="text"
                                    name="ceremony_venue_name"
                                    value="{{ old('ceremony_venue_name') }}"
                                    placeholder="Contoh: Masjid Agung Al-Azhar / Glasshouse Maja"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Alamat Lengkap Akad</label>
                                <input
                                    type="text"
                                    name="ceremony_venue_address"
                                    value="{{ old('ceremony_venue_address') }}"
                                    placeholder="Contoh: Jl. Sisingamangaraja No. 1, Kebayoran Baru"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Link Google Maps Akad</label>
                                <input
                                    type="url"
                                    name="ceremony_maps_url"
                                    value="{{ old('ceremony_maps_url') }}"
                                    placeholder="https://maps.google.com/?q=..."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>

                        <!-- RESEPSI PERNIKAHAN -->
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
                                        value="{{ old('reception_date') }}"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Waktu / Jam Resepsi</label>
                                    <input
                                        type="text"
                                        name="wedding_reception_time"
                                        value="{{ old('wedding_reception_time') }}"
                                        placeholder="11.00 - 14.00 WIB"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Nama Ballroom / Gedung Resepsi</label>
                                <input
                                    type="text"
                                    name="wedding_venue_name"
                                    value="{{ old('wedding_venue_name') }}"
                                    placeholder="Contoh: Grand Ballroom Plataran Cilandak"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Alamat Lengkap Resepsi</label>
                                <input
                                    type="text"
                                    name="wedding_venue_address"
                                    value="{{ old('wedding_venue_address') }}"
                                    placeholder="Contoh: Jl. Durian No. 26, Jagakarsa, Jakarta Selatan"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>

                            <div>
                                <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Link Google Maps Resepsi</label>
                                <input
                                    type="url"
                                    name="wedding_maps_url"
                                    value="{{ old('wedding_maps_url') }}"
                                    placeholder="https://maps.google.com/?q=..."
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3.5 py-2 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5C. REKENING BANK & KADO DIGITAL -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">💳🎁</span>
                            <div>
                                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Amplop Digital</span>
                                <h2 class="font-heading text-lg font-bold text-cream">Rekening Bank Kedua Mempelai &amp; Kirim Kado</h2>
                            </div>
                        </div>
                        <span class="text-xs font-mono text-neutral-400">1-Klik Salin di Undangan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- REKENING MEMPELAI 1 -->
                        <div class="bg-night-bg/80 border border-border-subtle rounded-2xl p-4 space-y-3">
                            <span class="font-mono text-xs text-accent font-bold block">Rekening Mempelai 1</span>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-1">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Bank / E-Wallet</label>
                                    <input
                                        type="text"
                                        name="bank_1_name"
                                        value="{{ old('bank_1_name', 'BCA') }}"
                                        placeholder="BCA / Mandiri / Gopay"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Nomor Rekening</label>
                                    <input
                                        type="text"
                                        name="bank_1_number"
                                        value="{{ old('bank_1_number') }}"
                                        placeholder="Contoh: 8020 9988 12"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary font-mono"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_1_holder"
                                    value="{{ old('bank_1_holder') }}"
                                    placeholder="Contoh: Clarissa Putri"
                                    class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                >
                            </div>
                        </div>

                        <!-- REKENING MEMPELAI 2 -->
                        <div class="bg-night-bg/80 border border-border-subtle rounded-2xl p-4 space-y-3">
                            <span class="font-mono text-xs text-accent font-bold block">Rekening Mempelai 2</span>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-1">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Bank / E-Wallet</label>
                                    <input
                                        type="text"
                                        name="bank_2_name"
                                        value="{{ old('bank_2_name', 'Mandiri') }}"
                                        placeholder="Mandiri / BNI / Gopay"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary"
                                    >
                                </div>
                                <div class="col-span-2">
                                    <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Nomor Rekening</label>
                                    <input
                                        type="text"
                                        name="bank_2_number"
                                        value="{{ old('bank_2_number') }}"
                                        placeholder="Contoh: 137 00 1928 382"
                                        class="w-full bg-night-surface border border-border-subtle rounded-xl px-3 py-2 text-xs text-cream focus:outline-none focus:border-primary font-mono"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block font-mono text-[11px] text-neutral-400 mb-1 font-semibold">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_2_holder"
                                    value="{{ old('bank_2_holder') }}"
                                    placeholder="Contoh: Daffa Ramadhan"
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
                            value="{{ old('gift_delivery_address') }}"
                            placeholder="Contoh: Jl. Anggrek Ceria No. 12, Kebayoran Baru, Jakarta Selatan (Penerima: Caca & Daffa)"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                        >
                    </div>
                </div>

                <!-- 5D. AYAT SUCI & PESAN SAMBUTAN -->
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
                                placeholder="Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu..."
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary leading-relaxed"
                            >{{ old('holy_verse_text', 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Sumber Kutipan</label>
                            <input
                                type="text"
                                name="holy_verse_source"
                                value="{{ old('holy_verse_source', '(QS. Ar-Rum: 21)') }}"
                                placeholder="Contoh: (QS. Ar-Rum: 21)"
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold">Teks Sambutan Undangan / Kisah Perjalanan Cinta</label>
                        <textarea
                            name="message"
                            rows="4"
                            placeholder="Dengan penuh rasa syukur kepada Tuhan Yang Maha Esa, kami bermaksud mengundang..."
                            class="w-full bg-night-bg border border-border-subtle rounded-xl px-4 py-3 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary leading-relaxed"
                        >{{ old('message', 'Dengan penuh rasa syukur kepada Tuhan Yang Maha Esa, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia pernikahan kami.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 6. UPLOAD GALERI KENANGAN & AUDIO -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <span class="font-mono text-[10px] tracking-widest uppercase text-accent font-semibold block">Langkah 6</span>
                <h2 class="font-heading text-lg font-bold text-cream" x-text="storyType === 'wedding_invitation' ? 'Galeri Foto Kenangan Prewedding & Musik Latar' : 'Foto Polaroid & Musik Kenangan'">Galeri Foto &amp; Musik Kenangan</h2>

                <div>
                    <label class="block font-mono text-xs text-neutral-300 mb-1 font-semibold" x-text="storyType === 'wedding_invitation' ? 'Pilih Foto Galeri Prewedding (Maksimal 12 Foto)' : 'Pilih Foto Polaroid (Maksimal 12 Foto)'">Pilih Foto (Maksimal 12 Foto)</label>
                    <p class="text-[11px] font-mono text-emerald-400/90 mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-bolt text-accent"></i>
                        <span>Otomatis dikonversi ke format <strong>WEBP</strong> dan dikompresi <strong>&lt; 100 KB</strong> untuk loading ultra cepat.</span>
                    </p>
                    <input
                        type="file"
                        name="photos[]"
                        multiple
                        accept="image/jpeg,image/png,image/webp"
                        @change="handlePhotoSelection($event)"
                        class="w-full text-xs font-mono text-neutral-300 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-primary file:text-cream file:text-xs hover:file:bg-primary-dark cursor-pointer"
                    >

                    <div x-show="photos.length > 0" class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                        <template x-for="(item, idx) in photos" :key="idx">
                            <div class="bg-night-bg p-2.5 rounded-xl border border-border-subtle text-center">
                                <img :src="item.url" class="aspect-square object-cover w-full rounded-lg mb-2">
                                <input
                                    type="text"
                                    :name="`photo_captions[${idx}]`"
                                    placeholder="Tulis caption..."
                                    class="w-full bg-night-surface border border-border-subtle rounded-lg px-2 py-1 text-[11px] text-cream"
                                >
                            </div>
                        </template>
                    </div>
                </div>

                <div class="pt-4 border-t border-border-subtle">
                    <x-story.audio-trimmer
                        :initialAudioUrl="old('audio_url')"
                        :initialAudioTitle="old('audio_title', '')"
                        :initialStartSec="(float) old('audio_start_sec', 0)"
                        :initialEndSec="old('audio_end_sec')"
                    />
                </div>
            </div>

            <!-- Submit Action -->
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
                    class="px-6 py-3 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold uppercase tracking-wider transition duration-200 shadow-lg shadow-primary/30 flex items-center gap-2 cursor-pointer disabled:opacity-50 active:scale-95"
                >
                    <i class="fa-solid fa-wand-magic-sparkles text-accent" x-show="!submitting"></i>
                    <span x-show="!submitting" x-text="storyType === 'wedding_invitation' ? 'Simpan & Buat Link Undangan' : 'Simpan Pesanan & Generate QR'">Simpan Pesanan & Generate QR</span>
                    <span x-show="submitting" x-text="storyType === 'wedding_invitation' ? 'Menyimpan & Menyiapkan Link...' : 'Menyimpan & Meng-generate QR...'">Menyimpan & Meng-generate QR...</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
