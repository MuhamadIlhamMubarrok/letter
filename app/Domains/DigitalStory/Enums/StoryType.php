<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

enum StoryType: string
{
    case LOVE_LETTER = 'love_letter';
    case WEDDING_INVITATION = 'wedding_invitation';

    public function label(): string
    {
        return match ($this) {
            self::LOVE_LETTER => 'Surat Cinta Interaktif (Love Letter)',
            self::WEDDING_INVITATION => 'Undangan Pernikahan (Wedding Invitation)',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::LOVE_LETTER => 'Love Letter',
            self::WEDDING_INVITATION => 'Wedding Invitation',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::LOVE_LETTER => 'Template surat cinta romantis dengan animasi amplop, love counter, pemutar lagu, dan foto polaroid kenangan.',
            self::WEDDING_INVITATION => 'Template undangan pernikahan online dengan countdown acara, maps lokasi, cerita cinta, galeri foto, dan formulir RSVP ucapan.',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LOVE_LETTER => '💌',
            self::WEDDING_INVITATION => '💍',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::LOVE_LETTER => 'bg-brand-rose/15 text-brand-rose border-brand-rose/25',
            self::WEDDING_INVITATION => 'bg-brand-emerald/15 text-accent border-accent/25',
        };
    }
}
