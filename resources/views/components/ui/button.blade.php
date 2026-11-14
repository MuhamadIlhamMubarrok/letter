@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer shadow-sm active:scale-95';

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3.5 text-base',
        default => 'px-5 py-2.5 text-sm',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-secondary hover:bg-secondary-dark text-white focus:ring-secondary',
        'cream' => 'bg-cream dark:bg-night-card hover:bg-cream-dark dark:hover:bg-white/10 text-dark dark:text-cream border border-cream-dark dark:border-night-border focus:ring-cream-dark',
        'outline' => 'bg-transparent border border-primary dark:border-accent text-primary dark:text-accent hover:bg-primary dark:hover:bg-accent hover:text-cream dark:hover:text-night-bg focus:ring-primary',
        'outline-white' => 'bg-transparent border border-cream text-cream hover:bg-cream hover:text-primary focus:ring-cream',
        'danger' => 'bg-rose-700 hover:bg-rose-800 text-white focus:ring-rose-500',
        'ghost' => 'bg-transparent text-dark dark:text-cream hover:bg-black/5 dark:hover:bg-white/5 focus:ring-primary shadow-none',
        default => 'bg-primary dark:bg-accent hover:bg-primary-dark dark:hover:bg-accent/90 text-cream dark:text-night-bg focus:ring-primary dark:focus:ring-accent',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
