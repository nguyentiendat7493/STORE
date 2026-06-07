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

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('payment_method', 'like', "%{$keyword}%")
                ->orWhere('payment_status', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['order_id'] ?? null, fn ($query, $value) => $query->where('order_id', $value))
            ->when($filters['payment_method'] ?? null, fn ($query, $value) => $query->where('payment_method', $value))
            ->when($filters['payment_status'] ?? null, fn ($query, $value) => $query->where('payment_status', $value));
    }
}
