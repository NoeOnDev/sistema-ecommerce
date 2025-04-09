<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'cliente',
        ]);
    }
}
