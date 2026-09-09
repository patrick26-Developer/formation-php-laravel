# Exercises — 09.1 RESTful API Design

## Exercise 1 — apiResource (easy)

Create `routes/api.php` with `Route::apiResource('produits', ...)`. Compare `php artisan route:list` with an equivalent `Route::resource()` (module 06.2): list the missing routes.

## Exercise 2 — Versioning from the start (easy)

Wrap your API routes in `Route::prefix('v1')`. Verify every URL correctly starts with `/api/v1/`.

## Exercise 3 — Consistent filters (medium)

Reuse `index()` from the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md) and adapt it for an API: same filters (search, category, max price), but returning JSON rather than a view.

## Exercise 4 — Correct status codes (medium)

Implement `store()`, `destroy()` with the right codes (201, 204). Test with `curl -i` and check the returned codes.

## Exercise 5 — Auditing a poorly designed API (hard)

This API violates several of the module's best practices. Identify them all and propose a corrected version:
```
GET  /api/getAnnonce?id=5
POST /api/annonce/delete/5
GET  /api/annonces/liste/actives
POST /api/annonces/5/setStatutPublie
```

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
