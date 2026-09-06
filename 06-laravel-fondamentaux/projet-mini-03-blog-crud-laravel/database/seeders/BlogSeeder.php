<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->count(4)
            ->create()
            ->each(function (Category $categorie) {
                Article::factory()
                    ->count(5)
                    ->for($categorie, 'categorie')
                    ->create()
                    ->each(function (Article $article) {
                        $article->comments()->saveMany(
                            \App\Models\Comment::factory()->count(rand(0, 4))->make()
                        );
                    });
            });
    }
}
