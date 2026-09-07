<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaasFacturationSeeder extends Seeder
{
    public function run(): void
    {
        $gratuit = Plan::create(['nom' => 'Gratuit', 'prix_mensuel' => 0, 'limite_projets' => 2]);
        $pro = Plan::create(['nom' => 'Pro', 'prix_mensuel' => 29.00, 'limite_projets' => 20]);
        Plan::create(['nom' => 'Entreprise', 'prix_mensuel' => 99.00, 'limite_projets' => 0]); // illimité

        $tenant = Tenant::create(['nom' => 'Acme Corp']);

        User::factory()->create(['tenant_id' => $tenant->id, 'email' => 'demo@acme.test']);

        Subscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $pro->id,
            'statut' => 'active',
            'debut_periode' => now()->subDays(15),
            'fin_periode' => now()->addDays(15),
        ]);
    }
}
