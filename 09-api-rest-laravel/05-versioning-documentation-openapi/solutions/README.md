# Solutions — 09.5 Versioning et documentation OpenAPI

## Exercice 1

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
```
Visitez `http://localhost:8000/api/documentation`.

## Exercice 2

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces/{id}",
 *     summary="Afficher une annonce",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Annonce trouvée")
 * )
 */
public function show(Annonce $annonce) { /* ... */ }
```

## Exercice 3

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces/{id}",
 *     ...
 *     @OA\Response(response=200, description="Annonce trouvée"),
 *     @OA\Response(response=404, description="Annonce non trouvée"),
 *     @OA\Response(response=401, description="Authentification requise")
 * )
 */
```

## Exercice 4

```php
/**
 * @OA\Post(
 *     path="/api/v1/annonces",
 *     summary="Créer une annonce",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"titre", "prix", "categorie_id"},
 *             @OA\Property(property="titre", type="string", maxLength=150),
 *             @OA\Property(property="prix", type="number", format="float", minimum=0),
 *             @OA\Property(property="categorie_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Annonce créée"),
 *     @OA\Response(response=422, description="Erreur de validation")
 * )
 */
```

## Exercice 5

```php
// app/Http/Resources/V1/AnnonceResource.php
class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'titre' => $this->titre, 'prix' => (float) $this->prix];
    }
}

// app/Http/Resources/V2/AnnonceResource.php
class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'prix_ht' => round($this->prix / 1.2, 2),
            'prix_ttc' => (float) $this->prix,
        ];
    }
}
```
```php
// routes/api.php
Route::prefix('v1')->group(fn () => Route::get('/annonces/{annonce}', fn (Annonce $a) => new \App\Http\Resources\V1\AnnonceResource($a)));
Route::prefix('v2')->group(fn () => Route::get('/annonces/{annonce}', fn (Annonce $a) => new \App\Http\Resources\V2\AnnonceResource($a)));
```
Un client déjà intégré sur `/api/v1/annonces` continue de recevoir `prix`
sans jamais être affecté par l'introduction de `/api/v2/annonces` — les deux
coexistent, consommant le même modèle `Annonce` sous-jacent.
