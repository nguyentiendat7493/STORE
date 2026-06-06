<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    use ApiResponds;

    public function index(Request $request): JsonResponse
    {
        $cart = $this->currentCart($request);
        $cart->load('items.productVariant.product.images', 'items.productVariant.size', 'items.productVariant.color');

        return $this->success($cart);
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        if ($variant->stock < $data['quantity']) {
            return $this->error('Biến thể này không đủ tồn kho.', 422);
        }

        $cart = $this->currentCart($request);
        $item = $cart->items()->firstOrNew(['product_variant_id' => $variant->id]);
        $newQuantity = $item->exists ? $item->quantity + $data['quantity'] : $data['quantity'];

        if ($variant->stock < $newQuantity) {
            return $this->error('Biến thể này không đủ tồn kho.', 422);
        }

        $item->quantity = $newQuantity;
        $item->save();

        return $this->success($item->load('productVariant'), 'Đã thêm sản phẩm vào giỏ hàng.', 201);
    }

    public function update(Request $request, CartItem $item): JsonResponse
    {
        if ($item->cart()->where('user_id', $request->user()->id)->doesntExist()) {
            return $this->error('Bạn không có quyền cập nhật sản phẩm này.', 403);
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->load('productVariant');

        if ($item->productVariant->stock < $data['quantity']) {
            return $this->error('Biến thể này không đủ tồn kho.', 422);
        }

        $item->update($data);

        return $this->success($item, 'Đã cập nhật giỏ hàng.');
    }

    public function remove(Request $request, CartItem $item): JsonResponse
    {
        if ($item->cart()->where('user_id', $request->user()->id)->doesntExist()) {
            return $this->error('Bạn không có quyền xóa sản phẩm này.', 403);
        }

        $item->delete();

        return $this->success(null, 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    private function currentCart(Request $request): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);
    }
}
