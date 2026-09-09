# Exercises — 07.2 Scopes, Accessors, Mutators

## Exercise 1 — Simple local scope (easy)

Add a `recents` scope to `Article` returning articles created in the last 7 days (`where('created_at', '>=', now()->subDays(7))`).

## Exercise 2 — Scope with a parameter (easy)

Add a `parAuteur($nom)` scope (if you have an author field, otherwise simulate with `parCategorie($id)`). Chain it with `publies()`.

## Exercise 3 — Computed accessor (medium)

Add a `dureeLecture` accessor on `Article`, estimating reading time in minutes (`str_word_count($this->contenu) / 200`, rounded up, minimum 1).

## Exercise 4 — Normalization mutator (medium)

Add a mutator on `email` for a `User`-like model (or simulate with `Category::nom`) that forces storage in lowercase, with an accessor that capitalizes the first letter on display.

## Exercise 5 — Documented global scope (hard)

Add a global scope on `Article` hiding archived articles (a new `archive` boolean column). Document in a PHPDoc comment above the class why this choice was made globally rather than locally, and show how a developer could explicitly include archived ones despite the global scope (`withoutGlobalScope`).

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
