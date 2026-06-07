<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'sku',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, fn ($query) => $query->where('sku', 'like', "%{$keyword}%"));
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['product_id'] ?? null, fn ($query, $value) => $query->where('product_id', $value))
            ->when($filters['size_id'] ?? null, fn ($query, $value) => $query->where('size_id', $value))
            ->when($filters['color_id'] ?? null, fn ($query, $value) => $query->where('color_id', $value))
            ->when(($filters['in_stock'] ?? false), fn ($query) => $query->where('stock', '>', 0));
    }

    public function getDisplayPriceAttribute(): string
    {
        return number_format((float) $this->price, 0, ',', '.').' VND';
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->stock > 0;
    }
}
