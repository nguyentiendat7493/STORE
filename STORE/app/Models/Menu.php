<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'location',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('slug', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['location'] ?? null, fn ($query, $value) => $query->where('location', $value))
            ->when(array_key_exists('status', $filters), fn ($query) => $query->where('status', $filters['status']));
    }
}
