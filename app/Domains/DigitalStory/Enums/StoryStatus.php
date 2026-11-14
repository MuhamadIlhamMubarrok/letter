<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

enum StoryStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Konsep (Draft)',
            self::ACTIVE => 'Aktif (Live)',
            self::EXPIRED => 'Kedaluwarsa (Expired)',
            self::ARCHIVED => 'Diarsipkan (Archived)',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-white/10 text-cream/70 border-white/20',
            self::ACTIVE => 'bg-primary/20 text-accent border-accent/30',
            self::EXPIRED => 'bg-brand-danger/15 text-brand-danger border-brand-danger/30',
            self::ARCHIVED => 'bg-dark-muted/20 text-cream/50 border-dark-muted/30',
        };
    }

    public function dotClasses(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-cream/50',
            self::ACTIVE => 'bg-emerald-400 animate-pulse',
            self::EXPIRED => 'bg-brand-danger',
            self::ARCHIVED => 'bg-cream/30',
        };
    }
}
