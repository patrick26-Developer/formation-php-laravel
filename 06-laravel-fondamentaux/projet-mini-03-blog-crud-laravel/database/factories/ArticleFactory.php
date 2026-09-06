<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $titre = fake()->sentence(6);

        return [
            'categorie_id' => Category::factory(),
            'titre' => rtrim($titre, '.'),
            'slug' => Str::slug($titre) . '-' . fake()->unique()->numberBetween(1, 100000),
            'contenu' => fake()->paragraphs(4, true),
            'publie' => fake()->boolean(80),
        ];
    }
}
