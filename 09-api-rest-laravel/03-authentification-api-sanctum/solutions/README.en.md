# Solutions — 09.3 API Authentication with Sanctum

## Exercise 1

```bash
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
php artisan migrate
```
```bash
curl -X POST http://localhost:8000/api/login -d "email=alice@example.com&password=password"
# {"token":"1|aBcDeFgH..."}
```

## Exercise 2

```php
Route::middleware('auth:sanctum')->get('/api/annonces', [AnnonceController::class, 'index']);
```
```bash
curl -i http://localhost:8000/api/annonces                     # 401 Unauthorized
curl -i http://localhost:8000/api/annonces -H "Authorization: Bearer 1|aBcDeFgH..."  # 200 OK
```

## Exercise 3

```php
Route::middleware('auth:sanctum')->post('/api/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out.']);
});
```
After logging out, reusing the same token returns 401: the matching row
was deleted from `personal_access_tokens`.

## Exercise 4

```php
$jetonLecture = $user->createToken('lecture', ['annonces:lire'])->plainTextToken;
$jetonEcriture = $user->createToken('ecriture', ['annonces:lire', 'annonces:ecrire'])->plainTextToken;
```
```php
Route::middleware(['auth:sanctum', 'ability:annonces:ecrire'])->post('/api/annonces', [AnnonceController::class, 'store']);
```
Tested: `$jetonLecture` gets 403 on `POST /api/annonces`, `$jetonEcriture` succeeds.

## Exercise 5

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
        // ->tokens() is ALREADY filtered to the logged-in user: it's
        // impossible to revoke another user's token via this endpoint.
        $supprime = $request->user()->tokens()->where('id', $id)->delete();

        if (!$supprime) {
            return response()->json(['message' => 'Token not found.'], 404);
        }

        return response()->noContent();
    });
});
```
