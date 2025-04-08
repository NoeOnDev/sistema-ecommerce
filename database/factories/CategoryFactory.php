<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'slug' => Str::slug($name),
        ];
    }
}
