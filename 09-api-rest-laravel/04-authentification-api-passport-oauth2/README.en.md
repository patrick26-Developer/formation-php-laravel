# 09.4 — OAuth2 Authentication with Passport

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the OAuth2 protocol and its use cases.
- Distinguish the different "grant types" and when to use them.
- Install and configure Passport for a third-party client application.
- Know when to prefer Passport over Sanctum.

## 📋 Prerequisites

[09.3 — API Authentication with Sanctum](../03-authentification-api-sanctum/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### OAuth2: authorizing a third party without sharing a password

**OAuth2** is a standard protocol that lets a third-party application access resources **on behalf of a user**, without ever knowing their password. Classic example: "Sign in with Google" on a third-party site — the site never gets your Google password, only a token limited to certain permissions (your email, your name).

### Sanctum vs Passport: when to choose which?

| | Sanctum (module 09.3) | Passport |
|---|---|---|
| Complexity | Simple, personal access tokens or SPA cookies | Full OAuth2 protocol |
| Typical use case | **Your own** mobile app/SPA consuming **your own** API | Authorizing **third-party** applications (built by others) to access your API on behalf of a user |
| Concrete example | Your classifieds platform's official mobile app | A partner building their own tool that integrates with your platform, with your users' authorization |

> ⚠️ **A rule widely shared across the Laravel ecosystem**: if you're **only** building your own client (an official mobile app, an SPA for the same product), Sanctum is **almost always** enough and much simpler to operate. Passport is justified only when **third-party applications, built by other teams**, need to authenticate on behalf of your users — a real but minority need.

### Installing Passport

```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
```

```php
// app/Models/User.php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
}
```

### The main "grant types" (ways to obtain a token)

| Grant type | Use case |
|---|---|
| **Authorization Code** | A third-party application with a web/mobile interface, redirecting the user to a login/consent page |
| **Client Credentials** | Machine-to-machine communication, with no user involved (a backend service querying your API) |
| **Password Grant** | *(Discouraged)* the third-party application asks directly for email/password — should only be used for your **own** absolutely trusted clients |

```php
// Example: Client Credentials (machine-to-machine)
Route::middleware('client')->get('/api/statistiques-globales', function () {
    return response()->json(['total_annonces' => Annonce::count()]);
});
```

### The Authorization Code flow, simplified

1. The third-party application redirects the user to `/oauth/authorize?client_id=...&scope=annonces:lire`.
2. The user logs in (on **your** platform) and **explicitly consents** to authorize this application for the requested permissions.
3. Your server redirects to the third-party application with a temporary code.
4. The third-party application exchanges this code for an access token, on the backend (never exposed to the browser).

> 📌 This flow is deliberately more complex than Sanctum: it exists precisely to let a user **explicitly consent** to, and **revoke**, a third-party application's access without ever having shared their password with it.

## ✅ Key takeaways

- OAuth2 lets a third party access resources on behalf of a user, with no password sharing.
- Sanctum suits your own clients (official mobile app, SPA); Passport is justified for genuine third-party applications.
- The "Authorization Code" grant involves explicit user consent; "Client Credentials" suits machine-to-machine.
- Don't over-equip an API with Passport if Sanctum is enough for the real need — complexity must be justified.

## ➡️ Going further

- [laravel.com/docs — Passport](https://laravel.com/docs/passport)
- [oauth.net/2/](https://oauth.net/2/) — OAuth2 specification

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [09.3 — Sanctum](../03-authentification-api-sanctum/README.en.md) · **Next:** [09.5 — Versioning and OpenAPI Documentation](../05-versioning-documentation-openapi/README.en.md)
