<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->status($request->string('status')->toString())
            ->with('payment')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorizeOrder($order);

        $order->load('details.productVariant.product.images', 'payment', 'coupon');

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        if (! $order->can_cancel) {
            return back()->withErrors(['order' => 'Chỉ có thể hủy đơn hàng đang chờ xác nhận.']);
        }

        $order->load('details.productVariant');

        foreach ($order->details as $detail) {
            $detail->productVariant?->increment('stock', $detail->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy đơn hàng.');
    }

    private function authorizeOrder(Order $order): void
    {
        abort_if($order->user_id !== Auth::id(), 403);
    }
}
