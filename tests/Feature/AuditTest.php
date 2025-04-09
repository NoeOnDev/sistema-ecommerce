<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_price_change_is_logged()
    {
        // Preparar directorio de logs
        $logPath = storage_path('logs/audit');
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0755, true);
        }

        // Crear usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        // Crear categoría y producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100.00
        ]);

        // Esperar que Log capture los mensajes
        Log::shouldReceive('channel')
            ->once()
            ->with('audit')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message, $context) {
                return strpos($message, 'cambio de precio') !== false &&
                       $context['old_data']['precio_anterior'] == 100.00 &&
                       $context['new_data']['precio_nuevo'] == 150.00;
            });

        // Actualizar el producto con un nuevo precio
        $response = $this->actingAs($admin)->put(route('products.update', $product), [
            'name' => $product->name,
            'description' => $product->description,
            'price' => 150.00,  // Precio actualizado
            'stock' => $product->stock,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('products.index'));

        // Verificar que el producto se actualizó en la base de datos
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 150.00
        ]);
    }

    public function test_product_deletion_is_logged()
    {
        // Preparar directorio de logs
        $logPath = storage_path('logs/audit');
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0755, true);
        }

        // Crear usuario admin
        $admin = User::factory()->create(['role' => 'admin']);

        // Crear categoría y producto
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Producto de prueba'
        ]);

        // Esperar que Log capture los mensajes
        Log::shouldReceive('channel')
            ->once()
            ->with('audit')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message, $context) use ($product) {
                return strpos($message, 'eliminación') !== false &&
                       $context['old_data']['nombre'] == 'Producto de prueba' &&
                       $context['entity_id'] == $product->id;
            });

        // Eliminar el producto
        $response = $this->actingAs($admin)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));

        // Verificar que el producto se eliminó de la base de datos
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
