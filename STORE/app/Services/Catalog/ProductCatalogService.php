<?php

namespace App\Services\Catalog;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductCatalogService
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
    ) {
    }

    public function paginate(array $filters = [], ?string $keyword = null, ?string $sort = null, int $perPage = 12): LengthAwarePaginator
    {
        return $this->products->paginateActive($filters, $keyword, $sort, $perPage);
    }

    public function related(Product $product, int $limit = 4): Collection
    {
        return $this->products->related($product, $limit);
    }

    public function filterOptions(): array
    {
        return $this->products->filterOptions();
    }
}
