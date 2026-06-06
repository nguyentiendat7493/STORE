<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeStatus($query, ?string $status)
    {
        return $query->when($status, fn ($query) => $query->where('payment_status', $status));
    }

    public function scopeMethod($query, ?string $method)
    {
        return $query->when($method, fn ($query) => $query->where('payment_method', $method));
    }
}
