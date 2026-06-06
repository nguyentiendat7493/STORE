<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    use ApiResponds;

    public function index(Request $request): JsonResponse
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
            default => $products->latest(),
        };

        return $this->success($products->paginate((int) $request->input('per_page', 12))->withQueryString());
    }

    public function show(Product $product): JsonResponse
    {
        if (! $product->status) {
            return $this->error('Không tìm thấy sản phẩm.', 404);
        }

        $product->load(['category', 'brand', 'images', 'variants.size', 'variants.color']);

        return $this->success($product);
    }

    public function brands(): JsonResponse
    {
        return $this->success(Brand::active()->orderBy('name')->get());
    }
}
