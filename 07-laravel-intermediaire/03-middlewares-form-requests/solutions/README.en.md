# Solutions — 07.3 Middlewares and Form Requests

## Exercise 1

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

## Exercise 2

```php
class EstEnHeuresOuvrables
{
    public function handle(Request $request, Closure $next): Response
    {
        $heure = now()->hour;
        if ($heure < 8 || $heure >= 20) {
            abort(403, 'Access only allowed between 8am and 8pm.');
        }
        return $next($request);
    }
}
```

## Exercise 3

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

## Exercise 4

```php
class PremierMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        logger('First: before');
        $response = $next($request);
        logger('First: after');
        return $response;
    }
}
// SecondMiddleware: identical with "Second"
```
With `->middleware(['premier', 'second'])`, the logs show:
```
First: before
Second: before
Second: after
First: after
```
Explanation: each middleware calls `$next()`, which runs the next one
BEFORE continuing its own code after that call — like a stack (last in,
first out), exactly the same mechanism as a nested `try { ... } finally
{ ... }` (module 02.4) or stacked recursive function calls.

## Exercise 5

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
Tested with a user other than the author: the `PUT /articles/{article}`
request automatically returns a 403 page, with no verification code
written inside `ArticleController::update()` itself.
