<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnoncesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->count(6)->create();
        $utilisateurs = User::factory()->count(5)->create();

        Annonce::factory()
            ->count(30)
            ->recycle($categories)  // réutilise les catégories déjà créées plutôt que d'en créer 30 nouvelles
            ->recycle($utilisateurs)
            ->create();
    }
}
