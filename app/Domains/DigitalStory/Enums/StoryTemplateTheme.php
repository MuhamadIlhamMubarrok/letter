<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

enum StoryTemplateTheme: string
{
    case ROMANTIC_ROSE = 'romantic_rose';
    case RUSTIC_BOTANICAL = 'rustic_botanical';
    case MODERN_EMERALD = 'modern_emerald';
    case CLASSIC_GOLD = 'classic_gold';

    public function label(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'Romantic Rose (Nuansa Mawar Romantis)',
            self::RUSTIC_BOTANICAL => 'Rustic Botanical (Klasik Alam & Dedauan)',
            self::MODERN_EMERALD => 'Modern Emerald (Keanggunan Hijau Maja)',
            self::CLASSIC_GOLD => 'Classic Gold (Emas Mewah & Hangat)',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'Romantic Rose',
            self::RUSTIC_BOTANICAL => 'Rustic Botanical',
            self::MODERN_EMERALD => 'Modern Emerald',
            self::CLASSIC_GOLD => 'Classic Gold',
        };
    }

    public function accentHex(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => '#E11D48',
            self::RUSTIC_BOTANICAL => '#79AE6F',
            self::MODERN_EMERALD => '#346739',
            self::CLASSIC_GOLD => '#D97706',
        };
    }

    public function borderToken(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'border-brand-rose/30',
            self::RUSTIC_BOTANICAL => 'border-secondary/40',
            self::MODERN_EMERALD => 'border-primary/50',
            self::CLASSIC_GOLD => 'border-brand-amber/40',
        };
    }

    public function glowToken(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'shadow-brand-rose/20',
            self::RUSTIC_BOTANICAL => 'shadow-secondary/20',
            self::MODERN_EMERALD => 'shadow-primary/30',
            self::CLASSIC_GOLD => 'shadow-brand-amber/20',
        };
    }

    public function envelopeColorClass(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'bg-gradient-to-br from-rose-950 via-[#182218] to-rose-900 border-rose-500/30',
            self::RUSTIC_BOTANICAL => 'bg-gradient-to-br from-night-surface via-[#202b20] to-night-bg border-secondary/30',
            self::MODERN_EMERALD => 'bg-gradient-to-br from-primary-dark via-primary to-night-bg border-accent/40',
            self::CLASSIC_GOLD => 'bg-gradient-to-br from-[#1d1912] via-night-surface to-[#241d13] border-brand-amber/35',
        };
    }

    public function sealColorClass(): string
    {
        return match ($this) {
            self::ROMANTIC_ROSE => 'bg-rose-700 text-rose-100 border-rose-400',
            self::RUSTIC_BOTANICAL => 'bg-primary-dark text-cream border-secondary',
            self::MODERN_EMERALD => 'bg-primary text-cream border-accent',
            self::CLASSIC_GOLD => 'bg-amber-700 text-cream-light border-amber-400',
        };
    }
}
