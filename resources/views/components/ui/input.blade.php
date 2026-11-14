@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'hint' => null,
    'mono' => false,
])

<div class="w-full">
    @if ($label)
        <label for="{{ $name }}" class="block text-xs font-semibold uppercase tracking-wider text-dark/70 dark:text-cream/70 mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-rose-600 dark:text-rose-400">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border ' . ($errors->has($name) || $error ? 'border-rose-400 dark:border-rose-600 focus:ring-rose-400 focus:border-rose-400' : 'border-dark/15 dark:border-night-border focus:border-primary dark:focus:border-accent focus:ring-primary dark:focus:ring-accent') . ' bg-white/90 dark:bg-night-card px-4 py-2.5 text-sm text-dark dark:text-cream placeholder:text-dark/40 dark:placeholder:text-cream/40 shadow-xs transition duration-200 focus:outline-none focus:ring-2 focus:ring-opacity-20 ' . ($mono ? 'font-mono' : 'font-body')
            ]) }}
        />
    </div>

    @if ($hint && !$errors->has($name) && !$error)
        <p class="mt-1 text-xs text-dark/50 dark:text-cream/50">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
    @else
        @if ($error)
            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $error }}</p>
        @endif
    @enderror
</div>
