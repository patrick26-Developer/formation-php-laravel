<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReseauSocialSeeder extends Seeder
{
    public function run(): void
    {
        $utilisateurs = User::factory()->count(10)->create();

        $utilisateurs->each(function (User $utilisateur) use ($utilisateurs) {
            Post::factory()->count(rand(1, 5))->for($utilisateur)->create();

            // Chaque utilisateur suit 2 à 4 autres utilisateurs au hasard.
            $aSuivre = $utilisateurs->where('id', '!=', $utilisateur->id)->random(min(3, $utilisateurs->count() - 1));
            $utilisateur->following()->attach($aSuivre->pluck('id'));
        });
    }
}
