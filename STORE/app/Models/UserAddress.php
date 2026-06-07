<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address_line',
        'ward',
        'district',
        'city',
        'country',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDefaultFirst($query)
    {
        return $query->orderByDesc('is_default')->latest();
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line,
            $this->ward,
            $this->district,
            $this->city,
            $this->country,
            $this->postal_code,
        ])->filter()->implode(', ');
    }
}
