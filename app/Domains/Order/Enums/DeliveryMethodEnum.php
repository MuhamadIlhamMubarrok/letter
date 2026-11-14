<?php

declare(strict_types=1);

namespace App\Domains\Order\Enums;

enum DeliveryMethodEnum: string
{
    case DELIVERY = 'DELIVERY';
    case PICKUP = 'PICKUP';

    public function label(): string
    {
        return match ($this) {
            self::DELIVERY => 'Kirim Kurir (Delivery)',
            self::PICKUP => 'Ambil di Toko (Self Pick-up)',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::DELIVERY => 'bg-secondary/15 text-secondary-dark border-secondary/30 dark:bg-secondary/20 dark:text-accent',
            self::PICKUP => 'bg-brand-amber/15 text-brand-amber border-brand-amber/30 dark:bg-brand-amber/20 dark:text-cream',
        };
    }
}
