<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $nom = ucfirst(fake()->words(3, true));

        return [
            'category_id' => Category::factory(),
            'nom' => $nom,
            'slug' => Str::slug($nom) . '-' . fake()->unique()->numberBetween(1, 100000),
            'description' => fake()->paragraph(),
            'prix' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 50),
        ];
    }
}
