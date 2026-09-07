# 09.5 — Versioning and OpenAPI/Swagger Documentation

> **Status:** ✅ Available

## 🎯 Objectives

- Understand API versioning strategies.
- Document an API with the OpenAPI specification.
- Generate interactive documentation with Swagger UI.
- Keep documentation in sync with the code.

## 📋 Prerequisites

[09.1 — RESTful API Design](../01-conception-api-restful-bonnes-pratiques/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Why version an API?

Once a published mobile app or an external partner is consuming your API, you can **never again** change an existing response's structure without breaking their integration. Versioning lets you evolve the API by introducing a **new version** alongside the old one, without breaking it.

### Versioning strategies

```php
// 1. URL-prefix versioning (the most common, already seen in module 09.1)
Route::prefix('v1')->group(fn () => Route::apiResource('annonces', V1\AnnonceController::class));
Route::prefix('v2')->group(fn () => Route::apiResource('annonces', V2\AnnonceController::class));

// 2. HTTP header versioning (less visible in the URL, more "pure" in the REST sense)
// Accept: application/vnd.monapp.v2+json
```

> 📌 URL-prefix versioning (`/api/v1/...`) is **overwhelmingly dominant in practice**, despite theoretical debates about "REST purity" — it's simple to understand, to test with `curl`, and to document.

### Documenting with OpenAPI (Swagger)

**OpenAPI** is a standard specification (YAML/JSON format) describing an API's endpoints: routes, parameters, request/response formats, possible error codes.

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces",
 *     summary="List active listings",
 *     @OA\Parameter(name="recherche", in="query", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="Paginated list of listings",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Annonce"))
 *         )
 *     )
 * )
 */
public function index(Request $request)
{
    // ...
}
```

```bash
php artisan l5-swagger:generate
```

Generates interactive documentation accessible at `/api/documentation`, where every endpoint can be **tested directly from the browser**.

> 💡 The major benefit of documentation generated from annotations in the code (rather than a separate, hand-maintained document): it's far less likely to become **stale**, since it lives right next to the code it describes and can be regenerated on every deployment.

### Documenting possible error codes

```php
/**
 * @OA\Response(response=404, description="Listing not found"),
 * @OA\Response(response=422, description="Validation error"),
 * @OA\Response(response=429, description="Too many requests (rate limiting, module 09.6)")
 */
```

> 📌 Good API documentation systematically lists **error cases**, not just the success case — this is often the most useful information for a third-party developer integrating your API for the first time.

## ✅ Key takeaways

- Versioning an API (usually via URL prefix `/api/v1/`) protects existing clients from a breaking change.
- OpenAPI/Swagger generates directly testable interactive documentation, from annotations in the code.
- Documentation living next to the code (generated, not written separately) stays in sync more easily.
- Always document possible error codes, not just the happy path.

## ➡️ Going further

- [swagger.io/specification/](https://swagger.io/specification/)
- [github.com/DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [09.4 — OAuth2 with Passport](../04-authentification-api-passport-oauth2/README.en.md) · **Next:** [09.6 — Rate Limiting and API Security](../06-rate-limiting-securite-api/README.en.md)
