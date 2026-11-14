<?php

declare(strict_types=1);

namespace App\Domains\Order\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case QUEUE = 'queue';
    case IN_PRODUCTION = 'in_production';
    case READY = 'ready';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu Pembayaran',
            self::PAID => 'Pembayaran Terverifikasi',
            self::QUEUE => 'Antrian Meja Florist',
            self::IN_PRODUCTION => 'Sedang Dirangkai Florist',
            self::READY => 'Buket Selesai (Siap Kirim / Ambil)',
            self::COMPLETED => 'Pesanan Selesai / Diterima',
            self::CANCELLED => 'Pesanan Dibatalkan',
        };
    }

    public function stepIndex(): int
    {
        return match ($this) {
            self::PENDING => 1,
            self::PAID => 1,
            self::QUEUE => 2,
            self::IN_PRODUCTION => 2,
            self::READY => 3,
            self::COMPLETED => 4,
            self::CANCELLED => 0,
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::PENDING => 'bg-brand-amber/15 text-brand-amber border-brand-amber/30 dark:bg-brand-amber/20 dark:text-cream',
            self::PAID => 'bg-secondary/15 text-secondary-dark border-secondary/30 dark:bg-secondary/20 dark:text-accent',
            self::QUEUE => 'bg-brand-amber/20 text-brand-amber border-brand-amber/40 dark:bg-brand-amber/30 dark:text-cream',
            self::IN_PRODUCTION => 'bg-brand-indigo/15 text-brand-indigo border-brand-indigo/30 dark:bg-brand-indigo/25 dark:text-cream animate-pulse',
            self::READY => 'bg-accent/20 text-primary-dark dark:text-accent border-accent/40 font-bold',
            self::COMPLETED => 'bg-primary text-cream border-primary-dark',
            self::CANCELLED => 'bg-brand-danger/15 text-brand-danger border-brand-danger/30 dark:bg-brand-danger/25 dark:text-cream',
        };
    }

    /**
     * @return array<int, array{key: string, label: string, step: int}>
     */
    public static function trackingSteps(): array
    {
        return [
            ['key' => 'verified', 'label' => 'Pesanan Terverifikasi', 'step' => 1],
            ['key' => 'production', 'label' => 'Dirangkai Florist', 'step' => 2],
            ['key' => 'ready', 'label' => 'Buket Selesai (QC)', 'step' => 3],
            ['key' => 'completed', 'label' => 'Selesai / Diterima', 'step' => 4],
        ];
    }
}
