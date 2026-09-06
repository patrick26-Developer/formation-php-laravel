# 09.3 — Authentification API avec Sanctum

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le fonctionnement des jetons d'API Sanctum.
- Authentifier une application mobile/tierce via des jetons personnels.
- Authentifier une SPA (Single Page Application) via les cookies Sanctum.
- Protéger des routes API avec le middleware `auth:sanctum`.

## 📋 Prérequis

[09.2 — API Resources et transformation des données](../02-api-resources-transformers/README.md), [07.4 — Authentification Breeze/Fortify](../../07-laravel-intermediaire/04-authentification-breeze-fortify/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Pourquoi pas les sessions pour une API ?

Breeze (module 07.4) authentifie via **sessions** — adapté à une application web classique où le navigateur conserve un cookie de session. Une API consommée par une application **mobile** (qui n'a pas de "session navigateur") a besoin d'un mécanisme différent : un **jeton** (token) envoyé à chaque requête, prouvant l'identité du client.

```
Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...
```

### Installer Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
php artisan migrate
```

```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}
```

### Jetons personnels : pour une application mobile ou machine-à-machine

```php
// Un endpoint de connexion dédié à l'API
Route::post('/api/login', function (Request $request) {
    $request->validate(['email' => 'required|email', 'password' => 'required']);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Identifiants invalides.'], 401);
    }

    $jeton = $user->createToken('mobile-app')->plainTextToken;

    return response()->json(['token' => $jeton]);
});
```

```php
// Le client mobile envoie ensuite ce jeton dans CHAQUE requête suivante :
// Authorization: Bearer <jeton>

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('annonces', AnnonceController::class);
});
```

> 💡 `createToken('mobile-app')->plainTextToken` génère et **stocke un hash** du jeton en base (table `personal_access_tokens`), retournant la valeur en clair **une seule fois** — exactement comme un mot de passe (module 02.5) : impossible de la retrouver ensuite, seule sa vérification est possible.

### Révoquer un jeton (déconnexion API)

```php
Route::post('/api/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnecté.']);
})->middleware('auth:sanctum');
```

### Limiter les capacités d'un jeton (abilities)

```php
$jeton = $user->createToken('mobile-app', ['annonces:lire'])->plainTextToken;
```

```php
Route::get('/api/annonces', [AnnonceController::class, 'index'])
    ->middleware(['auth:sanctum', 'ability:annonces:lire']);
```

> 📌 Utile pour distinguer, par exemple, un jeton mobile "lecture seule" d'un jeton d'intégration partenaire ayant besoin d'écrire des données — le même principe que les scopes OAuth2 (module 09.4), en plus simple.

### Sanctum pour une SPA (authentification par cookie, pas par jeton)

Pour un frontend JavaScript séparé (Vue/React) sur le **même domaine** (ou un sous-domaine), Sanctum propose une authentification par cookie de session — plus proche de Breeze que des jetons personnels :

```
# .env
SANCTUM_STATEFUL_DOMAINS=mon-app.test
```

Le frontend appelle `/sanctum/csrf-cookie` avant la connexion, puis s'authentifie via une route de connexion classique — Laravel reconnaît alors les requêtes suivantes de ce domaine comme authentifiées, sans jeton explicite à gérer côté JavaScript.

> 📌 Retenez la distinction : **jetons personnels** pour du mobile/machine-à-machine (stateless), **cookies Sanctum** pour une SPA sur le même domaine (avec état de session, comme Breeze).

## ✅ Points clés à retenir

- Sanctum authentifie via un jeton `Bearer` envoyé dans l'en-tête `Authorization`, adapté au mobile/machine-à-machine.
- `middleware('auth:sanctum')` protège une route API exactement comme `middleware('auth')` protège une route web.
- Un jeton peut être limité par des "abilities", pour restreindre ce qu'il autorise.
- Pour une SPA sur le même domaine, Sanctum propose une authentification par cookie, plus proche de Breeze que des jetons.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Sanctum](https://laravel.com/docs/sanctum)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [09.2 — API Resources](../02-api-resources-transformers/README.md) · **Suite :** [09.4 — OAuth2 avec Passport](../04-authentification-api-passport-oauth2/README.md)
