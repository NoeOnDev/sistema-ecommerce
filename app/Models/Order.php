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
        'order_number',
        'subtotal',
        'tax_amount',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function generateOrderNumber(): string
    {
        // Formato: ORD-YYYYMMDD-XXXXX (X = número aleatorio)
        $prefix = 'ORD-';
        $dateCode = now()->format('Ymd');
        $randomCode = mt_rand(10000, 99999);

        return $prefix . $dateCode . '-' . $randomCode;
    }
}
