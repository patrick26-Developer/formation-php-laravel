<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('un utilisateur peut se connecter et obtenir un jeton', function () {
    $user = User::factory()->create(['password' => Hash::make('motdepasse123')]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'motdepasse123',
    ]);

    $response->assertOk()->assertJsonStructure(['token', 'token_type']);
});

test('une connexion avec un mauvais mot de passe échoue avec 401', function () {
    $user = User::factory()->create(['password' => Hash::make('motdepasse123')]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'mauvais-mot-de-passe',
    ]);

    $response->assertStatus(401);
});

test('un jeton valide donne accès à /api/v1/me', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/v1/me');

    $response->assertOk()->assertJson(['email' => $user->email]);
});

test('sans jeton, /api/v1/me retourne 401', function () {
    $this->getJson('/api/v1/me')->assertStatus(401);
});
