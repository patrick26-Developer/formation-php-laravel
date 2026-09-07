# Exercises — 06.7 Full Laravel CRUD

## Exercise 1 — Basic CRUD (easy)

Generate a complete Resource Controller for an `Article` model (`titre`, `contenu`). Implement all 7 methods with Eloquent, with no sort/filter for now.

## Exercise 2 — Search (easy)

Add a title search in `index()`, with a GET form field and `when()`.

## Exercise 3 — Clickable sorting (medium)

Add sorting on `titre` and `created_at`, with a whitelist of allowed columns, and clickable links in the view that reverse the order on a second click.

## Exercise 4 — Pagination with preserved filters (medium)

Add `paginate(10)` and `withQueryString()`. Check that changing page correctly preserves the active search and sort in the URL.

## Exercise 5 — Combined filter with status (hard)

Add a `publie` (boolean) column to `Article`. Add a status filter (`all`/`published`/`drafts`) combined with the existing search and sort, all applied simultaneously when present. Check every possible combination.

---

See [solutions/README.md](solutions/README.md) for the answer key.
