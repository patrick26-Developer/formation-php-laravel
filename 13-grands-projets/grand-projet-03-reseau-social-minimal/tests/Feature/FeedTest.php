<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use App\Notifications\NouvelAbonneNotification;
use App\Notifications\PostAimeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('le fil d\'actualité affiche ses propres publications et celles des comptes suivis', function () {
    $moi = User::factory()->create();
    $suivi = User::factory()->create();
    $nonSuivi = User::factory()->create();

    $moi->following()->attach($suivi->id);

    $monPost = Post::factory()->for($moi)->create(['contenu' => 'Mon propre post']);
    $postSuivi = Post::factory()->for($suivi)->create(['contenu' => 'Post du compte suivi']);
    $postNonSuivi = Post::factory()->for($nonSuivi)->create(['contenu' => 'Post invisible']);

    $response = $this->actingAs($moi)->get('/fil-actualite');

    $response->assertSee('Mon propre post')
        ->assertSee('Post du compte suivi')
        ->assertDontSee('Post invisible');
});

test('suivre un utilisateur déclenche une notification', function () {
    Notification::fake();

    $moi = User::factory()->create();
    $cible = User::factory()->create();

    $this->actingAs($moi)->post("/utilisateurs/{$cible->id}/suivre");

    expect($moi->fresh()->suit($cible))->toBeTrue();
    Notification::assertSentTo($cible, NouvelAbonneNotification::class);
});

test('se suivre soi-même est refusé', function () {
    $moi = User::factory()->create();

    $response = $this->actingAs($moi)->post("/utilisateurs/{$moi->id}/suivre");

    $response->assertSessionHas('erreur');
    expect($moi->fresh()->suit($moi))->toBeFalse();
});

test('aimer un post déclenche une notification, sauf pour son propre post', function () {
    Notification::fake();

    $auteur = User::factory()->create();
    $admirateur = User::factory()->create();
    $post = Post::factory()->for($auteur)->create();

    $this->actingAs($admirateur)->post("/posts/{$post->id}/aimer");
    Notification::assertSentTo($auteur, PostAimeNotification::class);

    Notification::fake(); // réinitialise le compteur
    $autrePost = Post::factory()->for($auteur)->create();
    $this->actingAs($auteur)->post("/posts/{$autrePost->id}/aimer");
    Notification::assertNothingSent();
});
