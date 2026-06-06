<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'gender',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('slug', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['category_id'] ?? null, fn ($query, $value) => $query->where('category_id', $value))
            ->when($filters['brand_id'] ?? null, fn ($query, $value) => $query->where('brand_id', $value))
            ->when($filters['gender'] ?? null, fn ($query, $value) => $query->where('gender', $value))
            ->when($filters['min_price'] ?? null, fn ($query, $value) => $query->where('price', '>=', $value))
            ->when($filters['max_price'] ?? null, fn ($query, $value) => $query->where('price', '<=', $value))
            ->when($filters['size_id'] ?? null, function ($query, $value) {
                $query->whereHas('variants', fn ($query) => $query->where('size_id', $value));
            })
            ->when($filters['color_id'] ?? null, function ($query, $value) {
                $query->whereHas('variants', fn ($query) => $query->where('color_id', $value));
            });
    }

    public function scopeDiscounted($query)
    {
        return $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
    }

    public function getFinalPriceAttribute(): string
    {
        return $this->sale_price ?: $this->price;
    }

    public function getDisplayPriceAttribute(): string
    {
        return number_format((float) $this->final_price, 0, ',', '.').' VND';
    }

    public function getMainImageAttribute(): ?string
    {
        return $this->images->firstWhere('is_main', true)?->image
            ?? $this->images->first()?->image;
    }
}
