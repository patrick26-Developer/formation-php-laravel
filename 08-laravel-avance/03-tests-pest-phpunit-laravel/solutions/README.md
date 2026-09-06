# Solutions — 08.3 Tests avec Pest et PHPUnit dans Laravel

## Exercice 1

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```
```php
test('la liste des annonces répond 200', function () {
    $response = $this->get('/annonces');
    $response->assertStatus(200);
});
```

## Exercice 2

```php
test('un utilisateur connecté peut créer une annonce', function () {
    $user = User::factory()->create();
    $categorie = Category::factory()->create();

    $this->actingAs($user)->post('/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Table basse',
        'description' => 'En bon état',
        'prix' => 40,
    ]);

    $this->assertDatabaseHas('annonces', ['titre' => 'Table basse']);
});
```

## Exercice 3

```php
test('le propriétaire peut modifier son annonce', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->put("/annonces/{$annonce->id}", [
        'categorie_id' => $annonce->categorie_id,
        'titre' => 'Titre modifié',
        'description' => $annonce->description,
        'prix' => $annonce->prix,
    ]);

    $response->assertRedirect();
});

test('un tiers ne peut pas modifier une annonce', function () {
    $proprietaire = User::factory()->create();
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $proprietaire->id]);

    $response = $this->actingAs($tiers)->put("/annonces/{$annonce->id}", ['titre' => 'X']);

    $response->assertForbidden();
});
```

## Exercice 4

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\NouveauMessageNotification;

test('un message de contact déclenche une notification au vendeur', function () {
    Notification::fake();

    $vendeur = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $vendeur->id]);

    $this->post("/annonces/{$annonce->id}/messages", [
        'expediteur_nom' => 'Alice',
        'expediteur_email' => 'alice@example.com',
        'contenu' => 'Toujours disponible ?',
    ]);

    Notification::assertSentTo($vendeur, NouveauMessageNotification::class);
});
```

## Exercice 5

```php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('le propriétaire peut modifier', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->put("/annonces/{$annonce->id}", validPayload($annonce))->assertRedirect();
});

test('le propriétaire peut supprimer', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->delete("/annonces/{$annonce->id}")->assertRedirect();
});

test('un tiers ne peut pas modifier', function () {
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create();
    $this->actingAs($tiers)->put("/annonces/{$annonce->id}", ['titre' => 'X'])->assertForbidden();
});

test('un tiers ne peut pas supprimer', function () {
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create();
    $this->actingAs($tiers)->delete("/annonces/{$annonce->id}")->assertForbidden();
});

test('un visiteur non connecté est redirigé vers la connexion', function () {
    $annonce = Annonce::factory()->create();
    $this->put("/annonces/{$annonce->id}", ['titre' => 'X'])->assertRedirect('/login');
});

function validPayload(Annonce $annonce): array
{
    return [
        'categorie_id' => $annonce->categorie_id,
        'titre' => 'Titre modifié',
        'description' => $annonce->description,
        'prix' => $annonce->prix,
    ];
}
```
`RefreshDatabase` réinitialise la base avant CHAQUE test : exécuter la
suite plusieurs fois de suite produit des résultats identiques, car aucun
test ne peut voir les données laissées par un précédent.
