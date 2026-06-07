<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginateActive(array $filters = [], ?string $keyword = null, ?string $sort = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::query()
            ->active()
            ->with(['category', 'brand', 'images', 'variants.size', 'variants.color'])
            ->search($keyword)
            ->filter($filters);

        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->latest(),
            default => $query->latest(),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    public function related(Product $product, int $limit = 4): Collection
    {
        return Product::active()
            ->whereKeyNot($product->id)
            ->where('category_id', $product->category_id)
            ->with(['images', 'brand'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function filterOptions(): array
    {
        return [
            'categories' => Category::active()->orderBy('name')->get(),
            'brands' => Brand::active()->orderBy('name')->get(),
            'sizes' => Size::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
        ];
    }
}
