# 08.3 — Tests avec Pest et PHPUnit dans Laravel

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la différence entre tests Unit et tests Feature dans Laravel.
- Écrire des tests Feature couvrant routes, contrôleurs, base de données.
- Utiliser la syntaxe moderne Pest.
- Utiliser `RefreshDatabase` et les factories dans les tests.

## 📋 Prérequis

[03.3 — Tests unitaires avec PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.md), [Niveau 07 — Laravel Intermédiaire](../../07-laravel-intermediaire/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Unit vs Feature : deux niveaux de test

| | Test **Unit** | Test **Feature** |
|---|---|---|
| Ce qu'il teste | Une classe/méthode isolée (comme au module 03.3) | Le comportement de bout en bout : une requête HTTP, la base de données, les vues |
| Base de données | Généralement aucune (mocks) | Réelle (base de test dédiée, réinitialisée) |
| Exemple | `CalculatriceTest` (module 03.3) | "un visiteur peut créer une annonce et la voit apparaître dans la liste" |

> 📌 Pour une application Laravel, la **majorité** des tests utiles sont des tests **Feature** : ils vérifient le comportement réel perçu par un utilisateur, à travers toute la pile (routing → middleware → contrôleur → Eloquent → base de données → réponse).

### Installer Pest

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### Un test Feature avec Pest

```php
// tests/Feature/AnnonceTest.php
use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;

test('un visiteur peut voir la liste des annonces actives', function () {
    Annonce::factory()->count(3)->create(['active' => true]);
    Annonce::factory()->create(['active' => false]);

    $response = $this->get('/annonces');

    $response->assertStatus(200);
    $response->assertViewHas('annonces', function ($annonces) {
        return $annonces->total() === 3; // l'annonce inactive n'apparaît pas
    });
});

test('un utilisateur connecté peut créer une annonce', function () {
    $user = User::factory()->create();
    $categorie = Category::factory()->create();

    $response = $this->actingAs($user)->post('/annonces', [
        'categorie_id' => $categorie->id,
        'titre' => 'Vélo à vendre',
        'description' => 'Très bon état',
        'prix' => 150,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('annonces', ['titre' => 'Vélo à vendre', 'user_id' => $user->id]);
});

test('un visiteur non connecté ne peut pas créer d\'annonce', function () {
    $response = $this->post('/annonces', ['titre' => 'Test']);

    $response->assertRedirect('/login'); // le middleware "auth" (module 07.3) redirige
});
```

> 💡 Comparez la syntaxe Pest (`test('...', function () { ... })`) avec les classes `extends TestCase` de PHPUnit (module 03.3) : Pest est une **couche par-dessus PHPUnit** (pas un moteur de test différent), offrant une syntaxe plus concise, sans jamais imposer d'écrire une classe.

### `RefreshDatabase` : une base propre à chaque test

```php
// tests/Pest.php (configuration globale)
uses(Illuminate\Foundation\Testing\RefreshDatabase::class)->in('Feature');
```

> ⚠️ Sans `RefreshDatabase`, les données créées par un test **persisteraient** pour le test suivant, causant des résultats incohérents selon l'ordre d'exécution — le même problème d'isolation déjà résolu par `setUp()` recréant un objet frais à chaque test au [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.md), ici appliqué à toute la base de données.

### Tester une autorisation (Policy, module 07.5)

```php
test('un utilisateur ne peut pas modifier l\'annonce d\'un autre', function () {
    $proprietaire = User::factory()->create();
    $autreUtilisateur = User::factory()->create();
    $annonce = Annonce::factory()->create(['user_id' => $proprietaire->id]);

    $response = $this->actingAs($autreUtilisateur)
        ->put("/annonces/{$annonce->id}", ['titre' => 'Modifié']);

    $response->assertForbidden(); // 403, la Policy a bien refusé
});
```

### Tester un Job (module 08.1) sans réellement l'exécuter

```php
use Illuminate\Support\Facades\Queue;

test('l\'envoi d\'un message distribue un job de notification', function () {
    Queue::fake(); // remplace la vraie file d'attente par un espion

    $annonce = Annonce::factory()->create();

    $this->post("/annonces/{$annonce->id}/messages", [
        'expediteur_nom' => 'Alice',
        'expediteur_email' => 'alice@example.com',
        'contenu' => 'Bonjour, est-ce disponible ?',
    ]);

    Queue::assertPushed(EnvoyerNotificationMessage::class);
});
```

> 💡 `Queue::fake()` évite d'exécuter réellement le Job (donc pas de vrai email envoyé) tout en vérifiant qu'il a bien été **distribué** — un test rapide et fiable, sans dépendance externe.

## ✅ Points clés à retenir

- Un test Feature vérifie un comportement de bout en bout ; un test Unit isole une classe précise.
- Pest est une syntaxe plus concise par-dessus PHPUnit, pas un moteur différent.
- `RefreshDatabase` garantit une base propre à chaque test — l'équivalent de `setUp()` appliqué à toute la base.
- `Queue::fake()`/`Mail::fake()`/`Notification::fake()` vérifient qu'une action a été déclenchée sans l'exécuter réellement.

## ➡️ Pour aller plus loin

- [pestphp.com/docs](https://pestphp.com/docs)
- [laravel.com/docs — Testing: Getting Started](https://laravel.com/docs/testing)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [08.2 — Cache et optimisation de performance](../02-cache-optimisation-performance/README.md) · **Suite :** [08.4 — Service Providers et packages personnalisés](../04-packages-service-providers-personnalises/README.md)
