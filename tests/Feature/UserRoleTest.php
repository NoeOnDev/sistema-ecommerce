<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/products/create');

        $response->assertStatus(200);
    }

    public function test_cliente_cannot_access_admin_routes(): void
    {
        $cliente = User::factory()->create(['role' => 'cliente']);

        $response = $this->actingAs($cliente)->get('/products/create');

        // Debería ser redirigido
        $response->assertStatus(302);
    }

    public function test_default_role_for_new_user_is_cliente(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'cliente'
        ]);
    }
}
