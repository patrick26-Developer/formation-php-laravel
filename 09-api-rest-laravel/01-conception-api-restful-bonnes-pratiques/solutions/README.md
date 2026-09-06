# Solutions — 09.1 Conception d'API RESTful

## Exercice 1

```php
Route::apiResource('produits', ProduitController::class);
```
`route:list` montre 5 routes (index, store, show, update, destroy) contre
7 pour `Route::resource()` : `create` et `edit` sont absentes, cohérent
avec une API qui ne sert jamais de formulaire HTML.

## Exercice 2

```php
Route::prefix('v1')->group(function () {
    Route::apiResource('produits', ProduitController::class);
});
```
```bash
php artisan route:list
# GET|HEAD api/v1/produits ...
```

## Exercice 3

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

## Exercice 4

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

## Exercice 5

```markdown
Problèmes identifiés :
1. `GET /api/getAnnonce?id=5` : verbe dans l'URL ("get") + ID en query
   string au lieu du chemin. Corrigé : `GET /api/annonces/5`
2. `POST /api/annonce/delete/5` : mauvaise méthode HTTP (POST au lieu de
   DELETE) + verbe dans l'URL + ressource au singulier.
   Corrigé : `DELETE /api/annonces/5`
3. `GET /api/annonces/liste/actives` : segment "liste" inutile, le filtre
   devrait être un paramètre de requête, pas un segment d'URL dédié.
   Corrigé : `GET /api/annonces?statut=actives`
4. `POST /api/annonces/5/setStatutPublie` : verbe dans l'URL, et une
   modification partielle d'une ressource existante devrait utiliser
   PATCH, pas POST. Corrigé : `PATCH /api/annonces/5` avec
   `{"statut": "publie"}` dans le corps.

Version corrigée complète :
GET    /api/annonces?statut=actives
GET    /api/annonces/5
PATCH  /api/annonces/5
DELETE /api/annonces/5
```
