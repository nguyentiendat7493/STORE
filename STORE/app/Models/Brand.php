<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
}
