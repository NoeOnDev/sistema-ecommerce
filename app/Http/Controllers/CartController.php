<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Obtiene o crea el carrito para el usuario actual o sesión
     */
    public function getCart() // Cambiar de private a public
    {
        // Si el usuario está autenticado, buscar carrito por user_id
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['tax_rate' => 16.00] // Valor por defecto del IVA
            );

            // Si había un carrito de sesión, fusionarlo con este
            if (session()->has('cart_id')) {
                $sessionCart = Cart::where('session_id', session('cart_id'))->first();
                if ($sessionCart && $sessionCart->id !== $cart->id) {
                    // Transferir los ítems del carrito de sesión al carrito del usuario
                    foreach ($sessionCart->items as $item) {
                        $existingItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $item->product_id)
                            ->first();

                        if ($existingItem) {
                            // Si el producto ya existe en el carrito del usuario, actualizar cantidad
                            $existingItem->quantity += $item->quantity;
                            $existingItem->save();
                        } else {
                            // Si no, crear un nuevo ítem
                            CartItem::create([
                                'cart_id' => $cart->id,
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity,
                                'price' => $item->price
                            ]);
                        }
                    }

                    // Eliminar el carrito de sesión
                    $sessionCart->delete();
                    session()->forget('cart_id');
                }
            }
        }
        // Si no está autenticado, usar un carrito basado en sesión
        else {
            if (!session()->has('cart_id')) {
                $sessionId = Str::uuid();
                session(['cart_id' => $sessionId]);

                $cart = Cart::create([
                    'session_id' => $sessionId,
                    'tax_rate' => 16.00 // Valor por defecto del IVA
                ]);
            } else {
                $cart = Cart::firstOrCreate(
                    ['session_id' => session('cart_id')],
                    ['tax_rate' => 16.00]
                );
            }
        }

        return $cart;
    }

    /**
     * Muestra el contenido del carrito
     */
    public function index()
    {
        $cart = $this->getCart();
        $cart->load('items.product'); // Cargar relaciones para evitar N+1

        return view('cart.index', compact('cart'));
    }

    /**
     * Agrega un producto al carrito
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getCart();

        // Verificar si el producto ya está en el carrito
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            // Si ya existe, actualizar la cantidad
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            // Si no existe, crear un nuevo ítem
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->back()
            ->with('success', 'Producto agregado al carrito correctamente.');
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function updateItem(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        // Verificar que el ítem pertenece al carrito del usuario actual
        $cart = $this->getCart();
        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->back()
                ->with('error', 'No tienes permiso para modificar este elemento.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Carrito actualizado correctamente.');
    }

    /**
     * Eliminar un producto del carrito
     */
    public function removeItem(CartItem $cartItem)
    {
        // Verificar que el ítem pertenece al carrito del usuario actual
        $cart = $this->getCart();
        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->back()
                ->with('error', 'No tienes permiso para eliminar este elemento.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vaciar el carrito completamente
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Carrito vaciado correctamente.');
    }
}
