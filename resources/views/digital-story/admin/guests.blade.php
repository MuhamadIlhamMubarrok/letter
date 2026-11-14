<x-layouts.admin title="Generator Undangan Personal — {{ $story->title }} | Maja Flower">
    <x-slot:header>
        Generator Undangan Pernikahan Personal & Salin Masal
    </x-slot:header>

    @php
        $baseUrl = url('/s/' . $story->slug);
        $initialGuests = $guestList ?? [];
        $initialText = implode("\n", $initialGuests);
    @endphp

    <div
        x-data="{
            inputText: @js($initialText),
            waTemplate: @js($waTemplate),
            searchQuery: '',
            copiedToast: '',
            showToast: false,
            saving: false,
            saveSuccessMsg: '',
            storyTitle: @js($story->title),
            storyMempelai: @js($story->sender_name . ($story->recipient_name ? ' & ' . $story->recipient_name : '')),
            baseUrl: @js($baseUrl),

            get guests() {
                if (!this.inputText) return [];
                const lines = this.inputText.split(/\r?\n/);
                const list = [];
                for (let line of lines) {
                    const trimmed = line.trim();
                    if (trimmed.length > 0) {
                        list.push(trimmed);
                    }
                }
                return list;
            },

            get filteredGuests() {
                if (!this.searchQuery) return this.guests;
                const q = this.searchQuery.toLowerCase();
                return this.guests.filter(g => g.toLowerCase().includes(q));
            },

            getInvitationUrl(name) {
                return this.baseUrl + '?to=' + encodeURIComponent(name);
            },

            getWaMessage(name) {
                const link = this.getInvitationUrl(name);
                return this.waTemplate
                    .replace(/{nama_tamu}/g, name)
                    .replace(/{link_undangan}/g, link)
                    .replace(/{judul_acara}/g, this.storyTitle)
                    .replace(/{nama_mempelai}/g, this.storyMempelai);
            },

            getWaDirectUrl(name) {
                return 'https://wa.me/?text=' + encodeURIComponent(this.getWaMessage(name));
            },

            triggerToast(msg) {
                this.copiedToast = msg;
                this.showToast = true;
                setTimeout(() => {
                    this.showToast = false;
                }, 3000);
            },

            copyToClipboard(text, msg = 'Tersalin ke clipboard!') {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.triggerToast(msg);
                    }).catch(() => {
                        this.fallbackCopy(text, msg);
                    });
                } else {
                    this.fallbackCopy(text, msg);
                }
            },

            fallbackCopy(text, msg) {
                const ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.focus();
                ta.select();
                try {
                    document.execCommand('copy');
                    this.triggerToast(msg);
                } catch (e) {
                    alert('Gagal menyalin. Silakan pilih dan salin manual.');
                }
                document.body.removeChild(ta);
            },

            // 1. COPY ALL LINKS (Plain Text List)
            copyAllLinks() {
                if (this.guests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                const lines = this.guests.map((g, idx) => `${idx + 1}. ${g}\n${this.getInvitationUrl(g)}`);
                const fullText = lines.join('\n\n');
                this.copyToClipboard(fullText, `📋 Berhasil menyalin ${this.guests.length} link undangan!`);
            },

            // 2. COPY AS SPREADSHEET (Excel / Google Sheets TSV)
            copyAsSpreadsheet() {
                if (this.guests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                const header = 'No\tNama Tamu\tLink Undangan Personal\n';
                const rows = this.guests.map((g, idx) => `${idx + 1}\t${g}\t${this.getInvitationUrl(g)}`).join('\n');
                this.copyToClipboard(header + rows, `📑 Format Excel / Spreadsheet untuk ${this.guests.length} tamu berhasil disalin! (Tinggal Ctrl+V di Excel)`);
            },

            // 3. COPY ALL WA MESSAGES
            copyAllWaMessages() {
                if (this.guests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                const divider = '\n\n' + '─'.repeat(30) + '\n\n';
                const messages = this.guests.map(g => this.getWaMessage(g)).join(divider);
                this.copyToClipboard(messages, `💬 ${this.guests.length} pesan WhatsApp personal berhasil disalin!`);
            },

            // 4. DOWNLOAD CSV
            downloadCsv() {
                if (this.guests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                let csv = 'No,Nama Tamu,Link Undangan\n';
                this.guests.forEach((g, idx) => {
                    const cleanName = '&quot;' + g.replace(/&quot;/g, '&quot;&quot;') + '&quot;';
                    const link = '&quot;' + this.getInvitationUrl(g) + '&quot;';
                    csv += `${idx + 1},${cleanName},${link}\n`;
                });
                const blob = new Blob([&quot;\uFEFF&quot; + csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `tamu-undangan-${this.storyTitle.replace(/[^a-zA-Z0-9]/g, '_')}.csv`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                this.triggerToast('📥 File CSV berhasil diunduh!');
            },

            // 5. HELPER ACTIONS
            insertSampleNames() {
                const sample = [
                    'Bpk. Budi Santoso &amp; Keluarga',
                    'Ibu Siti Aminah',
                    'dr. Farhan Pratama, Sp.A',
                    'Dimas &amp; Partner',
                    'Keluarga Besar Bpk. Surya'
                ].join('\n');
                if (this.inputText.trim()) {
                    this.inputText = this.inputText.trim() + '\n' + sample;
                } else {
                    this.inputText = sample;
                }
            },

            cleanupDuplicates() {
                const lines = this.inputText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
                const unique = [...new Set(lines)];
                this.inputText = unique.join('\n');
                this.triggerToast('✨ Duplikat &amp; spasi berhasil dirapikan!');
            },

            clearNames() {
                if (confirm('Yakin ingin mengosongkan seluruh daftar nama tamu?')) {
                    this.inputText = '';
                }
            },

            deleteGuest(guestName) {
                const lines = this.inputText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0 &amp;&amp; l !== guestName);
                this.inputText = lines.join('\n');
                this.triggerToast(`Tamu &quot;${guestName}&quot; dihapus.`);
            },

            // 6. SAVE TO DATABASE
            async saveToDatabase() {
                this.saving = true;
                this.saveSuccessMsg = '';
                try {
                    const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
                    const res = await fetch('{{ route('admin.digital-stories.guests.save', $story) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            guest_names: this.inputText,
                            wa_template: this.waTemplate
                        })
                    });
                    const data = await res.json();
                    if (res.ok &amp;&amp; data.success) {
                        this.triggerToast('💾 ' + data.message);
                    } else {
                        alert(data.message || 'Gagal menyimpan ke database.');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan jaringan.');
                } finally {
                    this.saving = false;
                }
            }
        }"
        class="space-y-6 max-w-6xl mx-auto"
    >
        <!-- TOAST NOTIFICATION -->
        <div
            x-show="showToast"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded-2xl bg-primary text-cream border border-brand-amber/40 shadow-2xl flex items-center gap-3 font-mono text-xs font-bold"
            x-cloak
        >
            <i class="fa-solid fa-circle-check text-accent text-base"></i>
            <span x-text="copiedToast"></span>
        </div>

        <!-- TOP HEADER & BREADCRUMB -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-border-subtle">
            <div>
                <a href="{{ route('admin.digital-stories.index') }}" class="text-xs font-mono text-neutral-400 hover:text-cream flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Pipeline CMS</span>
                </a>
                <h1 class="font-heading text-xl sm:text-2xl font-bold text-cream tracking-tight mt-1 flex items-center gap-2">
                    <i class="fa-solid fa-users-viewfinder text-accent"></i>
                    <span>Generator Undangan Personal: {{ $story->title }}</span>
                </h1>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    @if($story->order_code)
                        <span class="px-2.5 py-0.5 rounded-md bg-primary/30 border border-primary/40 text-accent font-mono text-xs font-bold">
                            {{ $story->order_code }}
                        </span>
                    @endif
                    <span class="font-mono text-xs text-neutral-400">/s/{{ $story->slug }}</span>
                    <span class="text-neutral-500">•</span>
                    <span class="text-xs text-neutral-300 font-semibold">{{ $story->sender_name }} &amp; {{ $story->recipient_name }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ $story->getPublicUrl() }}"
                    target="_blank"
                    class="px-3.5 py-2 rounded-xl bg-night-surface hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle font-mono text-xs font-semibold transition flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Lihat Undangan</span>
                </a>
                <button
                    type="button"
                    @click="saveToDatabase()"
                    :disabled="saving"
                    class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold shadow-md transition flex items-center gap-1.5 cursor-pointer disabled:opacity-50"
                >
                    <i class="fa-solid" :class="saving ? 'fa-spinner fa-spin' : 'fa-floppy-disk'"></i>
                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Daftar Tamu'"></span>
                </button>
            </div>
        </div>

        <!-- INFO CALLOUT: 100% LINK-BASED FOR WEDDING (NO BARCODE NEEDED) -->
        <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-start gap-3 text-xs">
            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center shrink-0 text-sm mt-0.5">
                <i class="fa-solid fa-link"></i>
            </div>
            <div>
                <p class="font-heading font-bold text-amber-200">Undangan Pernikahan Praktis Berbasis Link (Tanpa Barcode)</p>
                <p class="text-neutral-300 mt-0.5 leading-relaxed">
                    Khusus undangan pernikahan, tamu tidak memerlukan barcode fisik. Cukup tempel nama tamu di kolom kiri, lalu salin seluruh link personal tamu sekaligus atau download file Excel/Spreadsheet untuk disebarkan via WhatsApp.
                </p>
            </div>
        </div>

        <!-- 2-COLUMN WORKSPACE: LEFT (INPUT) & RIGHT (ACTIONS & PREVIEW) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- LEFT COLUMN: INPUT TEXTAREA -->
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-cream text-base flex items-center gap-2">
                                <i class="fa-solid fa-paste text-accent"></i>
                                <span>Tempel Daftar Nama Tamu</span>
                            </h3>
                            <p class="text-xs text-neutral-400 mt-0.5">Ketik atau tempel nama tamu (1 nama per baris)</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-primary/30 border border-primary/40 text-accent font-mono text-xs font-bold" x-text="guests.length + ' Tamu'">
                            0 Tamu
                        </span>
                    </div>

                    <!-- Fast Tools Bar -->
                    <div class="flex items-center gap-1.5 flex-wrap text-[11px] font-mono">
                        <button
                            type="button"
                            @click="insertSampleNames()"
                            class="px-2.5 py-1 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 border border-border-subtle transition"
                        >
                            + Contoh 5 Tamu
                        </button>
                        <button
                            type="button"
                            @click="cleanupDuplicates()"
                            class="px-2.5 py-1 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 border border-border-subtle transition"
                        >
                            Hapus Duplikat
                        </button>
                        <button
                            type="button"
                            @click="clearNames()"
                            class="px-2.5 py-1 rounded-lg bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 border border-rose-800/40 transition"
                        >
                            Kosongkan
                        </button>
                    </div>

                    <!-- Textarea -->
                    <div>
                        <textarea
                            x-model="inputText"
                            rows="14"
                            placeholder="Contoh:&#10;Bpk. Budi Santoso &amp; Keluarga&#10;Ibu Siti Aminah&#10;dr. Farhan Pratama, Sp.A&#10;Dimas &amp; Partner&#10;Sahabat SMA 1 Jakarta"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl p-3.5 text-xs font-mono text-cream focus:outline-none focus:border-primary transition leading-relaxed resize-y"
                        ></textarea>
                    </div>

                    <p class="text-[11px] text-neutral-400 font-mono">
                        💡 Tip: Anda bisa copy langsung 1 kolom nama tamu dari Excel atau chat WhatsApp lalu paste ke kotak ini.
                    </p>
                </div>

                <!-- WHATSAPP MESSAGE TEMPLATE ACCORDION -->
                <div x-data="{ openTemplate: false }" class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl space-y-3">
                    <div @click="openTemplate = !openTemplate" class="flex items-center justify-between cursor-pointer select-none">
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <h4 class="font-heading font-bold text-cream text-sm">Sesuaikan Format Chat WhatsApp</h4>
                        </div>
                        <i class="fa-solid text-xs text-neutral-400 transition-transform" :class="openTemplate ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </div>

                    <div x-show="openTemplate" x-collapse class="pt-3 border-t border-border-subtle space-y-3">
                        <div class="text-[11px] font-mono text-neutral-400 space-y-1">
                            <p class="font-bold text-neutral-300">Variabel yang tersedia:</p>
                            <div class="flex gap-2 flex-wrap">
                                <code class="px-1.5 py-0.5 rounded bg-night-bg text-accent text-[10px]">{nama_tamu}</code>
                                <code class="px-1.5 py-0.5 rounded bg-night-bg text-accent text-[10px]">{link_undangan}</code>
                                <code class="px-1.5 py-0.5 rounded bg-night-bg text-accent text-[10px]">{judul_acara}</code>
                                <code class="px-1.5 py-0.5 rounded bg-night-bg text-accent text-[10px]">{nama_mempelai}</code>
                            </div>
                        </div>

                        <textarea
                            x-model="waTemplate"
                            rows="9"
                            class="w-full bg-night-bg border border-border-subtle rounded-xl p-3 text-xs font-mono text-cream focus:outline-none focus:border-primary transition leading-relaxed"
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: BULK ACTION TOOLBAR & GENERATED GUEST LIST -->
            <div class="lg:col-span-7 space-y-4">
                <!-- HERO BULK ACTIONS CARD (Mempermudah Salin Seluruh Link) -->
                <div class="bg-gradient-to-br from-night-surface via-surface-card to-night-surface border-2 border-brand-amber/40 rounded-2xl p-5 shadow-2xl space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-primary/30 border border-brand-amber/40 text-accent font-mono text-[10px] font-bold uppercase tracking-wider">
                                ⚡ Fitur Utama Salin Masal
                            </span>
                            <h3 class="font-heading font-bold text-cream text-lg mt-1">
                                Salin Seluruh Link Undangan Sekaligus
                            </h3>
                            <p class="text-xs text-neutral-300 mt-0.5">
                                Klik salah satu tombol di bawah untuk menyalin seluruh link tamu secara instan:
                            </p>
                        </div>
                    </div>

                    <!-- 4 MAIN BULK ACTION BUTTONS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <!-- Button 1: Copy All Links (Plain List) -->
                        <button
                            type="button"
                            @click="copyAllLinks()"
                            class="group p-3.5 rounded-xl bg-primary hover:bg-primary-dark text-cream border border-white/20 shadow-md transition-all flex items-center gap-3 text-left cursor-pointer"
                        >
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-lg text-accent shrink-0 group-hover:scale-110 transition-transform">
                                📋
                            </div>
                            <div>
                                <span class="font-heading font-bold text-xs block text-cream">Salin Semua Link (List)</span>
                                <span class="text-[10px] font-mono text-neutral-300 block">Daftar nama &amp; link 1 per 1</span>
                            </div>
                        </button>

                        <!-- Button 2: Copy as Spreadsheet / Excel -->
                        <button
                            type="button"
                            @click="copyAsSpreadsheet()"
                            class="group p-3.5 rounded-xl bg-night-bg hover:bg-white/10 text-cream border border-border-subtle hover:border-brand-amber/40 shadow-md transition-all flex items-center gap-3 text-left cursor-pointer"
                        >
                            <div class="w-10 h-10 rounded-lg bg-emerald-950/80 border border-emerald-700/60 flex items-center justify-center text-lg text-emerald-400 shrink-0 group-hover:scale-110 transition-transform">
                                📑
                            </div>
                            <div>
                                <span class="font-heading font-bold text-xs block text-cream">Salin Format Excel / Sheet</span>
                                <span class="text-[10px] font-mono text-neutral-400 block">Langsung Ctrl+V di spreadsheet</span>
                            </div>
                        </button>

                        <!-- Button 3: Copy All WhatsApp Messages -->
                        <button
                            type="button"
                            @click="copyAllWaMessages()"
                            class="group p-3.5 rounded-xl bg-night-bg hover:bg-white/10 text-cream border border-border-subtle hover:border-emerald-700/60 shadow-md transition-all flex items-center gap-3 text-left cursor-pointer"
                        >
                            <div class="w-10 h-10 rounded-lg bg-emerald-950/80 border border-emerald-700/60 flex items-center justify-center text-lg text-emerald-400 shrink-0 group-hover:scale-110 transition-transform">
                                💬
                            </div>
                            <div>
                                <span class="font-heading font-bold text-xs block text-cream">Salin Semua Pesan WA</span>
                                <span class="text-[10px] font-mono text-neutral-400 block">Teks undangan lengkap tiap tamu</span>
                            </div>
                        </button>

                        <!-- Button 4: Download CSV File -->
                        <button
                            type="button"
                            @click="downloadCsv()"
                            class="group p-3.5 rounded-xl bg-night-bg hover:bg-white/10 text-cream border border-border-subtle hover:border-brand-amber/40 shadow-md transition-all flex items-center gap-3 text-left cursor-pointer"
                        >
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-lg text-accent shrink-0 group-hover:scale-110 transition-transform">
                                📥
                            </div>
                            <div>
                                <span class="font-heading font-bold text-xs block text-cream">Unduh File CSV</span>
                                <span class="text-[10px] font-mono text-neutral-400 block">File arsip tabel Excel (.csv)</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- LIVE GENERATED GUESTS TABLE -->
                <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-border-subtle">
                        <div>
                            <h3 class="font-heading font-bold text-cream text-base flex items-center gap-2">
                                <i class="fa-solid fa-list-check text-accent"></i>
                                <span>Hasil Tautan Undangan Personal</span>
                            </h3>
                            <p class="text-xs text-neutral-400">Total <span class="text-accent font-bold font-mono" x-text="guests.length">0</span> tamu terdeteksi</p>
                        </div>

                        <!-- Live Table Search Filter -->
                        <div class="relative w-full sm:w-60">
                            <input
                                type="text"
                                x-model="searchQuery"
                                placeholder="Cari nama tamu..."
                                class="w-full bg-night-bg border border-border-subtle rounded-xl px-3 py-1.5 pl-8 text-xs text-cream focus:outline-none focus:border-primary"
                            />
                            <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-xs text-neutral-500"></i>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto max-h-[500px] overflow-y-auto rounded-xl border border-border-subtle">
                        <table class="w-full text-left text-xs">
                            <thead class="text-neutral-400 border-b border-border-subtle text-[11px] uppercase tracking-wider bg-night-bg font-mono sticky top-0 z-10">
                                <tr>
                                    <th class="py-3 px-3 w-10 text-center">No</th>
                                    <th class="py-3 px-3">Nama Tamu Undangan</th>
                                    <th class="py-3 px-3">Link Personal (?to=...)</th>
                                    <th class="py-3 px-3 text-right">Aksi Cepat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-subtle bg-night-surface">
                                <template x-for="(guest, idx) in filteredGuests" :key="guest + idx">
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="py-3 px-3 text-center font-mono text-neutral-400 text-[11px]" x-text="idx + 1"></td>
                                        <td class="py-3 px-3">
                                            <span class="font-semibold text-cream text-xs block" x-text="guest"></span>
                                        </td>
                                        <td class="py-3 px-3 font-mono text-[11px] text-accent truncate max-w-xs">
                                            <a :href="getInvitationUrl(guest)" target="_blank" class="hover:underline" x-text="getInvitationUrl(guest)"></a>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Copy Link Button -->
                                                <button
                                                    type="button"
                                                    @click="copyToClipboard(getInvitationUrl(guest), `✅ Link untuk &quot;${guest}&quot; tersalin!`)"
                                                    class="p-1.5 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle transition text-xs"
                                                    title="Salin Link Personal"
                                                >
                                                    <i class="fa-solid fa-copy"></i>
                                                </button>

                                                <!-- Open Preview Tab -->
                                                <a
                                                    :href="getInvitationUrl(guest)"
                                                    target="_blank"
                                                    class="p-1.5 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle transition text-xs"
                                                    title="Pratinjau Halaman Live"
                                                >
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>

                                                <!-- Direct WhatsApp Chat -->
                                                <a
                                                    :href="getWaDirectUrl(guest)"
                                                    target="_blank"
                                                    class="p-1.5 rounded-lg bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 border border-emerald-700/60 transition text-xs"
                                                    title="Kirim Undangan via WhatsApp"
                                                >
                                                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                                </a>

                                                <!-- Delete Item -->
                                                <button
                                                    type="button"
                                                    @click="deleteGuest(guest)"
                                                    class="p-1.5 rounded-lg bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 border border-rose-800/40 transition text-xs"
                                                    title="Hapus dari Daftar"
                                                >
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <template x-if="guests.length === 0">
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-neutral-400 text-xs">
                                            <i class="fa-solid fa-clipboard-user text-3xl mb-2 text-neutral-600 block"></i>
                                            Belum ada nama tamu yang dimasukkan.
                                            <div class="mt-2">
                                                <button
                                                    type="button"
                                                    @click="insertSampleNames()"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary text-cream font-mono text-xs"
                                                >
                                                    + Masukkan Contoh 5 Nama Tamu
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
