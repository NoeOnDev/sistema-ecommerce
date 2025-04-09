<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_product_to_cart()
    {
        // Crear un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Agregar producto al carrito
        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // Verificar redirección exitosa
        $response->assertStatus(302);

        // Verificar que se creó un carrito con sesión
        $this->assertDatabaseHas('carts', [
            'session_id' => session('cart_id'),
        ]);

        // Verificar que el producto se agregó al carrito
        $cart = Cart::where('session_id', session('cart_id'))->first();
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00
        ]);
    }

    public function test_user_can_add_product_to_cart()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 120.50
        ]);

        // Agregar producto al carrito
        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        // Verificar redirección exitosa
        $response->assertStatus(302);

        // Verificar que se creó un carrito para el usuario
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
        ]);

        // Verificar que el producto se agregó al carrito
        $cart = Cart::where('user_id', $user->id)->first();
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 120.50
        ]);
    }

    public function test_user_can_update_cart_item_quantity()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 99.99
        ]);

        // Crear un carrito y un ítem directamente
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 99.99
        ]);

        // Actualizar la cantidad del ítem
        $response = $this->put(route('cart.update', $cartItem), [
            'quantity' => 3
        ]);

        // Verificar redirección
        $response->assertRedirect(route('cart.index'));

        // Verificar que la cantidad se actualizó
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 3
        ]);
    }

    public function test_user_can_remove_cart_item()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        // Crear un carrito y un ítem directamente
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price
        ]);

        // Eliminar el ítem del carrito
        $response = $this->delete(route('cart.remove', $cartItem));

        // Verificar redirección
        $response->assertRedirect(route('cart.index'));

        // Verificar que el ítem fue eliminado
        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id
        ]);
    }

    public function test_user_can_clear_cart()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto
        $category = Category::factory()->create();
        $product1 = Product::factory()->create(['category_id' => $category->id]);
        $product2 = Product::factory()->create(['category_id' => $category->id]);

        // Crear un carrito y varios ítems
        $cart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => $product1->price
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => $product2->price
        ]);

        // Verificar que inicialmente tenemos 2 ítems
        $this->assertEquals(2, $cart->items()->count());

        // Vaciar el carrito
        $response = $this->delete(route('cart.clear'));

        // Verificar redirección
        $response->assertRedirect(route('cart.index'));

        // Verificar que todos los ítems fueron eliminados
        $this->assertEquals(0, $cart->items()->count());
    }

    public function test_cart_calculates_totals_correctly()
    {
        // Crear un carrito directamente
        $cart = Cart::create([
            'tax_rate' => 16.00
        ]);

        // Crear dos productos con precios conocidos
        $category = Category::factory()->create();
        $product1 = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        $product2 = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50.00
        ]);

        // Agregar productos al carrito
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => $product1->price
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => $product2->price
        ]);

        // Refrescar el carrito para asegurarnos de tener datos actualizados
        $cart = Cart::find($cart->id);

        // Verificar subtotal: (100.00 * 2) + (50.00 * 1) = 250.00
        $this->assertEquals(250.00, $cart->subtotal);

        // Verificar impuestos: 250.00 * 0.16 = 40.00
        $this->assertEquals(40.00, $cart->tax_amount);

        // Verificar total: 250.00 + 40.00 = 290.00
        $this->assertEquals(290.00, $cart->total);
    }

    public function test_cart_merges_when_user_logs_in()
    {
        // Crear un usuario (pero no autenticar aún)
        $user = User::factory()->create();

        // Crear productos
        $category = Category::factory()->create();
        $product1 = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10.00
        ]);

        $product2 = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 20.00
        ]);

        // 1. Primero, simular un carrito de sesión (usuario no autenticado)
        $sessionId = 'test-session-id';
        session(['cart_id' => $sessionId]);

        $sessionCart = Cart::create([
            'session_id' => $sessionId,
            'tax_rate' => 16.00
        ]);

        // Agregar un producto al carrito de sesión
        CartItem::create([
            'cart_id' => $sessionCart->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => $product1->price
        ]);

        // 2. Luego, simular un carrito existente para el usuario
        $userCart = Cart::create([
            'user_id' => $user->id,
            'tax_rate' => 16.00
        ]);

        // Agregar otro producto al carrito del usuario
        CartItem::create([
            'cart_id' => $userCart->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => $product2->price
        ]);

        // 3. Ahora simular que el usuario inicia sesión
        $this->actingAs($user);

        // 4. Invocar el método que obtiene el carrito (que debería fusionar los carritos)
        $response = $this->get(route('cart.index'));

        // Verificar que el carrito de sesión ya no existe
        $this->assertDatabaseMissing('carts', [
            'id' => $sessionCart->id
        ]);

        // Verificar que el carrito del usuario tiene ambos productos
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $userCart->id,
            'product_id' => $product1->id
        ]);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $userCart->id,
            'product_id' => $product2->id
        ]);
    }
}
