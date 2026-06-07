<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhereDate('end_date', '>=', now());
            });
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, fn ($query) => $query->where('code', 'like', "%{$keyword}%"));
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['discount_type'] ?? null, fn ($query, $value) => $query->where('discount_type', $value))
            ->when(array_key_exists('status', $filters), fn ($query) => $query->where('status', $filters['status']));
    }

    public function getDisplayDiscountAttribute(): string
    {
        if ($this->discount_type === 'percent') {
            return rtrim(rtrim((string) $this->discount_value, '0'), '.').'%';
        }

        return number_format((float) $this->discount_value, 0, ',', '.').' VND';
    }
}
