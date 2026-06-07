<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_name',
        'size_name',
        'color_name',
        'price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getDisplaySubtotalAttribute(): string
    {
        return number_format((float) $this->subtotal, 0, ',', '.').' VND';
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('product_name', 'like', "%{$keyword}%")
                ->orWhere('size_name', 'like', "%{$keyword}%")
                ->orWhere('color_name', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['order_id'] ?? null, fn ($query, $value) => $query->where('order_id', $value))
            ->when($filters['product_variant_id'] ?? null, fn ($query, $value) => $query->where('product_variant_id', $value));
    }
}
