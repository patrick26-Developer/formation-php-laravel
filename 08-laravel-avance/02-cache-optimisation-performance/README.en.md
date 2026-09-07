# 08.2 — Cache and Performance Optimization

> **Status:** ✅ Available

## 🎯 Objectives

- Use Laravel's cache system to avoid repeated expensive computations/queries.
- Choose an appropriate cache invalidation strategy.
- Cache Eloquent queries and views.
- Use Artisan optimization commands for production.

## 📋 Prerequisites

[08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.en.md), [03.6 — Performance and Optimization](../../03-php-avance/06-performance-et-optimisation/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Caching: don't redo work already done recently

```
# .env
CACHE_STORE=redis   # or "file"/"database" in development, "redis" recommended in production
```

```php
use Illuminate\Support\Facades\Cache;

// Cache::remember(): computes ONCE, then reuses it for the given duration
$categories = Cache::remember('categories.toutes', now()->addHours(6), function () {
    return Category::orderBy('nom')->get();
});
```

> 💡 `Cache::remember()` first checks whether the key `'categories.toutes'` already exists in the cache: if so, it returns that value directly (no SQL query); otherwise, it runs the function, stores the result, then returns it. An ideal candidate: data that rarely changes (categories, configuration) but is read on **every** request.

### Invalidating the cache at the right time

```php
// After a change that makes the cache stale
Cache::forget('categories.toutes');

// Or directly at the moment of the change, in a Model Event (module 07.6)
class Category extends Model
{
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('categories.toutes'));
        static::deleted(fn () => Cache::forget('categories.toutes'));
    }
}
```

> ⚠️ **The real challenge with caching isn't filling it — it's knowing when to invalidate it.** A cache that's never invalidated serves stale data; a cache invalidated too often loses its entire benefit. Always explicitly identify **which event** must clear **which key**.

### Caching an expensive, parameterized query

```php
$statistiques = Cache::remember(
    "statistiques.utilisateur.{$user->id}",
    now()->addMinutes(30),
    fn () => [
        'total_annonces' => $user->annonces()->count(),
        'total_messages_recus' => Message::whereIn('annonce_id', $user->annonces()->pluck('id'))->count(),
    ]
);
```

> 📌 A **parameterized** cache key (including `$user->id`) is essential: without it, all users would share the same cache entry, showing another user's statistics — a potentially serious security bug.

### `Cache::tags()` to invalidate a group of keys (compatible drivers: Redis, Memcached)

```php
Cache::tags(['annonces'])->remember('annonces.actives', 3600, fn () => Annonce::actives()->get());

// Invalidates ALL keys associated with this tag at once
Cache::tags(['annonces'])->flush();
```

### Optimizing for production with Artisan

```bash
php artisan config:cache     # caches the entire configuration (see the pitfall in module 06.1)
php artisan route:cache        # caches routes, speeds up their resolution
php artisan view:cache           # pre-compiles Blade views

php artisan optimize             # runs the three commands above at once
php artisan optimize:clear         # cancels all of them (do this after every deployment, BEFORE recaching)
```

> ⚠️ A production deployment must **always** follow this order: `optimize:clear` (clear old caches) → deploy the new code → `optimize` (rebuild caches from the new code). Forgetting this step after a deployment can leave old routes or stale configuration running — covered in depth in [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md).

## ✅ Key takeaways

- `Cache::remember()` computes once, reuses for the specified duration — ideal for expensive, rarely-changing data.
- Always explicitly identify which event must invalidate which cache key.
- A cache key must be parameterized per user/context when the data depends on it, or you risk data leaking between users.
- `php artisan optimize`/`optimize:clear` bracket every production deployment.

## ➡️ Going further

- [laravel.com/docs — Cache](https://laravel.com/docs/cache)
- [Module 03.6 — Performance and Optimization](../../03-php-avance/06-performance-et-optimisation/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.en.md) · **Next:** [08.3 — Testing with Pest and PHPUnit in Laravel](../03-tests-pest-phpunit-laravel/README.en.md)
