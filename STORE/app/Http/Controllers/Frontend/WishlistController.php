<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlists = Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->with(['product.category', 'product.brand', 'product.images'])
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_if(! $product->status, 404);

        Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Product added to wishlist.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }
}
