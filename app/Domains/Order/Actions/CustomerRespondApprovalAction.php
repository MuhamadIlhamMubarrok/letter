<?php

declare(strict_types=1);

namespace App\Domains\Order\Actions;

use App\Domains\Order\Models\Order;
use DomainException;
use Illuminate\Support\Facades\DB;

final class CustomerRespondApprovalAction
{
    public function execute(string $trackingCode, string $action, ?string $note = null): Order
    {
        return DB::connection('buckflow')->transaction(function () use ($trackingCode, $action, $note): Order {
            $order = Order::withTrashed()
                ->where('tracking_code', $trackingCode)
                ->first();

            if (!$order) {
                throw new DomainException("Pesanan dengan nomor resi [{$trackingCode}] tidak ditemukan.");
            }

            if ($action === 'APPROVE') {
                $approvalNote = "\n[Approval Customer: Disetujui pada " . now()->format('d M Y H:i') . ' WIB]';
                $order->update([
                    'notes' => trim(($order->notes ?? '') . $approvalNote),
                ]);
            } elseif ($action === 'REVISE') {
                $revNote = "\n[Catatan Revisi Customer (" . now()->format('d M Y H:i') . ' WIB): ' . ($note ?: 'Mohon penyesuaian detail buket') . ']';
                $order->update([
                    'notes' => trim(($order->notes ?? '') . $revNote),
                ]);
            } else {
                throw new DomainException("Aksi respon approval [{$action}] tidak valid.");
            }

            return $order;
        });
    }
}
