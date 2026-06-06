<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::active()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $discountProducts = Product::active()
            ->discounted()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $bestSellingProducts = Product::active()
            ->with(['category', 'brand', 'images'])
            ->withCount('variants')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        return view('home', compact(
            'categories',
            'newProducts',
            'discountProducts',
            'bestSellingProducts',
        ));
    }
}
