<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un test básico de ejemplo.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Ejecutar migraciones para crear las tablas necesarias
        $this->artisan('migrate');

        // Crear al menos un producto para que la vista no falle
        \App\Models\Category::factory()->create();
        \App\Models\Product::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
