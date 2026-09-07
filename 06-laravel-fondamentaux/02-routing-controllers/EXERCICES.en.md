# Exercises — 06.2 Routing and Controllers

## Exercise 1 — Simple routes (easy)

Create 3 GET routes (`/`, `/a-propos`, `/contact`), each returning a different string directly from an anonymous function.

## Exercise 2 — Classic controller (easy)

Create an `ArticleController` with an `index()` method returning a view (create a minimal view `resources/views/articles/index.blade.php` with just an `<h1>`).

## Exercise 3 — Model Binding (medium)

Create an `Article` model with a simple migration (`titre`, `contenu`). Create a route `/articles/{article}` and a `show(Article $article)` method that displays the article's title. Test with an existing ID and a non-existent ID (observe the automatic 404).

## Exercise 4 — Complete Resource Controller (medium)

Generate `php artisan make:controller ArticleController --resource`, declare `Route::resource('articles', ArticleController::class)`, and check the 7 routes with `php artisan route:list --name=articles`.

## Exercise 5 — Groups and named routes (hard)

Create a route group prefixed `admin` with `admin.*` naming, containing at least two routes. Use `route('admin.xxx')` in a controller to redirect to one of them. Check the generated URLs and names with `route:list`.

---

See [solutions/README.md](solutions/README.md) for the answer key.
