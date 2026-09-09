# Solutions — 08.3 Testing with Pest and PHPUnit in Laravel

## Exercise 1

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```
```php
test('the listings list responds 200', function () {
    $response = $this->get('/annonces');
    $response->assertStatus(200);
});
```

## Exercise 2

```php
test('a logged-in user can create a listing', function () {
    $user = User::factory()->create();
    $categorie = Category::factory()->create();

    $this->actingAs($user)->post('/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Coffee table',
        'description' => 'Good condition',
        'prix' => 40,
    ]);

    $this->assertDatabaseHas('annonces', ['titre' => 'Coffee table']);
});
```

## Exercise 3

```php
test('the owner can edit their listing', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->put("/annonces/{$annonce->id}", [
        'categorie_id' => $annonce->categorie_id,
        'titre' => 'Modified title',
        'description' => $annonce->description,
        'prix' => $annonce->prix,
    ]);

    $response->assertRedirect();
});

test('a third party cannot edit a listing', function () {
    $proprietaire = User::factory()->create();
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $proprietaire->id]);

    $response = $this->actingAs($tiers)->put("/annonces/{$annonce->id}", ['titre' => 'X']);

    $response->assertForbidden();
});
```

## Exercise 4

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\NouveauMessageNotification;

test('a contact message triggers a notification to the seller', function () {
    Notification::fake();

    $vendeur = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $vendeur->id]);

    $this->post("/annonces/{$annonce->id}/messages", [
        'expediteur_nom' => 'Alice',
        'expediteur_email' => 'alice@example.com',
        'contenu' => 'Still available?',
    ]);

    Notification::assertSentTo($vendeur, NouveauMessageNotification::class);
});
```

## Exercise 5

```php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('the owner can edit', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->put("/annonces/{$annonce->id}", validPayload($annonce))->assertRedirect();
});

test('the owner can delete', function () {
    $user = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->delete("/annonces/{$annonce->id}")->assertRedirect();
});

test('a third party cannot edit', function () {
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create();
    $this->actingAs($tiers)->put("/annonces/{$annonce->id}", ['titre' => 'X'])->assertForbidden();
});

test('a third party cannot delete', function () {
    $tiers = User::factory()->create();
    $annonce = Annonce::factory()->create();
    $this->actingAs($tiers)->delete("/annonces/{$annonce->id}")->assertForbidden();
});

test('a logged-out visitor is redirected to login', function () {
    $annonce = Annonce::factory()->create();
    $this->put("/annonces/{$annonce->id}", ['titre' => 'X'])->assertRedirect('/login');
});

function validPayload(Annonce $annonce): array
{
    return [
        'categorie_id' => $annonce->categorie_id,
        'titre' => 'Modified title',
        'description' => $annonce->description,
        'prix' => $annonce->prix,
    ];
}
```
`RefreshDatabase` resets the database before EVERY test: running the
suite several times in a row produces identical results, since no test
can see data left behind by a previous one.
