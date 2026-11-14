<?php

declare(strict_types=1);

namespace App\Domains\Order\Enums;

enum CustomerApprovalStatusEnum: string
{
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REVISION_REQUESTED = 'REVISION_REQUESTED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu Approval Foto',
            self::APPROVED => 'Disetujui oleh Customer',
            self::REVISION_REQUESTED => 'Customer Meminta Revisi',
        };
    }
}
