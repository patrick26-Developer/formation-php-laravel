# 09.1 — RESTful API Design: Best Practices

> **Status:** ✅ Available

## 🎯 Objectives

- Name API routes consistently and predictably.
- Systematically use the right HTTP status codes.
- Structure `routes/api.php` with `Route::apiResource()`.
- Know the conventions for pagination, filtering, and sorting in an API.

## 📋 Prerequisites

[Level 08 — Advanced Laravel](../../08-laravel-avance/README.en.md), [03.4 — Building a REST API in Native PHP](../../03-php-avance/04-construction-api-rest-php-natif/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### `routes/api.php`: a dedicated file, with no session state

```php
// routes/api.php
use App\Http\Controllers\Api\AnnonceController;

Route::apiResource('annonces', AnnonceController::class);
```

> 📌 `Route::apiResource()` (rather than `Route::resource()`, module 06.2) generates the same 7 routes **without** `create` or `edit` — these two routes only serve to display **HTML forms**, a concept that makes no sense for a JSON API consumed by a mobile app or a separate frontend.

All routes in `routes/api.php` are automatically prefixed with `/api` and are **session/CSRF-free** (module 02.6): a REST API is supposed to be **stateless** — every request must be self-sufficient (generally via an authentication token, module 09.3), without relying on server-side session state between two requests.

### Resource naming convention

| Best practice | Example |
|---|---|
| Plural resource names | `/api/annonces`, not `/api/annonce` |
| Nesting limited to one level | `/api/annonces/{id}/messages`, not `/api/annonces/{id}/messages/{id}/reponses/{id}` |
| Avoid verbs in the URL (the HTTP verb is enough) | `DELETE /api/annonces/{id}`, not `/api/annonces/{id}/supprimer` |
| Filters as query string | `/api/annonces?categorie=3&prix_max=100` |

### Status codes: recap and extension of module 03.4

| Code | When to use it in Laravel |
|---|---|
| `200 OK` | Successful `GET`/`PUT` |
| `201 Created` | Successful `POST` (`response()->json($ressource, 201)`) |
| `204 No Content` | Successful `DELETE` (`response()->noContent()`) |
| `422 Unprocessable Entity` | Validation failure (Laravel does this **automatically** for an API request, module 09.2) |
| `429 Too Many Requests` | Rate limit exceeded (module 09.6) |

### Versioning the API from the start

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::apiResource('annonces', \App\Http\Controllers\Api\V1\AnnonceController::class);
});
```

> 💡 Even without an immediate need for a V2, prefixing `/api/v1/...` from day one avoids a painful migration later, once external clients (an already-published mobile app) depend on the current response structure. Covered in depth in [module 09.5](../05-versioning-documentation-openapi/README.md) *(French only)*.

### Pagination, sorting, filtering: consistency with the rest of the training

```php
// app/Http/Controllers/Api/V1/AnnonceController.php
public function index(Request $request)
{
    $annonces = Annonce::query()
        ->actives()
        ->when($request->filled('categorie'), fn ($q) => $q->deLaCategorie($request->integer('categorie')))
        ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->input('recherche') . '%'))
        ->paginate($request->integer('par_page', 15));

    return AnnonceResource::collection($annonces); // module 09.2
}
```

> 📌 **Exactly** the same Query Builder as in [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.en.md) and the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md): a Laravel REST API reuses the entire Eloquent layer you've already mastered — only the presentation layer changes (JSON via Resources, rather than Blade).

## ✅ Key takeaways

- `routes/api.php` is stateless: no session, token authentication.
- `Route::apiResource()` omits `create`/`edit`, meaningless for a JSON API.
- Plural resources, verbs expressed by the HTTP method, filters as query string.
- Version the API from the start (`/api/v1/...`) to avoid a painful future migration.

## ➡️ Going further

- [laravel.com/docs — Routing (API Resource Routes)](https://laravel.com/docs/controllers#api-resource-routes)
- [restfulapi.net](https://restfulapi.net/) (already cited in module 03.4)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 08 — Advanced Laravel](../../08-laravel-avance/README.en.md) · **Next:** [09.2 — API Resources and Data Transformation](../02-api-resources-transformers/README.en.md)
