<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = $this->currentCart();
        $cart->load('items.productVariant.product.images', 'items.productVariant.size', 'items.productVariant.color');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        if ($variant->stock < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Biến thể này không đủ tồn kho.']);
        }

        $cart = $this->currentCart();
        $item = $cart->items()->firstOrNew([
            'product_variant_id' => $variant->id,
        ]);

        $newQuantity = $item->exists ? $item->quantity + $data['quantity'] : $data['quantity'];

        if ($variant->stock < $newQuantity) {
            return back()->withErrors(['quantity' => 'Biến thể này không đủ tồn kho.']);
        }

        $item->quantity = $newQuantity;
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $this->authorizeCartItem($item);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->load('productVariant');

        if ($item->productVariant->stock < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Biến thể này không đủ tồn kho.']);
        }

        $item->update(['quantity' => $data['quantity']]);

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(CartItem $item): RedirectResponse
    {
        $this->authorizeCartItem($item);
        $item->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    private function currentCart(): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    private function authorizeCartItem(CartItem $item): void
    {
        abort_if($item->cart()->where('user_id', Auth::id())->doesntExist(), 403);
    }
}
