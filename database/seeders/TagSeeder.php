<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Oferta',
            'Nuevo',
            'Destacado',
            'Limitado',
            'Exclusivo',
            'Bestseller',
            'Eco-friendly',
            'Importado',
            'Artesanal',
            'Premium',
            'Vegano',
            'Orgánico',
            'Sin gluten',
            'Temporada',
            'Reacondicionado'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }
    }
}
