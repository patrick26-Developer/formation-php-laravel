# Solutions — 07.3 Middlewares et Form Requests

## Exercice 1

```php
class LogRequete
{
    public function handle(Request $request, Closure $next): Response
    {
        logger($request->method() . ' ' . $request->fullUrl());
        return $next($request);
    }
}
```
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\LogRequete::class);
})
```

## Exercice 2

```php
class EstEnHeuresOuvrables
{
    public function handle(Request $request, Closure $next): Response
    {
        $heure = now()->hour;
        if ($heure < 8 || $heure >= 20) {
            abort(403, 'Accès autorisé uniquement entre 8h et 20h.');
        }
        return $next($request);
    }
}
```

## Exercice 3

```php
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()?->role !== $role) {
            abort(403);
        }
        return $next($request);
    }
}
```
```php
// bootstrap/app.php
$middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
```
```php
Route::middleware('role:admin')->get('/admin', ...);
Route::middleware('role:editeur')->get('/editeur', ...);
```

## Exercice 4

```php
class PremierMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        logger('Premier : avant');
        $response = $next($request);
        logger('Premier : après');
        return $response;
    }
}
// SecondMiddleware : identique avec "Second"
```
Avec `->middleware(['premier', 'second'])`, les logs affichent :
```
Premier : avant
Second : avant
Second : après
Premier : après
```
Explication : chaque middleware appelle `$next()` qui exécute le suivant
AVANT de continuer son propre code après cet appel — comme une pile
(dernier entré, premier sorti), exactement le même mécanisme qu'un
`try { ... } finally { ... }` imbriqué (module 02.4) ou l'empilement
d'appels de fonctions récursives.

## Exercice 5

```php
class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $article = $this->route('article');
        return $this->user() && $this->user()->id === $article->user_id;
    }

    public function rules(): array
    {
        return ['titre' => 'required|max:150', /* ... */];
    }
}
```
Testé avec un utilisateur différent de l'auteur : la requête `PUT /articles/{article}`
retourne automatiquement une page 403, sans qu'aucun code de vérification
n'ait été écrit dans `ArticleController::update()` lui-même.
