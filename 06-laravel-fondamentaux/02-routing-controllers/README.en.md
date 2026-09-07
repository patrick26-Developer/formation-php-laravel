# 06.2 — Routing and Controllers

> **Status:** ✅ Available

## 🎯 Objectives

- Define GET/POST/PUT/DELETE routes.
- Use route parameters and model binding.
- Create and use controllers, including Resource Controllers.
- Name routes and generate URLs.

## 📋 Prerequisites

[06.1 — Installing Laravel and Artisan](../01-installation-configuration-artisan/README.en.md), [03.2 — MVC Architecture from Scratch](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Defining routes

```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TacheController;

Route::get('/taches', [TacheController::class, 'index']);
Route::get('/taches/creer', [TacheController::class, 'create']);
Route::post('/taches', [TacheController::class, 'store']);
Route::get('/taches/{tache}', [TacheController::class, 'show']);
Route::get('/taches/{tache}/modifier', [TacheController::class, 'edit']);
Route::put('/taches/{tache}', [TacheController::class, 'update']);
Route::delete('/taches/{tache}', [TacheController::class, 'destroy']);
```

> 📌 Immediately recognize the `Routeur.php` from [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md): `Route::get()`/`post()` are exactly your `get()`/`post()` methods, just more complete.

### Model Binding: Laravel resolves your parameters automatically

```php
Route::get('/taches/{tache}', [TacheController::class, 'show']);
```

```php
// app/Http/Controllers/TacheController.php
public function show(Tache $tache)
{
    return view('taches.show', ['tache' => $tache]);
}
```

> 💡 Laravel **automatically resolves** `{tache}` by querying the database (`Tache::findOrFail($id)`) and injects the Eloquent object directly into your method — equivalent to what you did manually with `$this->taches->trouver((int) $id)` in the [level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md). If no task matches the ID, Laravel automatically returns a 404 error — you **never** have to write this check yourself.

### Creating a controller

```bash
php artisan make:controller TacheController
```

```php
// app/Http/Controllers/TacheController.php
namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::all();
        return view('taches.index', ['taches' => $taches]);
    }

    public function store(Request $request)
    {
        Tache::create($request->only(['titre', 'description']));
        return redirect()->route('taches.index');
    }
}
```

### Resource Controllers: one line for 7 CRUD routes

```bash
php artisan make:controller TacheController --resource
```

```php
// routes/web.php
Route::resource('taches', TacheController::class);
```

This single line automatically generates the 7 standard CRUD routes:

| HTTP Method | URI | Controller Action | Route Name |
|---|---|---|---|
| GET | `/taches` | `index` | `taches.index` |
| GET | `/taches/creer` | `create` | `taches.create` |
| POST | `/taches` | `store` | `taches.store` |
| GET | `/taches/{tache}` | `show` | `taches.show` |
| GET | `/taches/{tache}/edit` | `edit` | `taches.edit` |
| PUT/PATCH | `/taches/{tache}` | `update` | `taches.update` |
| DELETE | `/taches/{tache}` | `destroy` | `taches.destroy` |

> 📌 This is **exactly** the HTTP method/action table from [module 03.4](../../03-php-avance/04-construction-api-rest-php-natif/README.en.md) on REST APIs, applied to web pages. A `Route::resource()` replaces the 7 lines you would have hand-written in `Routeur.php`.

### Named routes and URL generation

```php
Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');
```

```php
// In a Blade view or a controller:
redirect()->route('taches.index');
route('taches.show', ['tache' => $tache->id]); // generates "/taches/5"
```

> ⚠️ **Professional best practice**: always use `route('route.name')` rather than hardcoding the URL (`/taches`). If the URL ever changes (`/taches` becomes `/mes-taches`), there's only one place to update (the route declaration) instead of hunting down every hardcoded occurrence in the views.

### Route groups

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('taches', TacheController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
    // Final URL: /admin/utilisateurs, route name: admin.utilisateurs
});
```

## ✅ Key takeaways

- `Route::resource()` generates the 7 standard CRUD routes in one line.
- Model Binding directly injects the Eloquent object matching a route parameter, with automatic 404 if not found.
- Always name your routes and use `route()`/`redirect()->route()` rather than hardcoded URLs.
- Route groups factor out common middleware, prefix, and naming.

## ➡️ Going further

- [laravel.com/docs — Routing](https://laravel.com/docs/routing)
- [laravel.com/docs — Controllers](https://laravel.com/docs/controllers)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [06.1 — Installing Laravel and Artisan](../01-installation-configuration-artisan/README.en.md) · **Next:** [06.3 — The Blade Templating Engine](../03-blade-templates/README.en.md)
