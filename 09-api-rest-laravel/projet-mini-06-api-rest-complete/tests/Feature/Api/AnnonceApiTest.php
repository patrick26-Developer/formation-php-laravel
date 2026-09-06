<?php

declare(strict_types=1);

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('la liste des annonces actives est accessible sans authentification', function () {
    Annonce::factory()->count(3)->create(['active' => true]);
    Annonce::factory()->create(['active' => false]);

    $response = $this->getJson('/api/v1/annonces');

    $response->assertOk()->assertJsonCount(3, 'data');
});

test('la structure JSON d\'une annonce correspond à AnnonceResource', function () {
    $annonce = Annonce::factory()->create();

    $response = $this->getJson("/api/v1/annonces/{$annonce->id}");

    $response->assertOk()->assertJsonStructure([
        'data' => ['id', 'titre', 'description', 'prix', 'image_url', 'active', 'categorie', 'cree_le'],
    ]);
});

test('créer une annonce sans authentification échoue avec 401', function () {
    $categorie = Category::factory()->create();

    $response = $this->postJson('/api/v1/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Vélo',
        'description' => 'Bon état',
        'prix' => 100,
    ]);

    $response->assertStatus(401);
});

test('un utilisateur authentifié peut créer une annonce', function () {
    $user = User::factory()->create();
    $categorie = Category::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/v1/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Vélo de course',
        'description' => 'Très bon état',
        'prix' => 250,
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('annonces', ['titre' => 'Vélo de course', 'user_id' => $user->id]);
});

test('un utilisateur ne peut pas supprimer l\'annonce d\'un autre (Policy réutilisée du niveau 07)', function () {
    $proprietaire = User::factory()->create();
    $autre = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $proprietaire->id]);

    $token = $autre->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->deleteJson("/api/v1/annonces/{$annonce->id}");

    $response->assertForbidden();
});
