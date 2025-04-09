<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_display_index_page()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function it_can_filter_products_by_name()
    {
        $product1 = Product::factory()->create(['name' => 'Special Product']);
        $product2 = Product::factory()->create(['name' => 'Regular Product']);

        $response = $this->get(route('products.index', ['search' => 'Special']));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    /** @test */
    public function it_can_filter_products_by_category()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $product1 = Product::factory()->create(['category_id' => $category1->id]);
        $product2 = Product::factory()->create(['category_id' => $category2->id]);

        $response = $this->get(route('products.index', ['category_id' => $category1->id]));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
    }

    /** @test */
    public function it_can_display_create_form()
    {
        // Crear y autenticar un usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee('Crear Producto');
    }

    /** @test */
    public function it_can_store_a_product()
    {
        // Crear y autenticar un usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        Storage::fake('public');

        $category = Category::factory()->create();
        $tags = Tag::factory(2)->create();

        $data = [
            'name' => 'New Test Product',
            'description' => 'Product description',
            'price' => 99.99,
            'stock' => 10,
            'category_id' => $category->id,
            'tags' => $tags->pluck('id')->toArray(),
        ];

        // Solo intenta simular la carga de imagen si GD está disponible
        if (function_exists('imagecreatetruecolor')) {
            $data['image'] = UploadedFile::fake()->image('product.jpg');
        }

        $response = $this->actingAs($admin)->post(route('products.store'), $data);

        $product = Product::where('name', 'New Test Product')->first();

        $this->assertNotNull($product);
        $this->assertEquals('New Test Product', $product->name);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertCount(2, $product->tags);

        // Verificar la imagen solo si GD está disponible y se subió una imagen
        if (isset($data['image'])) {
            Storage::disk('public')->assertExists($product->image);
        }

        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->description);
    }

    /** @test */
    public function it_can_display_edit_form()
    {
        // Crear y autenticar un usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertSee('Editar Producto');
        $response->assertSee($product->name);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        // Crear y autenticar un usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        $product = Product::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 149.99,
            'stock' => 25,
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($admin)->put(route('products.update', $product), $data);

        $product->refresh();

        $this->assertEquals('Updated Product', $product->name);
        $this->assertEquals('Updated description', $product->description);
        $this->assertEquals(149.99, $product->price);
        $this->assertEquals(25, $product->stock);
        $this->assertEquals($category->id, $product->category_id);

        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Crear y autenticar un usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $response->assertRedirect(route('products.index'));
    }
}
