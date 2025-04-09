<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_checkout_review()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Acceder a la página de revisión del checkout
        $response = $this->get(route('checkout.review'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('200.00'); // Subtotal
        $response->assertSee('32.00');  // Impuesto 16%
        $response->assertSee('232.00'); // Total
    }

    public function test_authenticated_user_can_proceed_to_shipping()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Acceder a la página de envío
        $response = $this->get(route('checkout.shipping'));

        $response->assertStatus(200);
        $response->assertSee('Información de Envío');
        $response->assertSee($user->name); // El nombre del usuario debe aparecer pre-completado
        $response->assertSee($user->email);
    }

    public function test_authenticated_user_can_submit_shipping_info()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Enviar formulario de envío
        $shippingData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address_line1' => '123 Main St',
            'address_line2' => 'Apt 4B',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '12345',
            'country' => 'México',
        ];

        $response = $this->post(route('checkout.process.shipping'), $shippingData);

        $response->assertRedirect(route('checkout.payment'));
        $this->assertEquals($shippingData, session('checkout_address'));
    }

    public function test_authenticated_user_can_access_payment_page()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Almacenar datos de envío en la sesión
        $shippingData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address_line1' => '123 Main St',
            'address_line2' => 'Apt 4B',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '12345',
            'country' => 'México',
        ];

        session(['checkout_address' => $shippingData]);

        // Acceder a la página de pago
        $response = $this->get(route('checkout.payment'));

        $response->assertStatus(200);
        $response->assertSee('Método de Pago');
        $response->assertSee('Tarjeta de Crédito / Débito');
        $response->assertSee('John Doe'); // Verificar que aparece el nombre del destinatario
        $response->assertSee('123 Main St');
    }

    public function test_authenticated_user_can_complete_purchase()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00,
            'stock' => 10
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Almacenar datos de envío en la sesión
        $shippingData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address_line1' => '123 Main St',
            'address_line2' => 'Apt 4B',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '12345',
            'country' => 'México',
        ];

        session(['checkout_address' => $shippingData]);

        // Enviar datos de pago
        $paymentData = [
            'payment_method' => 'credit_card',
            'card_number' => '4242424242424242',
            'card_holder' => 'John Doe',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
        ];

        $response = $this->post(route('checkout.process.payment'), $paymentData);

        // Verificar redirección a la página de confirmación
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'subtotal' => 200.00,
            'tax_amount' => 32.00,
            'total' => 232.00,
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
            'status' => 'processing'
        ]);

        // Verificar que se crearon los items del pedido
        $order = \App\Models\Order::where('user_id', $user->id)->first();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00,
            'subtotal' => 200.00
        ]);

        // Verificar que se actualizó el stock del producto
        $product->refresh();
        $this->assertEquals(8, $product->stock);

        // Verificar que se guardó la dirección
        $this->assertDatabaseHas('addresses', [
            'order_id' => $order->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'address_line1' => '123 Main St'
        ]);

        // Verificar que el carrito se vació
        $this->assertEquals(0, CartItem::where('cart_id', $cart->id)->count());

        // Verificar redirección a la página de confirmación
        $response->assertRedirect(route('checkout.confirmation', ['order' => $order->id]));
    }

    public function test_user_cannot_access_checkout_with_empty_cart()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear carrito vacío
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        // Intentar acceder a la página de revisión del checkout
        $response = $this->get(route('checkout.review'));

        // Verificar redirección al carrito con mensaje de error
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Tu carrito está vacío. Agrega productos antes de continuar.');
    }

    public function test_user_cannot_access_payment_without_shipping_info()
    {
        // Crear usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear productos para el carrito
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Crear carrito con productos
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        // Intentar acceder a la página de pago sin datos de envío
        $response = $this->get(route('checkout.payment'));

        // Verificar redirección a la página de envío con mensaje de error
        $response->assertRedirect(route('checkout.shipping'));
        $response->assertSessionHas('error', 'Por favor completa la información de envío primero.');
    }
}
