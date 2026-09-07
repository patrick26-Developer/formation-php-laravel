# Exercises — 06.4 Eloquent ORM: The Basics

## Exercise 1 — First model (easy)

Create a `Produit` model (`nom`, `prix`, `stock`) with `$fillable` correctly defined. Via Tinker, create 3 products with `Produit::create()`.

## Exercise 2 — CRUD via Tinker (easy)

Via Tinker: retrieve all products (`all()`), find one by ID, change its price and save, then delete one.

## Exercise 3 — Query Builder (medium)

Via Tinker: find all products with stock greater than 0, sorted by descending price. Count the number of out-of-stock products (`stock = 0`).

## Exercise 4 — `$casts` (medium)

Add a `disponible` (boolean) column to `Produit`. Configure `$casts` to treat it as a boolean. Check via Tinker that `$produit->disponible` correctly returns `true`/`false` (not `1`/`0`).

## Exercise 5 — Comparing with the Level 02 Repository (hard)

Reuse `TacheRepository::creer()`, `trouver()`, `modifier()`, `supprimer()` from [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md). Rewrite each method as an equivalent static method using Eloquent, in a file `EloquentEquivalent.md`, with the original SQL next to it for a line-by-line comparison.

---

See [solutions/README.md](solutions/README.md) for the answer key.
