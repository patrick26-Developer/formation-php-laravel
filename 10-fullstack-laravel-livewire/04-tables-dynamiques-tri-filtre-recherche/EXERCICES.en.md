# Exercises — 10.4 Dynamic Livewire Tables

## Exercise 1 — Table with search (easy)

Create `ProduitsTable` with a name search (`wire:model.live.debounce.300ms`), with no sorting or filtering yet.

## Exercise 2 — Adding clickable sorting (easy)

Add `trierPar()` with a whitelist of columns, and display an arrow showing the active column/direction in the headers.

## Exercise 3 — Category filter + pagination (medium)

Add a category `<select>` and `WithPagination`. Verify that changing page correctly preserves the active search and filter (thanks to `#[Url]`).

## Exercise 4 — Resetting pagination at the right moment (medium)

Add `updatingRecherche()` and `updatingCategorieId()` to reset the page to 1 as soon as a filter changes. Without this hook, deliberately trigger the bug (filter while on page 3 of a long list) and observe the problem before fixing it.

## Exercise 5 — Sharing a filter state via the URL (hard)

With `#[Url]` in place, copy the table's URL after typing a search and picking a sort. Open this URL in a new tab (or share it): verify the exact state (search, sort, page) is restored with no extra action. Explain in a comment why this is a significant advantage over a Livewire component that doesn't sync its state with the URL.

---

See [solutions/README.md](solutions/README.md) for the answer key.
