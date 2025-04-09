<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Obtiene el carrito actual
     */
    private function getCart()
    {
        $cartController = new CartController();
        return $cartController->getCart();
    }

    /**
     * Paso 1: Mostrar página de revisión del carrito
     */
    public function review()
    {
        $cart = $this->getCart();
        $cart->load('items.product');

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de continuar.');
        }

        return view('checkout.review', compact('cart'));
    }

    /**
     * Paso 2: Mostrar formulario de datos de envío
     */
    public function shipping()
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de continuar.');
        }

        $user = Auth::user(); // Puede ser null si el usuario no está autenticado

        return view('checkout.shipping', compact('cart', 'user'));
    }

    /**
     * Procesar información de envío
     */
    public function processShipping(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Guardar la información de envío en la sesión
        Session::put('checkout_address', $validated);

        return redirect()->route('checkout.payment');
    }

    /**
     * Paso 3: Mostrar opciones de pago
     */
    public function payment()
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de continuar.');
        }

        if (!Session::has('checkout_address')) {
            return redirect()->route('checkout.shipping')
                ->with('error', 'Por favor completa la información de envío primero.');
        }

        $address = Session::get('checkout_address');

        return view('checkout.payment', compact('cart', 'address'));
    }

    /**
     * Procesar el pago y finalizar el pedido
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
            'card_expiry' => 'required_if:payment_method,credit_card',
            'card_cvv' => 'required_if:payment_method,credit_card',
        ]);

        $cart = $this->getCart();
        $address = Session::get('checkout_address');

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            // Crear la orden
            $order = new Order();
            $order->user_id = Auth::id(); // Puede ser null
            $order->order_number = $order->generateOrderNumber();
            $order->subtotal = $cart->subtotal;
            $order->tax_amount = $cart->tax_amount;
            $order->total = $cart->total;
            $order->status = 'pending';
            $order->payment_method = $validated['payment_method'];
            $order->payment_status = 'pending';
            $order->save();

            // Datos para auditoría
            $orderItems = [];

            // Crear los items de la orden
            foreach ($cart->items as $item) {
                $orderItem = new OrderItem([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal
                ]);

                $order->items()->save($orderItem);

                // Agregar al log de auditoría
                $orderItems[] = [
                    'producto_id' => $item->product_id,
                    'nombre' => $item->product->name,
                    'cantidad' => $item->quantity,
                    'precio' => $item->price,
                    'subtotal' => $item->subtotal
                ];

                // Actualizar el stock del producto
                $product = $item->product;
                $oldStock = $product->stock;
                $product->stock -= $item->quantity;
                $product->save();

                // Auditar cambio de stock por venta
                AuditService::log(
                    'reducción de stock por venta',
                    'producto',
                    ['stock_anterior' => $oldStock],
                    ['stock_nuevo' => $product->stock],
                    $product->id
                );
            }

            // Guardar la dirección
            $shippingAddress = new Address($address);
            $shippingAddress->user_id = Auth::id(); // Puede ser null
            $order->address()->save($shippingAddress);

            // Simular procesamiento de pago
            // En una implementación real, aquí se conectaría con la pasarela de pago
            $paymentSuccessful = true;

            if ($paymentSuccessful) {
                // Actualizar estado de la orden
                $order->payment_status = 'paid';
                $order->status = 'processing';
                $order->save();

                // Auditar creación de orden
                AuditService::log(
                    'creación',
                    'orden',
                    null,
                    [
                        'orden_id' => $order->id,
                        'orden_numero' => $order->order_number,
                        'total' => $order->total,
                        'método_pago' => $order->payment_method,
                        'productos' => $orderItems
                    ],
                    $order->id
                );

                // Vaciar el carrito
                $cart->items()->delete();

                // Limpiar datos de la sesión
                Session::forget('checkout_address');

                DB::commit();

                return redirect()->route('checkout.confirmation', ['order' => $order->id]);
            } else {
                throw new \Exception('Error al procesar el pago.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            // Auditar error en el proceso de checkout
            AuditService::log(
                'error',
                'checkout',
                null,
                ['mensaje_error' => $e->getMessage()],
                null
            );

            return redirect()->back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar página de confirmación del pedido
     */
    public function confirmation(Order $order)
    {
        // Verificar que la orden pertenece al usuario o está en sesión
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'No autorizado a ver este pedido.');
        }

        // Si llegamos aquí, mostrar la confirmación
        return view('checkout.confirmation', compact('order'));
    }
}
