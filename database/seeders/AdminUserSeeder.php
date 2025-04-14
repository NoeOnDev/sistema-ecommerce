<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Administrador Principal',
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Administrador Secundario',
                'email' => 'admin2@example.com',
            ]
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }
    }
}
