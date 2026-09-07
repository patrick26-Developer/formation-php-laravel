# 09.3 — API Authentication with Sanctum

> **Status:** ✅ Available

## 🎯 Objectives

- Understand how Sanctum API tokens work.
- Authenticate a mobile/third-party application via personal access tokens.
- Authenticate an SPA (Single Page Application) via Sanctum cookies.
- Protect API routes with the `auth:sanctum` middleware.

## 📋 Prerequisites

[09.2 — API Resources and Data Transformation](../02-api-resources-transformers/README.en.md), [07.4 — Authentication with Breeze/Fortify](../../07-laravel-intermediaire/04-authentification-breeze-fortify/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Why not sessions for an API?

Breeze (module 07.4) authenticates via **sessions** — suited to a classic web application where the browser keeps a session cookie. An API consumed by a **mobile** application (which has no "browser session") needs a different mechanism: a **token** sent with every request, proving the client's identity.

```
Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...
```

### Installing Sanctum

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

### Personal access tokens: for a mobile app or machine-to-machine

```php
// A login endpoint dedicated to the API
Route::post('/api/login', function (Request $request) {
    $request->validate(['email' => 'required|email', 'password' => 'required']);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    $jeton = $user->createToken('mobile-app')->plainTextToken;

    return response()->json(['token' => $jeton]);
});
```

```php
// The mobile client then sends this token in EVERY subsequent request:
// Authorization: Bearer <token>

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('annonces', AnnonceController::class);
});
```

> 💡 `createToken('mobile-app')->plainTextToken` generates and **stores a hash** of the token in the database (the `personal_access_tokens` table), returning the plaintext value **only once** — exactly like a password (module 02.5): impossible to retrieve afterward, only verifiable.

### Revoking a token (API logout)

```php
Route::post('/api/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out.']);
})->middleware('auth:sanctum');
```

### Restricting a token's capabilities (abilities)

```php
$jeton = $user->createToken('mobile-app', ['annonces:lire'])->plainTextToken;
```

```php
Route::get('/api/annonces', [AnnonceController::class, 'index'])
    ->middleware(['auth:sanctum', 'ability:annonces:lire']);
```

> 📌 Useful for distinguishing, for example, a "read-only" mobile token from a partner integration token that needs to write data — the same principle as OAuth2 scopes (module 09.4), only simpler.

### Sanctum for an SPA (cookie-based authentication, not token-based)

For a separate JavaScript frontend (Vue/React) on the **same domain** (or a subdomain), Sanctum offers session-cookie authentication — closer to Breeze than to personal access tokens:

```
# .env
SANCTUM_STATEFUL_DOMAINS=mon-app.test
```

The frontend calls `/sanctum/csrf-cookie` before logging in, then authenticates via a regular login route — Laravel then recognizes subsequent requests from this domain as authenticated, with no explicit token to manage on the JavaScript side.

> 📌 Remember the distinction: **personal access tokens** for mobile/machine-to-machine (stateless), **Sanctum cookies** for an SPA on the same domain (with session state, like Breeze).

## ✅ Key takeaways

- Sanctum authenticates via a `Bearer` token sent in the `Authorization` header, suited to mobile/machine-to-machine.
- `middleware('auth:sanctum')` protects an API route exactly like `middleware('auth')` protects a web route.
- A token can be restricted with "abilities", to limit what it's allowed to do.
- For an SPA on the same domain, Sanctum offers cookie-based authentication, closer to Breeze than to tokens.

## ➡️ Going further

- [laravel.com/docs — Sanctum](https://laravel.com/docs/sanctum)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [09.2 — API Resources](../02-api-resources-transformers/README.en.md) · **Next:** [09.4 — OAuth2 with Passport](../04-authentification-api-passport-oauth2/README.en.md)
