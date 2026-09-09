# Exercises — 09.2 API Resources and Data Transformation

## Exercise 1 — First Resource (easy)

Create `ProduitResource` exposing `id`, `nom`, `prix` (cast to float). Use it in `show()` and compare the response with a direct model return.

## Exercise 2 — Hiding a sensitive field (easy)

Add a `cout_achat` field to the model (not meant for API clients). Verify it does NOT appear in `ProduitResource::toArray()` even though it exists in the database.

## Exercise 3 — Relationship with whenLoaded (medium)

Add the category to `ProduitResource` with `whenLoaded()`. Test `show()` with and without `->load('categorie')` beforehand, observe the difference (field absent vs. present in the JSON).

## Exercise 4 — Resource Collection with pagination (medium)

Use `ProduitResource::collection(Produit::paginate(10))` in `index()`. Inspect the complete JSON response and identify the `data`, `links`, `meta` keys.

## Exercise 5 — Detecting an N+1 in a Resource (hard)

Deliberately write `'categorie_nom' => $this->categorie->nom` (WITHOUT `whenLoaded`) in a Resource used by a collection of 20 products with NO eager loading beforehand. Use `DB::listen()` (module 07.1) to count the queries. Fix it with `with('categorie')` + `whenLoaded()` and compare.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
