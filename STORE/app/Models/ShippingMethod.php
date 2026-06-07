<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'fee',
        'min_order_value',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort_order');
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('code', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when(array_key_exists('status', $filters), fn ($query) => $query->where('status', $filters['status']));
    }
}
