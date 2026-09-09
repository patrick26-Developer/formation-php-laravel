# Solutions — 09.2 API Resources and Data Transformation

## Exercise 1

```php
class ProduitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prix' => (float) $this->prix,
        ];
    }
}
```
```php
public function show(Produit $produit)
{
    return new ProduitResource($produit);
}
```
Unlike `return $produit;` (which would expose `created_at`,
`updated_at`, and any other existing field), the Resource returns ONLY
the three explicitly listed fields.

## Exercise 2

```php
// $produit->cout_achat exists in the database, but is never mentioned
// in ProduitResource::toArray(): it therefore never appears in the JSON,
// no matter its value.
```

## Exercise 3

```php
'categorie' => $this->whenLoaded('categorie', fn () => [
    'id' => $this->categorie->id,
    'nom' => $this->categorie->nom,
]),
```
```php
// Without eager loading
new ProduitResource(Produit::find(1)); // "categorie" absent from the JSON

// With eager loading
new ProduitResource(Produit::with('categorie')->find(1)); // "categorie" present
```

## Exercise 4

```php
public function index()
{
    return ProduitResource::collection(Produit::paginate(10));
}
```
JSON response:
```json
{
    "data": [...],
    "links": {"first": "...", "last": "...", "prev": null, "next": "..."},
    "meta": {"current_page": 1, "total": 42, "per_page": 10, ...}
}
```

## Exercise 5

```php
// Faulty version
'categorie_nom' => $this->categorie->nom, // TRIGGERS a query PER product

// Controller WITHOUT eager loading
Produit::paginate(20); // 1 query for products + 20 category queries = 21 queries

// Fixed version
Produit::with('categorie')->paginate(20); // 2 queries total
'categorie_nom' => $this->whenLoaded('categorie', fn () => $this->categorie->nom),
```
`DB::listen()` confirms: 21 queries before the fix, 2 after — the same
discipline as for a Blade view (module 07.1), but here the trap is less
visible since it's hidden inside a transformation class rather than an
explicit loop.
