<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ProductVariant;
use App\Models\ShippingMethod;
use App\Models\UserAddress;
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

        $shippingMethods = ShippingMethod::active()->get();
        $paymentMethods = PaymentMethod::active()
            ->whereIn('code', ['cod', 'bank_transfer', 'momo', 'vnpay'])
            ->get();
        $addresses = Auth::user()->addresses()->defaultFirst()->get();

        return view('checkout.index', compact('cart', 'shippingMethods', 'paymentMethods', 'addresses'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $cart = $this->currentCart();
        $cart->load('items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng của bạn đang trống.']);
        }

        try {
            $order = DB::transaction(function () use ($cart, $data, $request) {
                $total = 0;

                foreach ($cart->items as $item) {
                    $variant = ProductVariant::whereKey($item->product_variant_id)->lockForUpdate()->firstOrFail();

                    if ($variant->stock < $item->quantity) {
                        throw new RuntimeException('Không đủ tồn kho cho SKU '.$variant->sku);
                    }

                    $total += (float) $variant->price * $item->quantity;
                }

                $coupon = $this->findActiveCoupon($data['coupon_code'] ?? null);
                $selectedAddress = $this->findUserAddress($data['address_id'] ?? null);
                $discount = $coupon ? $this->calculateDiscount($coupon, $total) : 0;
                $shippingMethod = $this->findActiveShippingMethod($data['shipping_method'] ?? null);
                $shippingFee = $this->calculateShippingFee($shippingMethod, $total);
                $finalPrice = max($total - $discount + $shippingFee, 0);

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'coupon_id' => $coupon?->id,
                    'customer_name' => $selectedAddress?->recipient_name ?? $data['customer_name'],
                    'customer_phone' => $selectedAddress?->phone ?? $data['customer_phone'],
                    'customer_address' => $selectedAddress?->full_address ?? $data['customer_address'],
                    'shipping_method_code' => $shippingMethod?->code,
                    'shipping_method_name' => $shippingMethod?->name,
                    'total_price' => $total,
                    'discount_amount' => $discount,
                    'shipping_fee' => $shippingFee,
                    'final_price' => $finalPrice,
                    'status' => 'pending',
                ]);

                $order->addStatusHistory(
                    null,
                    'pending',
                    $request->user(),
                    'Khách hàng đã đặt đơn.',
                    $request->ip(),
                    $request->userAgent(),
                );

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

    private function findUserAddress(?int $addressId): ?UserAddress
    {
        if (! $addressId) {
            return null;
        }

        return UserAddress::where('user_id', Auth::id())->whereKey($addressId)->first();
    }

    private function findActiveShippingMethod(?string $code): ?ShippingMethod
    {
        if (! $code) {
            return ShippingMethod::active()->first();
        }

        return ShippingMethod::active()->where('code', $code)->first();
    }

    private function calculateShippingFee(?ShippingMethod $shippingMethod, float $total): float
    {
        if (! $shippingMethod) {
            return 0;
        }

        if ((float) $shippingMethod->min_order_value > 0 && $total >= (float) $shippingMethod->min_order_value) {
            return 0;
        }

        return (float) $shippingMethod->fee;
    }
}
