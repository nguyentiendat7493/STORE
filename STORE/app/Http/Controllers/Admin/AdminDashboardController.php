<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalRevenue = Order::where('status', 'completed')->sum('final_price');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();

        $latestOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $lowStockVariants = ProductVariant::with(['product', 'size', 'color'])
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(10)
            ->get();

        $revenueByDay = Order::selectRaw('DATE(created_at) as date, SUM(final_price) as revenue')
            ->where('status', 'completed')
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('date')
            ->take(14)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'latestOrders',
            'lowStockVariants',
            'revenueByDay',
        ));
    }
}
