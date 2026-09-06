<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nom' => ucfirst(fake()->words(3, true)),
            'description' => fake()->sentence(),
            'actif' => fake()->boolean(85),
        ];
    }
}
