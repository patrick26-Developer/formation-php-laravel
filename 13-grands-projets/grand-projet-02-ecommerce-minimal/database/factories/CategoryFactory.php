<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nom = fake()->unique()->randomElement(['Informatique', 'Livres', 'Maison', 'Sport', 'Jouets']);

        return ['nom' => $nom, 'slug' => Str::slug($nom)];
    }
}
