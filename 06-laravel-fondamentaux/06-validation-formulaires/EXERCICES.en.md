# Exercises — 06.6 Form Validation

## Exercise 1 — Basic validation (easy)

Add validation to a `store()` controller for a `Produit` model: `nom` required (max 150), `prix` required numeric positive (`min:0`), `stock` required positive integer.

## Exercise 2 — Custom messages (easy)

Customize exercise 1's form error messages with explicit English text for each rule.

## Exercise 3 — Uniqueness and existence (medium)

Add to a registration form: `email` required, valid email format, unique in `users`. Add to a product form: `categorie_id` required, must exist in `categories`.

## Exercise 4 — Form Request (medium)

Extract exercise 1's validation into a `StoreProduitRequest` class. Adapt the controller to use it instead of `$request->validate()`.

## Exercise 5 — Shared Form Request for create/update (hard)

Create separate `StoreProduitRequest` and `UpdateProduitRequest` classes, where a `unique` rule on a field (for example a unique product code) must **ignore** the current record during an update (hint: `Rule::unique('produits')->ignore($this->produit)`). Explain in a comment why this rule differs between creation and update.

---

See [solutions/README.md](solutions/README.md) for the answer key.
