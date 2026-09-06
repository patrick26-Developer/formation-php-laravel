<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'article_id' => Article::factory(),
            'nom_auteur' => fake()->name(),
            'contenu' => fake()->paragraph(),
        ];
    }
}
