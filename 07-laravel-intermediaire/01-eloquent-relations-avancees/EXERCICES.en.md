# Exercises — 07.1 Advanced Eloquent Relationships

## Exercise 1 — belongsToMany (easy)

Add a `Tag` model and an N-N relationship with `Article` from the [level 06 mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md). Create the pivot table migration, attach tags to an article via `attach()`, display them.

## Exercise 2 — sync() (easy)

Create an article edit form with checkboxes for tags. In the controller, use `sync($request->input('tags', []))` to update the associations in a single operation.

## Exercise 3 — Polymorphic relationship (medium)

Create a polymorphic `Like` model (`likeable`), usable on `Article` **and** `Comment`. Implement the relationship in both directions and display the number of likes on an article and a comment.

## Exercise 4 — Detecting and fixing an N+1 (medium)

Deliberately write a view displaying 20 articles with their category WITHOUT eager loading. Use `DB::listen()` (or Laravel Debugbar) to count the queries run. Add `with('categorie')` and compare the query count before/after.

## Exercise 5 — Enriched pivot table (hard)

Add an `ordre` (integer) column to the `article_tag` pivot table. Use `withPivot('ordre')` and display an article's tags sorted by this column (`$article->tags->sortBy('pivot.ordre')`).

---

See [solutions/README.md](solutions/README.md) for the answer key.
