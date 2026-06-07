<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'shipping_method_code',
        'shipping_method_name',
        'total_price',
        'discount_amount',
        'shipping_fee',
        'final_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function addStatusHistory(?string $fromStatus, string $toStatus, ?User $actor = null, ?string $note = null, ?string $ipAddress = null, ?string $userAgent = null): OrderStatusHistory
    {
        return $this->statusHistories()->create([
            'user_id' => $actor?->id,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'note' => $note,
            'changed_by_name' => $actor?->name,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    public function scopeStatus($query, ?string $status)
    {
        return $query->when($status, fn ($query) => $query->where('status', $status));
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, string $keyword) {
            $query->where('customer_name', 'like', "%{$keyword}%")
                ->orWhere('customer_phone', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['user_id'] ?? null, fn ($query, $value) => $query->where('user_id', $value))
            ->when($filters['coupon_id'] ?? null, fn ($query, $value) => $query->where('coupon_id', $value))
            ->when($filters['status'] ?? null, fn ($query, $value) => $query->where('status', $value));
    }

    public function getDisplayFinalPriceAttribute(): string
    {
        return number_format((float) $this->final_price, 0, ',', '.').' VND';
    }

    public function getDisplayShippingFeeAttribute(): string
    {
        return number_format((float) $this->shipping_fee, 0, ',', '.').' VND';
    }

    public function getCanCancelAttribute(): bool
    {
        return $this->status === 'pending';
    }
}
