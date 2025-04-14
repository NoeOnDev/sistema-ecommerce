<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteUserSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'name' => 'Cliente Demo',
                'email' => 'cliente@example.com',
            ],
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@example.com',
            ],
            [
                'name' => 'María García',
                'email' => 'maria@example.com',
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos@example.com',
            ]
        ];

        foreach ($clientes as $cliente) {
            User::create([
                'name' => $cliente['name'],
                'email' => $cliente['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'cliente',
            ]);
        }
    }
}
