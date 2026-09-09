# Solutions — 09.1 RESTful API Design

## Exercise 1

```php
Route::apiResource('produits', ProduitController::class);
```
`route:list` shows 5 routes (index, store, show, update, destroy)
against 7 for `Route::resource()`: `create` and `edit` are missing,
consistent with an API that never serves an HTML form.

## Exercise 2

```php
Route::prefix('v1')->group(function () {
    Route::apiResource('produits', ProduitController::class);
});
```
```bash
php artisan route:list
# GET|HEAD api/v1/produits ...
```

## Exercise 3

```php
public function index(Request $request)
{
    $annonces = Annonce::query()
        ->actives()
        ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->recherche . '%'))
        ->when($request->filled('categorie'), fn ($q) => $q->deLaCategorie((int) $request->categorie))
        ->when($request->filled('prix_max'), fn ($q) => $q->where('prix', '<=', $request->prix_max))
        ->paginate($request->integer('par_page', 15));

    return response()->json($annonces);
}
```

## Exercise 4

```php
public function store(Request $request)
{
    $annonce = Annonce::create($request->validated());
    return response()->json($annonce, 201);
}

public function destroy(Annonce $annonce)
{
    $annonce->delete();
    return response()->noContent(); // 204
}
```
```bash
curl -i -X POST http://localhost:8000/api/v1/annonces -d '...'   # HTTP/1.1 201 Created
curl -i -X DELETE http://localhost:8000/api/v1/annonces/1          # HTTP/1.1 204 No Content
```

## Exercise 5

```markdown
Identified problems:
1. `GET /api/getAnnonce?id=5`: a verb in the URL ("get") + the ID in the
   query string instead of the path. Fixed: `GET /api/annonces/5`
2. `POST /api/annonce/delete/5`: wrong HTTP method (POST instead of
   DELETE) + a verb in the URL + a singular resource.
   Fixed: `DELETE /api/annonces/5`
3. `GET /api/annonces/liste/actives`: an unnecessary "liste" segment,
   the filter should be a query parameter, not a dedicated URL segment.
   Fixed: `GET /api/annonces?statut=actives`
4. `POST /api/annonces/5/setStatutPublie`: a verb in the URL, and a
   partial update of an existing resource should use PATCH, not POST.
   Fixed: `PATCH /api/annonces/5` with `{"statut": "publie"}` in the body.

Complete corrected version:
GET    /api/annonces?statut=actives
GET    /api/annonces/5
PATCH  /api/annonces/5
DELETE /api/annonces/5
```
