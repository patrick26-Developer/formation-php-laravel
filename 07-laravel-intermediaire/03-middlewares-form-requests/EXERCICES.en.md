# Exercises — 07.3 Middlewares and Form Requests

## Exercise 1 — First middleware (easy)

Create a `LogRequete` middleware that logs (`logger()`) the method and URL of every incoming request, then lets it through. Register it globally in `bootstrap/app.php`.

## Exercise 2 — Conditional middleware (easy)

Create an `EstEnHeuresOuvrables` middleware that blocks access (403) outside 8am-8pm (simulate with `now()->hour`). Apply it to a test route.

## Exercise 3 — Middleware with a parameter (medium)

Create a `role:xxx` middleware that checks `$request->user()->role === $role`. Apply it to two different routes with different roles (`role:admin`, `role:editeur`).

## Exercise 4 — Execution order (medium)

Create two middlewares, `PremierMiddleware` and `SecondMiddleware`, each logging its pass-through before AND after `$next($request)`. Apply them in one order then the reverse order on two different routes, observe the logs, and explain in a comment why `$next()`'s ordering produces a "stack" effect (first in, last out).

## Exercise 5 — Form Request with authorization (hard)

On the [level 06 mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md), add a `user_id` column to `articles` (simulating an author). Modify `UpdateArticleRequest` so `authorize()` returns `true` only if the logged-in user is the article's author. Test the refused case (403) with another user.

---

See [solutions/README.md](solutions/README.md) for the answer key.
