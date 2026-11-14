<?php

declare(strict_types=1);

namespace App\Domains\DigitalStory\Enums;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

enum StoryDurationPlan: string
{
    case ONE_MONTH = '1_month';
    case SIX_MONTHS = '6_months';
    case ONE_YEAR = '1_year';
    case LIFETIME = 'lifetime';

    public function label(): string
    {
        return match ($this) {
            self::ONE_MONTH => '1 Bulan (30 Hari)',
            self::SIX_MONTHS => '6 Bulan (180 Hari)',
            self::ONE_YEAR => '1 Tahun (365 Hari)',
            self::LIFETIME => 'Selamanya (Lifetime)',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::ONE_MONTH => '1 Bulan',
            self::SIX_MONTHS => '6 Bulan',
            self::ONE_YEAR => '1 Tahun',
            self::LIFETIME => 'Lifetime',
        };
    }

    public function durationDays(): ?int
    {
        return match ($this) {
            self::ONE_MONTH => 30,
            self::SIX_MONTHS => 180,
            self::ONE_YEAR => 365,
            self::LIFETIME => null,
        };
    }

    public function price(): int
    {
        return match ($this) {
            self::ONE_MONTH => 25_000,
            self::SIX_MONTHS => 75_000,
            self::ONE_YEAR => 120_000,
            self::LIFETIME => 250_000,
        };
    }

    public function priceFormatted(): string
    {
        return 'Rp ' . number_format($this->price(), 0, ',', '.');
    }

    public function calculateExpiry(?CarbonInterface $fromDate = null): ?CarbonImmutable
    {
        if ($this === self::LIFETIME) {
            return null;
        }

        $base = $fromDate ? CarbonImmutable::instance($fromDate) : CarbonImmutable::now();

        return match ($this) {
            self::ONE_MONTH => $base->addDays(30)->endOfDay(),
            self::SIX_MONTHS => $base->addDays(180)->endOfDay(),
            self::ONE_YEAR => $base->addDays(365)->endOfDay(),
            self::LIFETIME => null,
        };
    }
}
