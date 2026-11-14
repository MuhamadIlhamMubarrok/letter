<x-layouts.admin title="Filosofi & Makna Bunga" header="Manajemen Filosofi & Makna Bunga">
    <!-- Header Action & Overview -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-dark flex items-center gap-2.5">
                <span>🌿 Filosofi & Makna Bunga</span>
            </h1>
            <p class="text-xs sm:text-sm text-dark/60 mt-1 max-w-2xl">
                Kelola kartu filosofi bunga (seperti Red Rose, Casablanca Lily, Sunflower, Baby's Breath) yang tampil pada seksi "Filosofi & Cerita Atelier" di beranda website.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.philosophies.create') }}"
                class="px-5 py-2.5 rounded-2xl bg-primary hover:bg-primary-dark text-cream font-bold text-xs font-body shadow-md hover:shadow-lg transition flex items-center gap-2 cursor-pointer active:scale-95"
            >
                <span class="text-base">+</span>
                <span>Tambah Filosofi Bunga</span>
            </a>
        </div>
    </div>

    <!-- Philosophies List -->
    @if ($philosophies->isEmpty())
        <div class="p-12 text-center rounded-3xl bg-white border border-dark/10">
            <span class="text-4xl block mb-2">🌸</span>
            <h3 class="font-heading text-lg font-bold text-dark">Belum Ada Data Filosofi Bunga</h3>
            <p class="text-xs text-dark/60 mt-1 max-w-sm mx-auto">
                Tambahkan makna dan filosofi bunga untuk menginspirasi pelanggan dalam memilih buket terbaik.
            </p>
            <a
                href="{{ route('admin.philosophies.create') }}"
                class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-primary text-cream text-xs font-bold font-body"
            >
                + Tambah Bunga Pertama
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($philosophies as $phil)
                <div class="p-6 rounded-3xl bg-white border border-primary/10 hover:border-primary/30 transition shadow-2xs flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-dark/10">
                            <span class="text-3xl">{{ $phil->emoji_or_icon }}</span>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[10px] font-mono text-dark/40">
                                    Urutan: #{{ $phil->sort_order }}
                                </span>
                                @if ($phil->is_active)
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-mono bg-emerald-100 text-emerald-800 font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-mono bg-rose-100 text-rose-800 font-semibold">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="font-heading text-lg font-bold text-dark">
                            {{ $phil->flower_name }}
                        </h3>
                        @if ($phil->scientific_name)
                            <span class="text-[11px] font-mono italic text-secondary-dark block mt-0.5">
                                {{ $phil->scientific_name }}
                            </span>
                        @endif

                        <div class="mt-2.5 p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/60">
                            <span class="text-[11px] font-mono text-amber-900 font-semibold block">
                                Makna: {{ $phil->meaning }}
                            </span>
                        </div>

                        <p class="text-xs text-dark/70 font-body mt-3 leading-relaxed line-clamp-3">
                            {{ $phil->description }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-3 border-t border-dark/10">
                        <!-- Toggle -->
                        <form action="{{ route('admin.philosophies.toggle', $phil) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="text-xs font-mono underline text-dark/60 hover:text-dark cursor-pointer"
                            >
                                {{ $phil->is_active ? 'Sembunyikan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('admin.philosophies.edit', $phil) }}"
                                class="px-3 py-1.5 rounded-xl bg-cream-light hover:bg-cream text-dark border border-dark/15 text-xs font-mono font-bold transition"
                            >
                                Edit
                            </a>

                            <form action="{{ route('admin.philosophies.destroy', $phil) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus filosofi bunga ini?');">
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
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $philosophies->links() }}
        </div>
    @endif
</x-layouts.admin>
