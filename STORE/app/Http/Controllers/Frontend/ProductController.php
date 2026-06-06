<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->active()
            ->with(['category', 'brand', 'images', 'variants.size', 'variants.color'])
            ->search($request->string('q')->toString())
            ->filter($request->only([
                'category_id',
                'brand_id',
                'gender',
                'min_price',
                'max_price',
                'size_id',
                'color_id',
            ]));

        match ($request->input('sort')) {
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            'newest' => $products->latest(),
            default => $products->latest(),
        };

        $products = $products->paginate(12)->withQueryString();

        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        $sizes = Size::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'brands',
            'sizes',
            'colors',
        ));
    }

    public function show(Product $product): View
    {
        abort_if(! $product->status, 404);

        $product->load([
            'category',
            'brand',
            'images',
            'variants.size',
            'variants.color',
        ]);

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with(['images', 'brand'])
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
