<?php

declare(strict_types=1);

use App\Livewire\Admin\AnnoncesTable;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('la table affiche uniquement les annonces correspondant à la recherche', function () {
    $admin = User::factory()->create(['est_admin' => true]);

    Annonce::factory()->create(['titre' => 'Vélo de course']);
    Annonce::factory()->create(['titre' => 'Table basse']);

    Livewire::actingAs($admin)
        ->test(AnnoncesTable::class)
        ->set('recherche', 'vélo')
        ->assertSee('Vélo de course')
        ->assertDontSee('Table basse');
});

test('basculer le statut désactive une annonce active', function () {
    $admin = User::factory()->create(['est_admin' => true]);
    $annonce = Annonce::factory()->create(['active' => true]);

    Livewire::actingAs($admin)
        ->test(AnnoncesTable::class)
        ->call('basculerStatut', $annonce->id);

    expect($annonce->fresh()->active)->toBeFalse();
});

test('changer la recherche réinitialise la pagination à la page 1', function () {
    $admin = User::factory()->create(['est_admin' => true]);
    Annonce::factory()->count(25)->create();

    Livewire::actingAs($admin)
        ->test(AnnoncesTable::class)
        ->set('page', 3)
        ->set('recherche', 'introuvable-xyz')
        ->assertSet('paginators.page', 1);
});
