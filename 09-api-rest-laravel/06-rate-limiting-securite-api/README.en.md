# 09.6 — Rate Limiting and API Security

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the value of rate limiting.
- Configure limits differentiated by route and by user.
- Configure CORS for an API consumed by a separate frontend.
- Know security best practices specific to APIs.

## 📋 Prerequisites

[09.3 — API Authentication with Sanctum](../03-authentification-api-sanctum/README.en.md), [02.6 — Web Security Fundamentals](../../02-php-intermediaire/06-securite-web-fondamentaux/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Rate limiting: protecting against abuse

Without a limit, a client (deliberately malicious, or simply a bug in a third-party application) could send thousands of requests per second to your API, slowing it down for everyone or causing an excessive infrastructure bill. **Rate limiting** caps the number of requests a client is allowed to make over a given period.

```php
// bootstrap/app.php or a Service Provider
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

```php
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('annonces', AnnonceController::class);
});
```

> 💡 `by($request->user()?->id ?: $request->ip())` limits **per authenticated user**, or by **IP address** for an anonymous visitor — avoiding a single abusive authenticated user being lumped together with every visitor sharing the same IP (for example, behind the same corporate network).

### Limits differentiated by route sensitivity

```php
RateLimiter::for('connexion', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip()); // strict limit: protects against brute-force
});

RateLimiter::for('lecture-publique', function (Request $request) {
    return Limit::perMinute(120)->by($request->ip()); // more permissive for simple reads
});
```

```php
Route::post('/api/login', [AuthController::class, 'login'])->middleware('throttle:connexion');
Route::get('/api/annonces', [AnnonceController::class, 'index'])->middleware('throttle:lecture-publique');
```

> ⚠️ A **login** route must **always** have a strict, dedicated rate limit — without one, an attacker could try thousands of passwords per minute against an account (a brute-force attack), making `password_hash()`/`password_verify()` (module 02.5) insufficient on their own to protect it.

### The response when a limit is exceeded

When the limit is exceeded, Laravel automatically responds:
```
HTTP/1.1 429 Too Many Requests
Retry-After: 45
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 0
```

> 📌 The `X-RateLimit-*` headers let a well-designed client (a mobile app, a partner) anticipate the limit **before** exceeding it, rather than discovering it through a hard failure.

### CORS: allowing a separate frontend to consume the API

**CORS** (Cross-Origin Resource Sharing) is a browser mechanism that, by default, blocks JavaScript requests to a domain different from the page's — a security protection that must be explicitly relaxed for an API meant to be consumed by a frontend on another domain.

```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['https://mon-frontend.com'], // NEVER '*' if credentials/cookies are involved
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true, // required for Sanctum in SPA mode (module 09.3)
```

> ⚠️ `allowed_origins => ['*']` (allowing any domain) is a security hole when combined with `supports_credentials => true`: it would let **any site** make authenticated requests on behalf of your users. Always explicitly list trusted domains in production.

### Other API security best practices

- **Always HTTPS** in production: a `Bearer` token sent in plaintext over HTTP is trivially interceptable.
- **Never expose detailed error traces** (`APP_DEBUG=false` in production, a reminder from module 06.1) — an unhandled exception must never reveal the application's internal structure to an external client.
- **Systematically validate** input, even for a "trusted" client (a mobile app can be decompiled and its API calls imitated directly).
- **Log repeated authentication failures**, a potential signal of an intrusion attempt.

## ✅ Key takeaways

- Rate limiting protects against abuse; always a strict, dedicated limit on login routes.
- `X-RateLimit-*` headers let a well-designed client anticipate the limit.
- CORS must explicitly list trusted domains, never `*` combined with `supports_credentials`.
- HTTPS, hiding errors in production, and systematic validation remain non-negotiable for an API.

## ➡️ Going further

- [laravel.com/docs — Rate Limiting](https://laravel.com/docs/routing#rate-limiting)
- [laravel.com/docs — CORS](https://laravel.com/docs/routing#cors)
- [OWASP API Security Top 10](https://owasp.org/www-project-api-security/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [09.5 — Versioning and OpenAPI Documentation](../05-versioning-documentation-openapi/README.en.md) · **Next:** [Mini-project: Complete REST API](../projet-mini-06-api-rest-complete/README.en.md)
