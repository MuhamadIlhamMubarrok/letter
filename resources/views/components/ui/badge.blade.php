@props([
    'variant' => 'default',
    'mono' => true,
    'size' => 'sm',
])

@php
    $baseClasses = 'inline-flex items-center gap-1 font-medium rounded-full border';

    $sizeClasses = match ($size) {
        'xs' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-3.5 py-1 text-xs',
        default => 'px-2.5 py-0.5 text-xs',
    };

    $fontClass = $mono ? 'font-mono' : 'font-body';

    $variantClasses = match ($variant) {
        'primary' => 'bg-primary/10 dark:bg-primary/20 text-primary dark:text-accent border-primary/20 dark:border-primary/40',
        'secondary' => 'bg-secondary/15 dark:bg-secondary/25 text-primary dark:text-accent border-secondary/30',
        'accent' => 'bg-accent/25 dark:bg-accent/20 text-primary-dark dark:text-accent border-accent/40',
        'cream' => 'bg-cream dark:bg-night-card text-dark dark:text-cream border-cream-dark dark:border-night-border',
        'dark' => 'bg-dark text-cream border-dark dark:bg-white/10 dark:border-white/20',
        'amber' => 'bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border-amber-300 dark:border-amber-800',
        'emerald' => 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border-emerald-300 dark:border-emerald-800',
        'rose' => 'bg-rose-100 dark:bg-rose-950/40 text-rose-800 dark:text-rose-300 border-rose-300 dark:border-rose-800',
        'purple' => 'bg-purple-100 dark:bg-purple-950/40 text-purple-800 dark:text-purple-300 border-purple-300 dark:border-purple-800',
        default => 'bg-white/80 dark:bg-night-card text-dark dark:text-cream border-black/10 dark:border-night-border backdrop-blur-xs',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$fontClass} {$variantClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
