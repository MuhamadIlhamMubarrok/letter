<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Controller;

use App\Admin\Product\Model\Product;
use App\Domains\Order\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\CustomerStory;
use App\Models\FreshFlower;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $buckflowAppUrl = rtrim((string) config('services.buckflow.url', env('BUCKFLOW_APP_URL', 'http://127.0.0.1:8000')), '/');

        try {
            $activeOrdersCount = Order::withTrashed()->whereIn('status', ['paid', 'queue', 'in_production', 'ready'])->count();
            $completedOrdersCount = Order::withTrashed()->where('status', 'completed')->count();
            $totalRevenue = (float) Order::withTrashed()->where('payment_status', 'paid')->sum('total_amount');
            $recentOrders = Order::withTrashed()->latest('id')->take(5)->with(['items.product'])->get();
        } catch (\Throwable) {
            $activeOrdersCount = 0;
            $completedOrdersCount = 0;
            $totalRevenue = 0.0;
            $recentOrders = collect();
        }

        $stats = [
            'total_products' => Product::count(),
            'active_orders' => $activeOrdersCount,
            'completed_orders' => $completedOrdersCount,
            'total_revenue' => $totalRevenue,
            'photo_approval_needed' => 0,
        ];

        $storiesCount = CustomerStory::where('is_published', true)->count();
        $freshFlowersCount = FreshFlower::where('is_active', true)->count();
        $totalFreshStems = (int) FreshFlower::where('is_active', true)->sum('stock_stems');

        return view('admin.dashboard.index', compact(
            'stats',
            'recentOrders',
            'storiesCount',
            'freshFlowersCount',
            'totalFreshStems',
            'buckflowAppUrl'
        ));
    }
}
