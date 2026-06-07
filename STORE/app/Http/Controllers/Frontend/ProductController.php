<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Catalog\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
    ) {
    }

    public function index(Request $request): View
    {
        $products = $this->catalog->paginate(
            filters: $request->only([
                'category_id',
                'brand_id',
                'gender',
                'min_price',
                'max_price',
                'size_id',
                'color_id',
            ]),
            keyword: $request->string('q')->toString(),
            sort: $request->input('sort'),
        );

        [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
        ] = $this->catalog->filterOptions();

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
            'reviews' => fn ($query) => $query->approved()->with('user')->latest(),
        ]);

        $reviewSummary = [
            'count' => $product->reviews->count(),
            'average' => round((float) $product->reviews->avg('rating'), 1),
        ];

        $relatedProducts = $this->catalog->related($product);

        return view('products.show', compact('product', 'relatedProducts', 'reviewSummary'));
    }
}
