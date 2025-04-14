<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónica',
                'description' => 'Productos electrónicos, gadgets y accesorios tecnológicos'
            ],
            [
                'name' => 'Ropa',
                'description' => 'Prendas de vestir para todas las edades y estilos'
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar, decoración y muebles'
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios, bebidas y suplementos'
            ],
            [
                'name' => 'Deportes',
                'description' => 'Equipamiento deportivo, ropa y accesorios para ejercicio'
            ],
            [
                'name' => 'Belleza',
                'description' => 'Productos de cosmética, cuidado personal y belleza'
            ],
            [
                'name' => 'Juguetes',
                'description' => 'Juguetes para niños de todas las edades'
            ],
            [
                'name' => 'Libros',
                'description' => 'Libros, revistas y material de lectura'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
