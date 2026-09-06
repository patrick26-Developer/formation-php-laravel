# Solutions — 09.2 API Resources et transformation des données

## Exercice 1

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
Contrairement à `return $produit;` (qui exposerait `created_at`,
`updated_at`, et tout autre champ existant), la Resource ne retourne
QUE les trois champs explicitement listés.

## Exercice 2

```php
// $produit->cout_achat existe en base, mais n'est jamais mentionné
// dans ProduitResource::toArray() : il n'apparaît donc jamais dans le JSON,
// quelle que soit sa valeur.
```

## Exercice 3

```php
'categorie' => $this->whenLoaded('categorie', fn () => [
    'id' => $this->categorie->id,
    'nom' => $this->categorie->nom,
]),
```
```php
// Sans eager loading
new ProduitResource(Produit::find(1)); // "categorie" absent du JSON

// Avec eager loading
new ProduitResource(Produit::with('categorie')->find(1)); // "categorie" présent
```

## Exercice 4

```php
public function index()
{
    return ProduitResource::collection(Produit::paginate(10));
}
```
Réponse JSON :
```json
{
    "data": [...],
    "links": {"first": "...", "last": "...", "prev": null, "next": "..."},
    "meta": {"current_page": 1, "total": 42, "per_page": 10, ...}
}
```

## Exercice 5

```php
// Version fautive
'categorie_nom' => $this->categorie->nom, // DÉCLENCHE une requête PAR produit

// Contrôleur SANS eager loading
Produit::paginate(20); // 1 requête pour les produits + 20 requêtes de catégorie = 21 requêtes

// Version corrigée
Produit::with('categorie')->paginate(20); // 2 requêtes au total
'categorie_nom' => $this->whenLoaded('categorie', fn () => $this->categorie->nom),
```
`DB::listen()` confirme : 21 requêtes avant correction, 2 après — la même
discipline que pour une vue Blade (module 07.1), mais ici le piège est
moins visible car caché dans une classe de transformation plutôt que dans
une boucle explicite.
