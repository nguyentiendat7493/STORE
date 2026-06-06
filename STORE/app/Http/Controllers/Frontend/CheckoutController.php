<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = $this->currentCart();
        $cart->load('items.productVariant.product.images', 'items.productVariant.size', 'items.productVariant.color');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng của bạn đang trống.']);
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
            'payment_method' => ['required', 'in:cod,bank_transfer,momo,vnpay'],
        ]);

        $cart = $this->currentCart();
        $cart->load('items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng của bạn đang trống.']);
        }

        try {
            $order = DB::transaction(function () use ($cart, $data) {
                $total = 0;

                foreach ($cart->items as $item) {
                    $variant = ProductVariant::whereKey($item->product_variant_id)->lockForUpdate()->firstOrFail();

                    if ($variant->stock < $item->quantity) {
                        throw new RuntimeException('Không đủ tồn kho cho SKU '.$variant->sku);
                    }

                    $total += (float) $variant->price * $item->quantity;
                }

                $coupon = $this->findActiveCoupon($data['coupon_code'] ?? null);
                $discount = $coupon ? $this->calculateDiscount($coupon, $total) : 0;
                $finalPrice = max($total - $discount, 0);

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'coupon_id' => $coupon?->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_address' => $data['customer_address'],
                    'total_price' => $total,
                    'discount_amount' => $discount,
                    'final_price' => $finalPrice,
                    'status' => 'pending',
                ]);

                foreach ($cart->items as $item) {
                    $variant = ProductVariant::with(['product', 'size', 'color'])->lockForUpdate()->findOrFail($item->product_variant_id);

                    $order->details()->create([
                        'product_variant_id' => $variant->id,
                        'product_name' => $variant->product->name,
                        'size_name' => $variant->size?->name,
                        'color_name' => $variant->color?->name,
                        'price' => $variant->price,
                        'quantity' => $item->quantity,
                        'subtotal' => (float) $variant->price * $item->quantity,
                    ]);

                    $variant->decrement('stock', $item->quantity);
                }

                $order->payment()->create([
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'unpaid',
                ]);

                $cart->items()->delete();

                return $order;
            });
        } catch (RuntimeException $exception) {
            return back()->withErrors(['stock' => $exception->getMessage()])->withInput();
        }

        return redirect()->route('orders.show', $order)->with('success', 'Đã tạo đơn hàng thành công.');
    }

    private function currentCart(): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    private function findActiveCoupon(?string $code): ?Coupon
    {
        if (! $code) {
            return null;
        }

        return Coupon::active()->where('code', $code)->first();
    }

    private function calculateDiscount(Coupon $coupon, float $total): float
    {
        if ($coupon->discount_type === 'percent') {
            return min($total * ((float) $coupon->discount_value / 100), $total);
        }

        return min((float) $coupon->discount_value, $total);
    }
}
