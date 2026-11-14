<?php

declare(strict_types=1);

namespace App\Domains\Auth\Enums;

enum UserRoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case FLORIST = 'florist';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::FLORIST => 'Florist Atelier',
            self::USER => 'Pelanggan',
        };
    }

    public function isAdmin(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::ADMIN], true);
    }
}
