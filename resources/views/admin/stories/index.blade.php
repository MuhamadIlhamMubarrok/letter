<x-layouts.admin title="Manajemen Cerita Pelanggan" header="Cerita & Testimoni Pelanggan">
    <!-- Action Bar & Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-heading text-lg font-bold text-dark">Daftar Momen Bahagia & Testimoni</h3>
            <p class="text-xs text-dark/60 font-body">Kelola foto polaroid, cerita pelanggan, momen wisuda/anniversary yang tampil di halaman utama.</p>
        </div>
        <x-ui.button href="{{ route('admin.stories.create') }}" variant="primary" size="md">
            <span>+ Tambah Cerita Pelanggan</span>
        </x-ui.button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-surface p-4 rounded-2xl border border-primary/10 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-mono uppercase tracking-wider text-dark/50">Total Cerita</span>
                <p class="text-2xl font-bold font-heading text-dark mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-lg">
                📸
            </div>
        </div>
        <div class="bg-surface p-4 rounded-2xl border border-emerald-500/20 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-mono uppercase tracking-wider text-emerald-600 font-semibold">Aktif di Website</span>
                <p class="text-2xl font-bold font-heading text-emerald-700 mt-0.5">{{ $stats['published'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                ✨
            </div>
        </div>
        <div class="bg-surface p-4 rounded-2xl border border-amber-500/20 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-mono uppercase tracking-wider text-amber-600 font-semibold">Draf / Tersembunyi</span>
                <p class="text-2xl font-bold font-heading text-amber-700 mt-0.5">{{ $stats['draft'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                🔒
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface p-4 rounded-2xl border border-primary/10 shadow-xs mb-6">
        <form action="{{ route('admin.stories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pelanggan, momen acara (wisuda, ultah...), atau isi cerita..."
                    class="w-full bg-cream-light/60 border border-dark/15 rounded-xl px-4 py-2 text-xs text-dark placeholder:text-dark/40 focus:outline-none focus:border-primary font-body"
                />
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-cream font-semibold text-xs hover:bg-primary-dark transition cursor-pointer">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 rounded-xl bg-dark/10 text-dark font-medium text-xs hover:bg-dark/20 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Stories Table -->
    <div class="bg-surface rounded-3xl border border-primary/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead class="bg-cream-light/60 font-mono text-[11px] uppercase tracking-wider text-dark/60 border-b border-dark/10">
                    <tr>
                        <th class="py-3.5 px-6">Foto Polaroid</th>
                        <th class="py-3.5 px-6">Pelanggan & Momen</th>
                        <th class="py-3.5 px-6">Kisah / Testimoni</th>
                        <th class="py-3.5 px-6">Rating</th>
                        <th class="py-3.5 px-6 text-center">Urutan</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark/5">
                    @forelse ($stories as $story)
                        <tr class="hover:bg-cream/30 transition">
                            <!-- Polaroid Photo Thumbnail -->
                            <td class="py-4 px-6">
                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-cream-light border border-dark/15 shadow-2xs shrink-0">
                                    <img
                                        src="{{ $story->image_url }}"
                                        alt="{{ $story->customer_name }}"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </td>

                            <!-- Customer Name & Event -->
                            <td class="py-4 px-6">
                                <h4 class="font-heading text-sm font-bold text-dark">
                                    {{ $story->customer_name }}
                                </h4>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-mono bg-primary/10 text-primary border border-primary/20">
                                    {{ $story->event_title }}
                                </span>
                            </td>

                            <!-- Story Quote -->
                            <td class="py-4 px-6 max-w-sm">
                                <p class="text-xs text-dark/80 italic line-clamp-2 leading-relaxed">
                                    "{{ $story->story }}"
                                </p>
                            </td>

                            <!-- Rating -->
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center text-amber-400 text-xs">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $story->rating)
                                            ★
                                        @else
                                            <span class="text-dark/20">★</span>
                                        @endif
                                    @endfor
                                    <span class="font-mono text-[10px] text-dark/50 ml-1.5">({{ $story->rating }}/5)</span>
                                </div>
                            </td>

                            <!-- Sort Order -->
                            <td class="py-4 px-6 text-center font-mono font-semibold text-dark/70">
                                #{{ $story->sort_order }}
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <form action="{{ route('admin.stories.toggle', $story->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        title="Klik untuk mengubah status"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-mono font-semibold transition cursor-pointer {{ $story->is_published ? 'bg-emerald-100 text-emerald-800 border border-emerald-300 hover:bg-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-300 hover:bg-gray-200' }}"
                                    >
                                        {{ $story->is_published ? '● Tampil di Web' : '○ Draf' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.stories.edit', $story->id) }}"
                                        class="px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-cream text-primary text-xs font-semibold transition"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.stories.destroy', $story->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita pelanggan dari {{ addslashes($story->customer_name) }}?')"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-semibold transition cursor-pointer"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-dark/50 font-body">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-3xl mb-2">🌸</span>
                                    <p class="text-sm font-semibold text-dark">Belum ada cerita pelanggan</p>
                                    <p class="text-xs text-dark/40 mt-1">Klik tombol "+ Tambah Cerita Pelanggan" untuk menambahkan momen bahagia pertama.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($stories->hasPages())
            <div class="p-4 border-t border-dark/10">
                {{ $stories->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
