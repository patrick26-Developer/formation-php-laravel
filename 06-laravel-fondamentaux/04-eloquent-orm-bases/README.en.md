# 06.4 — Eloquent ORM: The Basics

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the role of an Eloquent model.
- Perform basic CRUD operations without writing SQL.
- Use the Query Builder for richer queries.
- Understand Eloquent conventions (naming, primary key, timestamps).

## 📋 Prerequisites

[06.3 — The Blade Templating Engine](../03-blade-templates/README.en.md), [02.9 — Full CRUD with PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### What is Eloquent?

**Eloquent** is Laravel's **ORM** (Object-Relational Mapping): every database table is represented by a class (a **model**), and every row by an instance of that class. Eloquent is your `TacheRepository` (module 02.9) **generalized and automated** — you no longer write SQL for common operations.

```php
// app/Models/Tache.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = ['titre', 'description', 'terminee'];
}
```

> ⚠️ `$fillable` lists the columns **allowed** to be mass-assigned (via `create()`/`update()` with an array). It's a protection against **unwanted mass assignment**: without it, an attacker could inject unintended fields (for example `est_admin => true`) through a form, if the controller passes `$request->all()` without filtering.

### Eloquent conventions (know them so you don't fight them)

| Convention | Example |
|---|---|
| Table name = plural snake_case of the model | Model `Tache` → table `taches`; `LigneCommande` → `ligne_commandes` |
| Primary key = `id` (auto-incrementing) | Customizable via `protected $primaryKey` |
| Automatic timestamps | `created_at`/`updated_at` managed automatically (disable via `public $timestamps = false`) |

### CRUD with Eloquent

```php
// CREATE
$tache = Tache::create(['titre' => 'Buy groceries', 'description' => '']);

// READ
$allTasks = Tache::all();
$tache = Tache::find(1);           // returns null if not found
$tache = Tache::findOrFail(1);      // throws a ModelNotFoundException (automatic 404 over HTTP)
$first = Tache::first();

// UPDATE
$tache = Tache::find(1);
$tache->titre = 'New title';
$tache->save();
// or in one line:
Tache::find(1)->update(['titre' => 'New title']);

// DELETE
Tache::find(1)->delete();
Tache::destroy(1); // or: Tache::destroy([1, 2, 3]);
```

> 💡 Compare this with `TacheRepository::creer()`/`trouver()`/`modifier()`/`supprimer()` from module 02.9: Eloquent completely eliminates hand-writing prepared SQL statements, **while keeping the same protection against SQL injection** (Eloquent uses prepared statements internally).

### The Query Builder: for richer queries

```php
$taches = Tache::where('terminee', false)
    ->where('titre', 'like', '%groceries%')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

$count = Tache::where('terminee', true)->count();

$exists = Tache::where('titre', 'Buy groceries')->exists();
```

> 📌 This Query Builder generates the same SQL you hand-wrote in [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) (`WHERE`, `ORDER BY`, `LIMIT`), but with a fluent object-oriented syntax (chained methods), never handling a raw SQL string.

### Casted attributes

```php
class Tache extends Model
{
    protected $casts = [
        'terminee' => 'boolean',
        'creee_le' => 'datetime',
    ];
}
```

`$casts` automatically converts types stored in the database (often `0`/`1` or strings) into real PHP types (`bool`, `DateTime`) on read, and back on write.

## ✅ Key takeaways

- An Eloquent model represents a table; `$fillable` protects against unwanted mass assignment.
- `find()`/`findOrFail()`/`all()`/`create()`/`update()`/`delete()` cover basic CRUD without manual SQL.
- The Query Builder (`where`, `orderBy`, `limit`...) remains available for richer queries, always protected against SQL injection.
- Follow Eloquent conventions (plural naming, `id`, timestamps): fighting them unnecessarily complicates every step that follows.

## ➡️ Going further

- [laravel.com/docs — Eloquent: Getting Started](https://laravel.com/docs/eloquent)
- [Module 06.5 — Migrations, Seeders, Factories](../05-migrations-seeders-factories/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [06.3 — Blade](../03-blade-templates/README.en.md) · **Next:** [06.5 — Migrations, Seeders, Factories](../05-migrations-seeders-factories/README.en.md)
