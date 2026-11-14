@props([
    'label' => 'Unggah Foto',
    'name' => 'preview_photo',
    'required' => false,
    'multiple' => false,
    'hint' => 'Format file: JPG, PNG, WEBP hingga 10MB',
    'currentImage' => null,
])

<div x-data="{ previewUrl: '{{ $currentImage ?? '' }}', fileName: '' }" class="w-full">
    @if ($label)
        <label class="block text-xs font-semibold uppercase tracking-wider text-dark/70 mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-rose-600">*</span>
            @endif
        </label>
    @endif

    <div class="relative border-2 border-dashed border-primary/30 hover:border-primary rounded-2xl bg-white/60 p-5 text-center transition duration-200">
        <input
            type="file"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            accept="image/*"
            capture="environment"
            @change="
                const file = $event.target.files[0];
                if (file) {
                    fileName = file.name;
                    previewUrl = URL.createObjectURL(file);
                }
            "
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
        />

        <template x-if="previewUrl">
            <div class="flex flex-col items-center gap-2">
                <img :src="previewUrl" alt="Preview" class="h-32 w-32 object-cover rounded-xl shadow-md border border-cream-dark" />
                <p class="text-xs text-primary font-medium" x-text="fileName ? 'Dipilih: ' + fileName : 'Foto saat ini'"></p>
                <span class="text-[11px] text-dark/50">Klik atau seret file lain untuk mengganti</span>
            </div>
        </template>

        <template x-if="!previewUrl">
            <div class="flex flex-col items-center justify-center py-2 text-dark/60">
                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-dark">Klik untuk ambil foto / pilih dari perangkat</span>
                <span class="text-xs text-dark/40 mt-1">{{ $hint }}</span>
            </div>
        </template>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
    @enderror
</div>
