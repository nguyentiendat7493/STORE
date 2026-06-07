<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function paginateActive(array $filters = [], ?string $keyword = null, ?string $sort = null, int $perPage = 12): LengthAwarePaginator;

    public function related(Product $product, int $limit = 4): Collection;

    public function filterOptions(): array;
}
