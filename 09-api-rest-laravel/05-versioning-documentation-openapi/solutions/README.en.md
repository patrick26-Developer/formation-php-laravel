# Solutions — 09.5 Versioning and OpenAPI Documentation

## Exercise 1

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
```
Visit `http://localhost:8000/api/documentation`.

## Exercise 2

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces/{id}",
 *     summary="Show a listing",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Listing found")
 * )
 */
public function show(Annonce $annonce) { /* ... */ }
```

## Exercise 3

```php
/**
 * @OA\Get(
 *     path="/api/v1/annonces/{id}",
 *     ...
 *     @OA\Response(response=200, description="Listing found"),
 *     @OA\Response(response=404, description="Listing not found"),
 *     @OA\Response(response=401, description="Authentication required")
 * )
 */
```

## Exercise 4

```php
/**
 * @OA\Post(
 *     path="/api/v1/annonces",
 *     summary="Create a listing",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"titre", "prix", "categorie_id"},
 *             @OA\Property(property="titre", type="string", maxLength=150),
 *             @OA\Property(property="prix", type="number", format="float", minimum=0),
 *             @OA\Property(property="categorie_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Listing created"),
 *     @OA\Response(response=422, description="Validation error")
 * )
 */
```

## Exercise 5

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
A client already integrated with `/api/v1/annonces` keeps receiving
`prix` and is never affected by the introduction of `/api/v2/annonces`
— both coexist, consuming the same underlying `Annonce` model.
