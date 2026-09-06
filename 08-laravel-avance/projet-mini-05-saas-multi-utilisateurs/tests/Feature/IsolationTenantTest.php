<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un utilisateur ne voit que les projets de son propre tenant', function () {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();

    $utilisateurA = User::factory()->create(['tenant_id' => $tenantA->id]);

    Project::factory()->count(3)->for($tenantA)->create();
    Project::factory()->count(5)->for($tenantB)->create();

    $this->actingAs($utilisateurA);

    // Le scope global (module 08.5) filtre automatiquement par tenant_id
    expect(Project::count())->toBe(3);
});

test('un utilisateur ne peut pas afficher le projet d\'un autre tenant', function () {
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();

    $utilisateurA = User::factory()->create(['tenant_id' => $tenantA->id]);
    $projetB = Project::factory()->for($tenantB)->create();

    $response = $this->actingAs($utilisateurA)->get("/projects/{$projetB->id}");

    // Le scope global empêche même Eloquent de RETROUVER ce projet :
    // Laravel répond donc 404 (introuvable dans le périmètre du tenant),
    // pas 403 (le Model Binding échoue avant même d'atteindre la Policy).
    $response->assertNotFound();
});

test('un projet créé est automatiquement associé au bon tenant', function () {
    $tenant = Tenant::factory()->create();
    $utilisateur = User::factory()->create(['tenant_id' => $tenant->id]);

    $this->actingAs($utilisateur)->post('/projects', ['nom' => 'Nouveau projet']);

    $this->assertDatabaseHas('projects', ['nom' => 'Nouveau projet', 'tenant_id' => $tenant->id]);
});
