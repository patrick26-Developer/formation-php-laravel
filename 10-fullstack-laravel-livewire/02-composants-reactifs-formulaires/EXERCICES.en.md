# Exercises — 10.2 Reactive Components and Forms

## Exercise 1 — Simple form (easy)

Create a `FormulaireCategorie` component with a `nom` field (`wire:model`), a `creer()` method that adds it to the database and clears the field.

## Exercise 2 — Validation with a Rule attribute (easy)

Add `#[Rule('required|min:2|max:50')]` to `$nom`. Display the error with `@error`. Test an empty submission.

## Exercise 3 — Real-time validation (medium)

Switch the field to `wire:model.live` and add `updated()` with `validateOnly()`. Verify the error appears/disappears as the user types, without submitting the form.

## Exercise 4 — Communication between components (medium)

Create `ListeCategories` displaying all categories. Make `FormulaireCategorie::creer()` emit a `categorie-creee` event, listened for by `ListeCategories` to refresh itself automatically, with no page reload.

## Exercise 5 — Comparing .live and deferred (hard)

Create a search field with `wire:model` (deferred, no `.live`) tied to a "Search" button (`wire:click`), then a second version with `wire:model.live` and no button (searches on every keystroke). Using the browser's network tools, count the AJAX requests made typing "laravel" (7 characters) in each version. Explain in a comment the observed UX/performance trade-off.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
