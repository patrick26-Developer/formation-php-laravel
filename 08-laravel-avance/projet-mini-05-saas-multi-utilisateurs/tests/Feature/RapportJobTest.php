<?php

declare(strict_types=1);

use App\Contracts\RapportGenerator;
use App\Jobs\GenererRapportHebdomadaire;
use App\Models\Project;
use App\Models\Tenant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

test('demander un rapport distribue bien le job', function () {
    Queue::fake();

    $tenant = Tenant::factory()->create();
    $utilisateur = User::factory()->create(['tenant_id' => $tenant->id]);

    $this->actingAs($utilisateur)->post('/rapport-hebdomadaire');

    Queue::assertPushed(GenererRapportHebdomadaire::class);
});

test('le générateur de rapport calcule les bonnes statistiques', function () {
    $tenant = Tenant::factory()->create();
    $projet = Project::factory()->for($tenant)->create(['actif' => true]);
    Task::factory()->for($projet)->create(['terminee' => true]);
    Task::factory()->for($projet)->create(['terminee' => false]);

    /** @var RapportGenerator $generateur */
    $generateur = app(RapportGenerator::class); // résolu via le Service Container (module 08.4)

    $rapport = $generateur->genererPourTenant($tenant);

    expect($rapport['projets_actifs'])->toBe(1)
        ->and($rapport['taches_totales'])->toBe(2)
        ->and($rapport['taches_terminees'])->toBe(1);
});
