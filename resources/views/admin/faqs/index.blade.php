<x-layouts.admin title="Tanya Jawab (FAQ)" header="Manajemen Tanya Jawab (FAQ)">
    <!-- Header Action & Overview -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-dark flex items-center gap-2.5">
                <span>❓ Tanya Jawab Pelanggan (FAQ)</span>
            </h1>
            <p class="text-xs sm:text-sm text-dark/60 mt-1 max-w-2xl">
                Kelola daftar pertanyaan yang sering diajukan seputar sameday delivery, live photo approval, bunga segar, garansi, dan pesanan kustom. FAQ ini tampil secara interaktif pada website.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.faqs.create') }}"
                class="px-5 py-2.5 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-bold text-xs font-body shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer active:scale-95"
            >
                <span class="text-base">+</span>
                <span>Tambah Pertanyaan FAQ</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="mb-6 p-4 rounded-3xl bg-white border border-dark/10 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.faqs.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari pertanyaan / kata kunci..."
                class="rounded-xl bg-cream-light/60 border border-dark/15 px-3 py-1.5 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary"
            />

            <select
                name="category"
                class="rounded-xl bg-cream-light/60 border border-dark/15 px-3 py-1.5 text-xs text-dark focus:outline-none focus:border-primary"
            >
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-1.5 rounded-xl bg-primary text-cream text-xs font-mono font-medium hover:bg-primary-dark transition cursor-pointer">
                Filter
            </button>

            @if (request()->hasAny(['q', 'category']))
                <a href="{{ route('admin.faqs.index') }}" class="text-xs text-rose-600 hover:underline font-mono">
                    Reset
                </a>
            @endif
        </form>

        <span class="text-xs font-mono text-dark/60">
            Total: <strong>{{ $faqs->total() }}</strong> pertanyaan
        </span>
    </div>

    <!-- FAQs Table / Card List -->
    @if ($faqs->isEmpty())
        <div class="p-12 text-center rounded-3xl bg-white border border-dark/10">
            <span class="text-4xl block mb-2">🌿</span>
            <h3 class="font-heading text-lg font-bold text-dark">Belum Ada Pertanyaan FAQ</h3>
            <p class="text-xs text-dark/60 mt-1 max-w-sm mx-auto">
                Mulai tambahkan pertanyaan umum seputar pemesanan buket dan pengiriman untuk mempermudah calon pembeli.
            </p>
            <a
                href="{{ route('admin.faqs.create') }}"
                class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-primary text-cream text-xs font-bold font-body"
            >
                + Tambah FAQ Pertama
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($faqs as $faq)
                <div class="p-5 rounded-3xl bg-white border border-primary/10 hover:border-primary/30 transition shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-primary/10 text-primary border border-primary/20">
                                {{ $faq->category }}
                            </span>
                            <span class="text-[10px] font-mono text-dark/40">
                                Urutan: #{{ $faq->sort_order }}
                            </span>

                            @if ($faq->is_active)
                                <span class="px-2 py-0.2 rounded-full text-[9px] font-mono bg-emerald-100 text-emerald-800 font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="px-2 py-0.2 rounded-full text-[9px] font-mono bg-rose-100 text-rose-800 font-semibold">
                                    Disembunyikan
                                </span>
                            @endif
                        </div>

                        <h3 class="font-heading text-base font-bold text-dark">
                            {{ $faq->question }}
                        </h3>

                        <p class="text-xs text-dark/70 font-body leading-relaxed line-clamp-2">
                            {{ $faq->answer }}
                        </p>
                    </div>

                    <!-- Action Controls -->
                    <div class="flex items-center gap-2 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-dark/10">
                        <!-- Toggle Button -->
                        <form action="{{ route('admin.faqs.toggle', $faq) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="px-3 py-1.5 rounded-xl text-xs font-mono transition cursor-pointer {{ $faq->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-300' }}"
                                title="Ubah status tayang"
                            >
                                {{ $faq->is_active ? 'Sembunyikan' : 'Tayangkan' }}
                            </button>
                        </form>

                        <!-- Edit Button -->
                        <a
                            href="{{ route('admin.faqs.edit', $faq) }}"
                            class="px-3 py-1.5 rounded-xl bg-cream-light hover:bg-cream text-dark border border-dark/15 text-xs font-mono font-bold transition"
                        >
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan FAQ ini?');">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-mono font-bold transition cursor-pointer"
                            >
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $faqs->links() }}
        </div>
    @endif
</x-layouts.admin>
