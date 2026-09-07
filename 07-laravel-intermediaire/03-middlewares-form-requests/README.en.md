# 07.3 — Middlewares and Form Requests

> **Status:** ✅ Available

## 🎯 Objectives

- Understand a middleware's role in a request's lifecycle.
- Create and register a custom middleware.
- Go deeper into Form Requests with built-in authorization.

## 📋 Prerequisites

[06.6 — Form Validation](../../06-laravel-fondamentaux/06-validation-formulaires/README.en.md), [03.2 — MVC Architecture from Scratch](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### What is a middleware?

A **middleware** intercepts an HTTP request **before** it reaches the controller (and can also act on the response, afterward). This is exactly the mechanism you built by hand: `Auth::exigerConnexion()` in the [level 02 mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md), or the `Routeur`'s middlewares in [module 03.2's exercise 5](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md).

```php
php artisan make:middleware EstAdmin
```

```php
// app/Http/Middleware/EstAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->est_admin) {
            abort(403, 'Access restricted to administrators.');
        }

        return $next($request); // lets the request continue toward the controller
    }
}
```

> 💡 `return $next($request);` is the exact equivalent of your homemade `Routeur.php`'s `($route['gestionnaire'])();`, called **only if** the middleware hasn't already interrupted the request (via `abort()` or a redirect).

### Registering and using a middleware

Since Laravel 11, middlewares are registered in `bootstrap/app.php` (recall [module 06.1](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.en.md)):

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\EstAdmin::class,
    ]);
})
```

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/tableau-de-bord', [AdminController::class, 'dashboard']);
});
```

> 📌 Middlewares run **in the order declared**: here, `auth` (the user must be logged in) runs before `admin` (the user must be an admin) — logical, since you need to be identified before checking a role.

### Middleware with parameters

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if ($request->user()?->role !== $role) {
        abort(403);
    }

    return $next($request);
}
```

```php
Route::middleware('role:editeur')->group(function () { /* ... */ });
```

### Form Requests: built-in authorization

Building on [module 06.6](../../06-laravel-fondamentaux/06-validation-formulaires/README.en.md), a Form Request's `authorize()` method combines validation **and** authorization in a single place:

```php
// app/Http/Requests/UpdateArticleRequest.php
public function authorize(): bool
{
    $article = $this->route('article'); // retrieves the model injected by the route

    return $this->user()->id === $article->user_id; // only the author can edit
}

public function rules(): array
{
    return [
        'titre' => 'required|max:150',
    ];
}
```

If `authorize()` returns `false`, Laravel automatically returns a **403** error, before `rules()` even runs — no extra code needed in the controller.

> ⚠️ For richer authorization rules (several actions, reused across several controllers), prefer **Policies** (module 07.5) over `authorize()` logic duplicated in every Form Request.

## ✅ Key takeaways

- A middleware intercepts a request before (and potentially after) the controller — the same principle as your homemade middlewares from module 03.2.
- Since Laravel 11, middlewares are registered in `bootstrap/app.php`, no longer in `Kernel.php`.
- A group's middlewares run in the order they're declared.
- `authorize()` in a Form Request combines validation and authorization; for richer logic, prefer a Policy (module 07.5).

## ➡️ Going further

- [laravel.com/docs — Middleware](https://laravel.com/docs/middleware)
- [Module 07.5 — Authorization: Policies and Gates](../05-autorisations-policies-gates/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [07.2 — Scopes, Accessors, Mutators](../02-eloquent-scopes-accessors-mutators/README.en.md) · **Next:** [07.4 — Authentication with Breeze/Fortify](../04-authentification-breeze-fortify/README.en.md)
