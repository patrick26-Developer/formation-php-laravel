# 09.2 — API Resources and Data Transformation

> **Status:** ✅ Available

## 🎯 Objectives

- Structure JSON responses with API Resources.
- Transform and selectively hide fields.
- Handle relationships in a Resource without causing an N+1 problem.
- Structure automatic validation responses.

## 📋 Prerequisites

[09.1 — RESTful API Design](../01-conception-api-restful-bonnes-pratiques/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### The problem: exposing an Eloquent model directly as JSON

```php
public function show(Annonce $annonce)
{
    return $annonce; // every column exposed as-is, with no control
}
```

> ⚠️ Returning an Eloquent model directly exposes **all** of its columns (including, potentially, internal information not meant for the client), and ties the JSON response structure to the database table's structure — renaming a column would then break the API for every client.

### Creating an API Resource

```bash
php artisan make:resource AnnonceResource
```

```php
// app/Http/Resources/AnnonceResource.php
class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'prix' => (float) $this->prix,
            'image_url' => $this->image_url, // uses the accessor from module 07.2
            'categorie' => $this->whenLoaded('categorie', fn () => [
                'id' => $this->categorie->id,
                'nom' => $this->categorie->nom,
            ]),
            'cree_le' => $this->created_at->toIso8601String(),
        ];
    }
}
```

```php
public function show(Annonce $annonce)
{
    return new AnnonceResource($annonce->load('categorie'));
}

public function index()
{
    return AnnonceResource::collection(Annonce::with('categorie')->paginate(15));
}
```

> 💡 A Resource **completely** decouples the JSON response's structure from the SQL table's structure: renaming a database column breaks nothing on the client side as long as the Resource keeps exposing the same JSON field name — the same abstraction principle as Storage (module 07.6) or PDO (module 02.8).

### `whenLoaded()`: avoiding the N+1 problem in a Resource

```php
'categorie' => $this->whenLoaded('categorie', fn () => new CategoryResource($this->categorie)),
```

> ⚠️ `whenLoaded()` only includes the relationship in the response **if it has already been loaded** (via `with()`, module 07.1) on the original query. Without this precaution, accessing `$this->categorie` inside a Resource would trigger a SQL query **per listing** displayed — the N+1 problem, this time hidden inside the transformation layer rather than a controller or a view.

### Resource Collections and metadata

```php
class AnnonceCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
            ],
        ];
    }
}
```

With `paginate()` (module 06.7), Laravel **automatically** enriches a Resource collection's response with pagination metadata (`links`, `meta.current_page`, `meta.total`...) — no extra code needed.

### Validation errors in an API: automatically JSON-formatted

```php
class StoreAnnonceRequest extends FormRequest
{
    // ... rules() ...
}
```

For a request sent with the `Accept: application/json` header, a validation failure (module 06.6) **automatically** returns:

```json
{
    "message": "The titre field is required.",
    "errors": {
        "titre": ["The titre field is required."]
    }
}
```

> 📌 This is the same Form Request as for a web route (`routes/web.php`) — Laravel **automatically** adapts the error response format (HTML redirect vs. structured JSON) based on the incoming request's `Accept` header. No duplicating validation rules between web and API.

## ✅ Key takeaways

- An API Resource decouples the exposed JSON structure from the SQL table's structure.
- `whenLoaded()` avoids introducing a hidden N+1 problem in a relationship's transformation.
- Eloquent pagination automatically enriches a Resource Collection with metadata.
- A Form Request's validation errors are automatically formatted as structured JSON for an API request.

## ➡️ Going further

- [laravel.com/docs — Eloquent: API Resources](https://laravel.com/docs/eloquent-resources)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [09.1 — RESTful API Design](../01-conception-api-restful-bonnes-pratiques/README.en.md) · **Next:** [09.3 — API Authentication with Sanctum](../03-authentification-api-sanctum/README.en.md)
