<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnonceFactory extends Factory
{
    protected $model = Annonce::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'categorie_id' => Category::factory(),
            'titre' => ucfirst(fake()->words(4, true)),
            'description' => fake()->paragraphs(3, true),
            'prix' => fake()->randomFloat(2, 5, 2000),
            'active' => fake()->boolean(90),
        ];
    }
}
