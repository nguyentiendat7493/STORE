<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderApiController extends Controller
{
    use ApiResponds;

    public function index(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->status($request->string('status')->toString())
            ->with('payment')
            ->latest()
            ->paginate((int) $request->input('per_page', 10))
            ->withQueryString();

        return $this->success($orders);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            return $this->error('Bạn không có quyền xem đơn hàng này.', 403);
        }

        $order->load('details.productVariant.product.images', 'payment', 'coupon');

        return $this->success($order);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
            'payment_method' => ['required', 'in:cod,bank_transfer,momo,vnpay'],
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->load('items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color');

        if ($cart->items->isEmpty()) {
            return $this->error('Giỏ hàng của bạn đang trống.', 422);
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
                $discount = $coupon ? $this->calculateDiscount($coupon, $total) : 0;

                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'coupon_id' => $coupon?->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_address' => $data['customer_address'],
                    'total_price' => $total,
                    'discount_amount' => $discount,
                    'final_price' => max($total - $discount, 0),
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

                return $order->load('details', 'payment');
            });
        } catch (RuntimeException $exception) {
            return $this->error($exception->getMessage(), 422);
        }

        return $this->success($order, 'Đã tạo đơn hàng thành công.', 201);
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
