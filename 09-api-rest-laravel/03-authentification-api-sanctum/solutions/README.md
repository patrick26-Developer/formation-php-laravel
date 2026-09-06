# Solutions — 09.3 Authentification API avec Sanctum

## Exercice 1

```bash
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
php artisan migrate
```
```bash
curl -X POST http://localhost:8000/api/login -d "email=alice@example.com&password=password"
# {"token":"1|aBcDeFgH..."}
```

## Exercice 2

```php
Route::middleware('auth:sanctum')->get('/api/annonces', [AnnonceController::class, 'index']);
```
```bash
curl -i http://localhost:8000/api/annonces                     # 401 Unauthorized
curl -i http://localhost:8000/api/annonces -H "Authorization: Bearer 1|aBcDeFgH..."  # 200 OK
```

## Exercice 3

```php
Route::middleware('auth:sanctum')->post('/api/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnecté.']);
});
```
Après déconnexion, réutiliser le même jeton retourne 401 : la ligne
correspondante a été supprimée de `personal_access_tokens`.

## Exercice 4

```php
$jetonLecture = $user->createToken('lecture', ['annonces:lire'])->plainTextToken;
$jetonEcriture = $user->createToken('ecriture', ['annonces:lire', 'annonces:ecrire'])->plainTextToken;
```
```php
Route::middleware(['auth:sanctum', 'ability:annonces:ecrire'])->post('/api/annonces', [AnnonceController::class, 'store']);
```
Testé : `$jetonLecture` reçoit 403 sur `POST /api/annonces`, `$jetonEcriture` réussit.

## Exercice 5

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/jetons', function (Request $request) {
        return $request->user()->tokens->map(fn ($t) => [
            'id' => $t->id,
            'nom' => $t->name,
            'cree_le' => $t->created_at,
        ]);
    });

    Route::delete('/api/jetons/{id}', function (Request $request, int $id) {
        // ->tokens() est DÉJÀ filtré sur l'utilisateur connecté : impossible
        // de révoquer le jeton d'un autre utilisateur via cet endpoint.
        $supprime = $request->user()->tokens()->where('id', $id)->delete();

        if (!$supprime) {
            return response()->json(['message' => 'Jeton introuvable.'], 404);
        }

        return response()->noContent();
    });
});
```
