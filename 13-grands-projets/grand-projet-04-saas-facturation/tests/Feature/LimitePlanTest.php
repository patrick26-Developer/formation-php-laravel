<?php

declare(strict_types=1);

use App\Models\Plan;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function creerTenantAvecPlan(int $limiteProjets): array
{
    $plan = Plan::create(['nom' => 'Test', 'prix_mensuel' => 10, 'limite_projets' => $limiteProjets]);
    $tenant = Tenant::create(['nom' => 'Tenant Test']);
    Subscription::create([
        'tenant_id' => $tenant->id,
        'plan_id' => $plan->id,
        'statut' => 'active',
        'debut_periode' => now()->subDay(),
        'fin_periode' => now()->addMonth(),
    ]);
    $utilisateur = User::factory()->create(['tenant_id' => $tenant->id]);

    return [$tenant, $utilisateur];
}

test('un tenant peut créer des projets sous la limite de son plan', function () {
    [$tenant, $utilisateur] = creerTenantAvecPlan(2);

    $this->actingAs($utilisateur)->post('/projects', ['nom' => 'Projet 1'])->assertSessionMissing('erreur');
    $this->actingAs($utilisateur)->post('/projects', ['nom' => 'Projet 2'])->assertSessionMissing('erreur');

    expect(Project::withoutGlobalScope('tenant')->where('tenant_id', $tenant->id)->count())->toBe(2);
});

test('créer un projet au-delà de la limite du plan est refusé', function () {
    [$tenant, $utilisateur] = creerTenantAvecPlan(1);

    $this->actingAs($utilisateur)->post('/projects', ['nom' => 'Projet 1']);
    $this->actingAs($utilisateur)->post('/projects', ['nom' => 'Projet 2'])->assertSessionHas('erreur');

    expect(Project::withoutGlobalScope('tenant')->where('tenant_id', $tenant->id)->count())->toBe(1);
});

test('un plan à limite 0 est illimité', function () {
    [$tenant, $utilisateur] = creerTenantAvecPlan(0);

    for ($i = 1; $i <= 10; $i++) {
        $this->actingAs($utilisateur)->post('/projects', ['nom' => "Projet $i"])->assertSessionMissing('erreur');
    }

    expect(Project::withoutGlobalScope('tenant')->where('tenant_id', $tenant->id)->count())->toBe(10);
});

test('deux tenants ne voient jamais les projets l\'un de l\'autre', function () {
    [, $utilisateurA] = creerTenantAvecPlan(10);
    [, $utilisateurB] = creerTenantAvecPlan(10);

    $this->actingAs($utilisateurA)->post('/projects', ['nom' => 'Projet privé A']);

    $reponse = $this->actingAs($utilisateurB)->get('/projects');

    $reponse->assertDontSee('Projet privé A');
});
