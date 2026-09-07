# Exercises — 08.2 Cache and Performance Optimization

## Exercise 1 — First cache (easy)

Cache the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md)'s category list for 1 hour with `Cache::remember()`. Verify with `DB::listen()` (module 07.1) that only a single SQL query runs across several successive page loads.

## Exercise 2 — Manual invalidation (easy)

Add `Cache::forget('categories.toutes')` to `CategoryController::store()` after creation. Verify a new category immediately appears in the cached list.

## Exercise 3 — Invalidation via a Model Event (medium)

Replace exercise 2's manual invalidation with a Model Event (`saved`/`deleted`) on `Category`, guaranteeing invalidation no matter the entry point of the change.

## Exercise 4 — Cache parameterized per user (medium)

Cache a user's active listing count (`"annonces.actives.count.{id}"`, 15 minutes). Verify that two different users correctly get independent values.

## Exercise 5 — Measuring the real gain (hard)

With a category having 100+ listings (generate them via a factory), compare the list page's response time **without** cache then **with** an active cache (`microtime(true)` before/after, or Laravel Debugbar). Document the measured gain and explain in a comment why this gain would be nearly zero on a page that changes on every request (e.g., a real-time news feed).

---

See [solutions/README.md](solutions/README.md) for the answer key.
