<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class CartButton extends Component
{
    public $itemCount;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->itemCount = $this->getCartItemCount();
    }

    private function getCartItemCount(): int
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
        } elseif (session()->has('cart_id')) {
            $cart = Cart::where('session_id', session('cart_id'))->first();
        } else {
            return 0;
        }

        return $cart ? $cart->items->sum('quantity') : 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.cart-button');
    }
}
