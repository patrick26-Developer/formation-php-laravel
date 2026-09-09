# Exercises — 03.2 Building an MVC Architecture from Scratch

## Exercise 1 — Minimal router (easy)

Implement the lesson's `Routeur` class. Add two GET routes (`/` and `/a-propos`) with anonymous functions printing simple text. Test by simulating different values of `$_SERVER['REQUEST_URI']`.

## Exercise 2 — Route with a dynamic parameter (medium)

Extend `Routeur` to support a parameter in the path, for example `/taches/{id}`. Hint: turn the route path into a regular expression (`{id}` becomes `([^/]+)`), and extract the captured values to pass to the handler.

## Exercise 3 — Separate Controller + View (medium)

Create a `ProduitController` with a `liste()` method that prepares an array of products (hardcoded, no database needed) and calls `Vue::afficher('produits/liste', ['produits' => $produits])`. Create the matching view file that displays the products as an HTML list.

## Exercise 4 — Complete front controller (hard)

Assemble the previous exercises: a single `public/index.php` that defines the routes, instantiates the controllers, and calls `$routeur->distribuer(...)`. Test with `php -S localhost:8000 public/index.php` (note the filename after the port: this forces ALL requests, including for paths that don't exist as files, to go through this script).

## Exercise 5 — Homemade middleware on the router (hard)

Add to `Routeur` the ability to attach one or more "middlewares" (simple functions returning `bool`) to a route, run **before** the handler. If a middleware returns `false`, the request stops (for example with a 403 code). Use this to protect an `/admin` route with an `estConnecte(): bool` middleware.

---

Compare with [solutions/](solutions/README.en.md) once done.
