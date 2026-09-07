# 06.7 — Full Laravel CRUD (Sort, Filter, Search, Pagination)

> **Status:** ✅ Available

## 🎯 Objectives

- Combine routing, Eloquent, Blade, and validation into a complete CRUD.
- Implement dynamic sorting, filtering, and search with the Query Builder.
- Use Laravel's native pagination.
- Structure a complete, clean Resource controller.

## 📋 Prerequisites

Every previous module of Level 06, and [02.9 — Full CRUD with PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md)

## ⏱️ Estimated duration

3h.

## 📖 Theory

This module brings everything above together to reproduce — in a fraction of the code — the full CRUD hand-built in module 02.9 and the level 02 mini-project.

### The complete Resource controller

```php
// app/Http/Controllers/TacheController.php
namespace App\Http\Controllers;

use App\Models\Tache;
use App\Http\Requests\StoreTacheRequest;
use App\Http\Requests\UpdateTacheRequest;

class TacheController extends Controller
{
    public function index(Request $request)
    {
        $taches = Tache::query()
            ->where('user_id', $request->user()->id)
            ->when($request->filled('recherche'), function ($query) use ($request) {
                $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
            })
            ->when($request->filled('statut'), function ($query) use ($request) {
                $query->where('terminee', $request->input('statut') === 'terminees');
            })
            ->orderBy(
                $request->input('tri', 'created_at'),
                $request->input('ordre', 'desc')
            )
            ->paginate(10)
            ->withQueryString(); // preserves sort/search/status when changing pages

        return view('taches.index', ['taches' => $taches]);
    }

    public function create()
    {
        return view('taches.create');
    }

    public function store(StoreTacheRequest $request)
    {
        $request->user()->taches()->create($request->validated());

        return redirect()->route('taches.index')->with('succes', 'Task created.');
    }

    public function edit(Tache $tache)
    {
        $this->authorize('update', $tache); // module 07.5
        return view('taches.edit', ['tache' => $tache]);
    }

    public function update(UpdateTacheRequest $request, Tache $tache)
    {
        $this->authorize('update', $tache);
        $tache->update($request->validated());

        return redirect()->route('taches.index')->with('succes', 'Task updated.');
    }

    public function destroy(Tache $tache)
    {
        $this->authorize('delete', $tache);
        $tache->delete();

        return redirect()->route('taches.index')->with('succes', 'Task deleted.');
    }
}
```

> 💡 Compare this controller to the `TacheRepository` **and** the 5 PHP files from the [level 02 mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md) (`index.php`, `creer.php`, `modifier.php`, `supprimer.php`, `Auth.php`): the same functionality (CRUD + sort + filter + search + pagination + per-user isolation) fits into a single file, roughly 5 times shorter.

### `when()`: cleanly conditioning a clause

```php
->when($request->filled('recherche'), function ($query) use ($request) {
    $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
})
```

> 📌 `when()` elegantly replaces the `if ($search !== null && $search !== '') { $conditions[] = ...; }` pattern from module 02.9: the clause is only added to the query if the condition is true, with no unsightly nested `if` in a method chain.

### Native pagination

```php
$taches = Tache::paginate(10);
```

```blade
{{-- resources/views/taches/index.blade.php --}}
@foreach ($taches as $tache)
    <p>{{ $tache->titre }}</p>
@endforeach

{{ $taches->links() }}
```

`$taches->links()` **automatically** generates pagination links (previous/next/page numbers), with the default Tailwind styling — replacing the manual `for ($p = 1; $p <= $totalPages; $p++)` loop from module 02.9.

> ⚠️ `withQueryString()` is **essential** as soon as you combine pagination and filters: without it, clicking "page 2" would lose the `?recherche=...&tri=...` parameters from the current URL.

### Clickable sorting in the view

```blade
<a href="{{ request()->fullUrlWithQuery(['tri' => 'titre', 'ordre' => request('ordre') === 'asc' ? 'desc' : 'asc']) }}">
    Title
</a>
```

> 📌 Unlike module 02.9, where the sort column had to be manually validated against a **whitelist** before being inserted into the SQL (`in_array($tri, $colonnesAutorisees, true)`), Eloquent exposes `orderBy()` as a **method**, not a SQL string concatenation — but vigilance is still required: **never** pass `$request->input('tri')` directly without checking that it matches a column that actually exists and is allowed, or you risk a SQL error if a malicious user sends an arbitrary value. Whitelisting remains a good practice:

```php
$allowedColumns = ['titre', 'created_at', 'terminee'];
$sort = in_array($request->input('tri'), $allowedColumns, true) ? $request->input('tri') : 'created_at';
```

## ✅ Key takeaways

- A complete Resource controller with sort/filter/search/pagination via Eloquent fits in a fraction of the equivalent native PHP code.
- `when()` elegantly conditions a query clause without nested `if`s.
- `paginate()` + `$taches->links()` + `withQueryString()` handle all of pagination, including preserving active filters.
- Vigilance about the sort column name (whitelist) is still required even with Eloquent.

## ➡️ Going further

- [laravel.com/docs — Query Builder: Ordering, Grouping, Limit and Offset](https://laravel.com/docs/queries#ordering-grouping-limit-and-offset)
- [laravel.com/docs — Pagination](https://laravel.com/docs/pagination)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [06.6 — Form Validation](../06-validation-formulaires/README.en.md) · **Next:** [Mini-project: Blog with Laravel CRUD](../projet-mini-03-blog-crud-laravel/README.en.md)
