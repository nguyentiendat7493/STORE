<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    use ApiResponds;

    public function index(): JsonResponse
    {
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return $this->success($categories);
    }
}
