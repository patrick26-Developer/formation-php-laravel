# 08.3 — Testing with Pest and PHPUnit in Laravel

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the difference between Unit and Feature tests in Laravel.
- Write Feature tests covering routes, controllers, database.
- Use modern Pest syntax.
- Use `RefreshDatabase` and factories in tests.

## 📋 Prerequisites

[03.3 — Unit Testing with PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.en.md), [Level 07 — Intermediate Laravel](../../07-laravel-intermediaire/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Unit vs Feature: two levels of testing

| | **Unit** test | **Feature** test |
|---|---|---|
| What it tests | An isolated class/method (as in module 03.3) | End-to-end behavior: an HTTP request, the database, the views |
| Database | Usually none (mocks) | Real (dedicated test database, reset each time) |
| Example | `CalculatriceTest` (module 03.3) | "a visitor can create a listing and sees it appear in the list" |

> 📌 For a Laravel application, the **majority** of useful tests are **Feature** tests: they verify the real behavior perceived by a user, across the whole stack (routing → middleware → controller → Eloquent → database → response).

### Installing Pest

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### A Feature test with Pest

```php
// tests/Feature/AnnonceTest.php
use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;

test('a visitor can see the list of active listings', function () {
    Annonce::factory()->count(3)->create(['active' => true]);
    Annonce::factory()->create(['active' => false]);

    $response = $this->get('/annonces');

    $response->assertStatus(200);
    $response->assertViewHas('annonces', function ($annonces) {
        return $annonces->total() === 3; // the inactive listing doesn't appear
    });
});

test('a logged-in user can create a listing', function () {
    $user = User::factory()->create();
    $categorie = Category::factory()->create();

    $response = $this->actingAs($user)->post('/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Bike for sale',
        'description' => 'Very good condition',
        'prix' => 150,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('annonces', ['titre' => 'Bike for sale', 'user_id' => $user->id]);
});

test('a logged-out visitor cannot create a listing', function () {
    $response = $this->post('/annonces', ['titre' => 'Test']);

    $response->assertRedirect('/login'); // the "auth" middleware (module 07.3) redirects
});
```

> 💡 Compare Pest's syntax (`test('...', function () { ... })`) with PHPUnit's `extends TestCase` classes (module 03.3): Pest is a **layer on top of PHPUnit** (not a different test engine), offering a more concise syntax, without ever forcing you to write a class.

### `RefreshDatabase`: a clean database for every test

```php
// tests/Pest.php (global configuration)
uses(Illuminate\Foundation\Testing\RefreshDatabase::class)->in('Feature');
```

> ⚠️ Without `RefreshDatabase`, data created by one test would **persist** into the next, causing inconsistent results depending on execution order — the same isolation problem already solved by `setUp()` recreating a fresh object for every test in [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.en.md), applied here to the entire database.

### Testing authorization (Policy, module 07.5)

```php
test('a user cannot edit someone else\'s listing', function () {
    $proprietaire = User::factory()->create();
    $autreUtilisateur = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $proprietaire->id]);

    $response = $this->actingAs($autreUtilisateur)
        ->put("/annonces/{$annonce->id}", ['titre' => 'Modified']);

    $response->assertForbidden(); // 403, the Policy correctly denied it
});
```

### Testing a Job (module 08.1) without actually running it

```php
use Illuminate\Support\Facades\Queue;

test('sending a message dispatches a notification job', function () {
    Queue::fake(); // replaces the real queue with a spy

    $annonce = Annonce::factory()->create();

    $this->post("/annonces/{$annonce->id}/messages", [
        'expediteur_nom' => 'Alice',
        'expediteur_email' => 'alice@example.com',
        'contenu' => 'Hi, is this still available?',
    ]);

    Queue::assertPushed(EnvoyerNotificationMessage::class);
});
```

> 💡 `Queue::fake()` avoids actually running the Job (so no real email is sent) while still verifying it was correctly **dispatched** — a fast, reliable test with no external dependency.

## ✅ Key takeaways

- A Feature test verifies end-to-end behavior; a Unit test isolates a specific class.
- Pest is a more concise syntax on top of PHPUnit, not a different engine.
- `RefreshDatabase` guarantees a clean database for every test — the equivalent of `setUp()` applied to the whole database.
- `Queue::fake()`/`Mail::fake()`/`Notification::fake()` verify that an action was triggered without actually executing it.

## ➡️ Going further

- [pestphp.com/docs](https://pestphp.com/docs)
- [laravel.com/docs — Testing: Getting Started](https://laravel.com/docs/testing)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [08.2 — Cache and Performance Optimization](../02-cache-optimisation-performance/README.en.md) · **Next:** [08.4 — Service Providers and Custom Packages](../04-packages-service-providers-personnalises/README.en.md)
