<?php

declare(strict_types=1);

namespace App\Domains\Order\Controllers;

use App\Domains\Order\Actions\CustomerRespondApprovalAction;
use App\Domains\Order\Enums\OrderStatusEnum;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Requests\CustomerRespondApprovalRequest;
use App\Http\Controllers\Controller;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function index(Request $request): View
    {
        $code = trim((string) $request->query('code'));
        $order = null;

        if ($code !== '') {
            $order = Order::withTrashed()
                ->where('tracking_code', $code)
                ->orWhere('customer_phone', $code)
                ->with(['items.product', 'florist'])
                ->first();
        }

        $allSteps = OrderStatusEnum::trackingSteps();
        $statuses = OrderStatusEnum::cases();

        return view('client.tracking.index', compact('order', 'code', 'allSteps', 'statuses'));
    }

    public function respondApproval(
        CustomerRespondApprovalRequest $request,
        string $orderCode,
        CustomerRespondApprovalAction $action
    ): RedirectResponse {
        try {
            $action->execute($orderCode, (string) $request->validated('action'), $request->validated('note'));

            $msg = ($request->validated('action') === 'APPROVE')
                ? 'Terima kasih! Rangkaian buket bunga Anda telah disetujui dan segera dipersiapkan.'
                : 'Catatan revisi Anda telah tersimpan. Tim florist kami akan segera meninjau atau menghubungi Anda.';

            return redirect()->route('tracking.index', ['code' => $orderCode])
                ->with('status_message', $msg);
        } catch (DomainException $e) {
            return redirect()->route('tracking.index', ['code' => $orderCode])
                ->with('error', $e->getMessage());
        }
    }
}
