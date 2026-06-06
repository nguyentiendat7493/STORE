<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with(['user', 'payment'])
            ->search($request->string('q')->toString())
            ->status($request->string('status')->toString())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'coupon', 'details.productVariant.product', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipping,completed,cancelled'],
        ]);

        $order->update($data);

        if ($data['status'] === 'completed') {
            $order->payment?->update(['payment_status' => 'paid', 'paid_at' => now()]);
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }
}
