<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(50)->create()->each(function ($product) {
            $product->tags()->attach(
                Tag::inRandomOrder()->limit(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
