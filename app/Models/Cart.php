<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id', 'tax_rate'];

    /**
     * Relación con el usuario dueño del carrito
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los ítems del carrito
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calcula el subtotal del carrito (sin impuestos)
     */
    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Calcula el impuesto del carrito
     */
    public function getTaxAmountAttribute(): float
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    /**
     * Calcula el total del carrito (con impuestos)
     */
    public function getTotalAttribute(): float
    {
        return $this->subtotal + $this->tax_amount;
    }

    /**
     * Formatea el subtotal con moneda MXN
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'MX$' . number_format($this->subtotal, 2);
    }

    /**
     * Formatea el impuesto con moneda MXN
     */
    public function getFormattedTaxAmountAttribute(): string
    {
        return 'MX$' . number_format($this->tax_amount, 2);
    }

    /**
     * Formatea el total con moneda MXN
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'MX$' . number_format($this->total, 2);
    }

    /**
     * Obtiene el número total de ítems en el carrito
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}
