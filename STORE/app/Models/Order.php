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
        'total_price',
        'discount_amount',
        'final_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
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

    public function getDisplayFinalPriceAttribute(): string
    {
        return number_format((float) $this->final_price, 0, ',', '.').' VND';
    }

    public function getCanCancelAttribute(): bool
    {
        return $this->status === 'pending';
    }
}
