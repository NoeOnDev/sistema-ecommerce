<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price'];

    /**
     * Relación con el carrito al que pertenece
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relación con el producto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcula el subtotal del ítem (precio * cantidad)
     */
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Formatea el precio con el símbolo de moneda MXN
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'MX$' . number_format($this->price, 2);
    }

    /**
     * Formatea el subtotal con el símbolo de moneda MXN
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'MX$' . number_format($this->subtotal, 2);
    }
}
