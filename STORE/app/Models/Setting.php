<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group_name',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function scopePublic($query)
    {
        return $query->where('is_public', 1);
    }

    public function scopeGroup($query, ?string $group)
    {
        return $query->when($group, fn ($query) => $query->where('group_name', $group));
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('key', 'like', "%{$keyword}%")
                ->orWhere('value', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['group_name'] ?? null, fn ($query, $value) => $query->where('group_name', $value))
            ->when($filters['type'] ?? null, fn ($query, $value) => $query->where('type', $value))
            ->when(array_key_exists('is_public', $filters), fn ($query) => $query->where('is_public', $filters['is_public']));
    }
}
