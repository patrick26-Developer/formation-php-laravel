# 07.3 — Middlewares et Form Requests

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle d'un middleware dans le cycle de vie d'une requête.
- Créer et enregistrer un middleware personnalisé.
- Approfondir les Form Requests avec autorisation intégrée.

## 📋 Prérequis

[06.6 — Validation des formulaires](../../06-laravel-fondamentaux/06-validation-formulaires/README.md), [03.2 — Architecture MVC from scratch](../../03-php-avance/02-architecture-mvc-from-scratch/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Qu'est-ce qu'un middleware ?

Un **middleware** intercepte une requête HTTP **avant** qu'elle n'atteigne le contrôleur (et peut aussi agir sur la réponse, après). C'est exactement le mécanisme que vous avez construit à la main : `Auth::exigerConnexion()` au [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md), ou les middlewares du `Routeur` à l'[exercice 5 du module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.md).

```php
php artisan make:middleware EstAdmin
```

```php
// app/Http/Middleware/EstAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->est_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request); // laisse la requête continuer vers le contrôleur
    }
}
```

> 💡 `return $next($request);` est l'exact équivalent du `($route['gestionnaire'])();` de votre `Routeur.php` maison, appelé **seulement si** le middleware n'a pas déjà interrompu la requête (via `abort()` ou une redirection).

### Enregistrer et utiliser un middleware

Depuis Laravel 11, les middlewares s'enregistrent dans `bootstrap/app.php` (rappel du [module 06.1](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.md)) :

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\EstAdmin::class,
    ]);
})
```

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/tableau-de-bord', [AdminController::class, 'dashboard']);
});
```

> 📌 Les middlewares s'exécutent **dans l'ordre déclaré** : ici, `auth` (l'utilisateur doit être connecté) s'exécute avant `admin` (l'utilisateur doit être admin) — logique, puisqu'il faut être identifié avant de vérifier un rôle.

### Middleware avec paramètres

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if ($request->user()?->role !== $role) {
        abort(403);
    }

    return $next($request);
}
```

```php
Route::middleware('role:editeur')->group(function () { /* ... */ });
```

### Form Requests : l'autorisation intégrée

Reprise du [module 06.6](../../06-laravel-fondamentaux/06-validation-formulaires/README.md), la méthode `authorize()` d'un Form Request combine validation **et** autorisation en un seul endroit :

```php
// app/Http/Requests/UpdateArticleRequest.php
public function authorize(): bool
{
    $article = $this->route('article'); // récupère le modèle injecté par la route

    return $this->user()->id === $article->user_id; // seul l'auteur peut modifier
}

public function rules(): array
{
    return [
        'titre' => 'required|max:150',
    ];
}
```

Si `authorize()` retourne `false`, Laravel renvoie automatiquement une erreur **403**, avant même d'exécuter `rules()` — aucun code supplémentaire nécessaire dans le contrôleur.

> ⚠️ Pour des règles d'autorisation plus riches (plusieurs actions, réutilisées sur plusieurs contrôleurs), préférez les **Policies** (module 07.5) à une logique `authorize()` dupliquée dans chaque Form Request.

## ✅ Points clés à retenir

- Un middleware intercepte une requête avant (et potentiellement après) le contrôleur — le même principe que vos middlewares maison du module 03.2.
- Depuis Laravel 11, les middlewares s'enregistrent dans `bootstrap/app.php`, plus dans `Kernel.php`.
- Les middlewares d'un groupe s'exécutent dans l'ordre déclaré.
- `authorize()` dans un Form Request combine validation et autorisation ; pour une logique plus riche, préférez une Policy (module 07.5).

## ➡️ Pour aller plus loin

- [laravel.com/docs — Middleware](https://laravel.com/docs/middleware)
- [Module 07.5 — Autorisations : Policies et Gates](../05-autorisations-policies-gates/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.2 — Scopes, accessors, mutators](../02-eloquent-scopes-accessors-mutators/README.md) · **Suite :** [07.4 — Authentification Breeze/Fortify](../04-authentification-breeze-fortify/README.md)
