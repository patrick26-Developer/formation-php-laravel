# 07.2 — Eloquent Scopes, Accessors and Mutators

> **Status:** ✅ Available

## 🎯 Objectives

- Encapsulate reusable queries in local scopes.
- Transform an attribute's read/write with accessors and mutators.
- Use global scopes for a rule applied systematically.

## 📋 Prerequisites

[07.1 — Advanced Eloquent Relationships](../01-eloquent-relations-avancees/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Local scopes: factoring out common queries

```php
// app/Models/Article.php
public function scopePublies($query)
{
    return $query->where('publie', true);
}

public function scopeDeLaCategorie($query, int $categorieId)
{
    return $query->where('categorie_id', $categorieId);
}
```

```php
// Usage: the "scope" prefix disappears when called
Article::publies()->get();
Article::publies()->deLaCategorie(3)->latest()->get();
```

> 💡 A scope elegantly replaces a clause duplicated across several controllers. Compare it with `construireFiltres()` from [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md): same intent (factoring out a reusable condition), expressed here as a method chainable directly on the model.

### Accessors: transforming an attribute on read

```php
// app/Models/Article.php (modern syntax, Laravel 9+)
use Illuminate\Database\Eloquent\Casts\Attribute;

protected function titre(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
    );
}

protected function extrait(): Attribute
{
    return Attribute::make(
        get: fn () => Str::limit($this->contenu, 100),
    );
}
```

```php
echo $article->titre;    // always capitalized, whatever is stored in the database
echo $article->extrait;   // "extrait" doesn't exist in the database: it's a CALCULATED attribute, on the fly
```

> 📌 `extrait` is not a column on the `articles` table: it's a **virtual attribute**, computed from `contenu` on every access. It's the object-oriented equivalent of a utility function like `substr($article['contenu'], 0, 100) . '...'` that you would have called manually in native PHP.

### Mutators: transforming an attribute on write

```php
protected function titre(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
        set: fn (string $value) => strtolower(trim($value)), // normalizes BEFORE storage
    );
}
```

```php
$article->titre = "  MY TITLE IN ALL CAPS  ";
$article->save();
// Stored in the database: "my title in all caps" (the "set" mutator runs before writing)
// Then read back as: "My title in all caps" (the "get" accessor runs on read)
```

### Global scopes: a rule applied to EVERY query

```php
// app/Models/Article.php
protected static function booted(): void
{
    static::addGlobalScope('publie', function (Builder $builder) {
        $builder->where('publie', true);
    });
}
```

> ⚠️ A global scope applies **automatically to every query** on this model, including ones you don't directly control (relationships loaded from another model). This is powerful but risky: a developer who's unaware of it might be surprised that `Article::all()` doesn't return certain articles. Use it sparingly, and always document it clearly. For a one-off case, prefer a **local** scope (`Article::publies()->get()`), which is more explicit at the call site.

## ✅ Key takeaways

- A local scope (`scopeXxx()`) factors out a reusable query condition, called without the `scope` prefix.
- An accessor transforms the value on read; a mutator transforms the value before writing — both via `Attribute::make()`.
- An attribute can be entirely virtual (computed, with no corresponding database column).
- A global scope applies everywhere automatically: powerful, but should be documented and limited to genuinely universal rules.

## ➡️ Going further

- [laravel.com/docs — Eloquent: Mutators & Casting](https://laravel.com/docs/eloquent-mutators)
- [laravel.com/docs — Query Scopes](https://laravel.com/docs/eloquent#query-scopes)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [07.1 — Advanced Eloquent Relationships](../01-eloquent-relations-avancees/README.en.md) · **Next:** [07.3 — Middlewares and Form Requests](../03-middlewares-form-requests/README.en.md)
