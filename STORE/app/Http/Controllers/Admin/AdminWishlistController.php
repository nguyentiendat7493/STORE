<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminWishlistController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $wishlists = Wishlist::query()
            ->with(['user', 'product.category', 'product.brand'])
            ->search($request->string('q')->toString())
            ->filter($request->only(['user_id', 'product_id']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $topProducts = Wishlist::query()
            ->selectRaw('product_id, COUNT(*) as wishlist_count')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('wishlist_count')
            ->take(10)
            ->get();

        return view('admin.wishlists.index', compact('wishlists', 'topProducts'));
    }
}
