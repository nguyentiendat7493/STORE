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
}
