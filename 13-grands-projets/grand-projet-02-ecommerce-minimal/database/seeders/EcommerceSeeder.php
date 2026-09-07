<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(5)->create()->each(function (Category $categorie) {
            Product::factory()->count(8)->for($categorie)->create();
        });
    }
}
