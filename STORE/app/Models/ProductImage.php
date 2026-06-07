<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'product_id',
        'image',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', 1);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, fn ($query) => $query->where('image', 'like', "%{$keyword}%"));
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['product_id'] ?? null, fn ($query, $value) => $query->where('product_id', $value))
            ->when(array_key_exists('is_main', $filters), fn ($query) => $query->where('is_main', $filters['is_main']));
    }
}
