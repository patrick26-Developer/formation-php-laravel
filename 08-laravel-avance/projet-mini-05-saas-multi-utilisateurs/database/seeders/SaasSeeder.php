<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tenant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaasSeeder extends Seeder
{
    public function run(): void
    {
        collect(['Acme Corp', 'Globex', 'Initech'])->each(function (string $nomTenant) {
            $tenant = Tenant::factory()->create(['nom' => $nomTenant]);

            User::factory()->count(2)->create(['tenant_id' => $tenant->id]);

            Project::factory()
                ->count(4)
                ->for($tenant)
                ->create()
                ->each(function (Project $project) {
                    Task::factory()->count(rand(3, 8))->for($project)->create();
                });
        });
    }
}
