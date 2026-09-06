<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'titre' => ucfirst(fake()->words(4, true)),
            'terminee' => fake()->boolean(40),
        ];
    }
}
