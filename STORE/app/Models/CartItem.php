<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->productVariant?->price * $this->quantity;
    }

    public function getDisplaySubtotalAttribute(): string
    {
        return number_format($this->subtotal, 0, ',', '.').' VND';
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->whereHas('productVariant', fn ($query) => $query->where('sku', 'like', "%{$keyword}%"));
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['cart_id'] ?? null, fn ($query, $value) => $query->where('cart_id', $value))
            ->when($filters['product_variant_id'] ?? null, fn ($query, $value) => $query->where('product_variant_id', $value));
    }
}
