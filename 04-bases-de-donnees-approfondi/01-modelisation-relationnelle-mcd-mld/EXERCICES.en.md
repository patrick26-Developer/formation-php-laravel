# Exercises — 04.1 Relational Modeling

## Exercise 1 — Identify the entities (easy)

For a library system (books, members, loans), list the entities and their main attributes (at least 3 attributes per entity).

## Exercise 2 — Identify the cardinalities (easy)

For each relationship below, state the cardinality (1-1, 1-N, or N-N) and justify it in one sentence:
- An `Author` writes `Book`s
- A `Book` is borrowed by `Member`s (over time, several loans are possible)
- A `Member` has a `LibraryCard`

## Exercise 3 — ERD to schema: a 1-N relationship (medium)

A `Book` has an `Author` (one book = one main author, an author can have written several books). Write the `CREATE TABLE` SQL for both tables with the foreign key correctly placed.

## Exercise 4 — ERD to schema: an N-N relationship (medium)

Translate the N-N relationship `Book` ↔ `Category` (a book can have several categories, a category contains several books) into SQL, with a pivot table named `livre_categorie`.

## Exercise 5 — Model a complete system (hard)

Model a complete library management system with: `auteurs`, `livres` (1 author per book), `categories` (N-N with books), `membres`, `emprunts` (a loan links a member to a book on a given date, with a planned return date and a nullable actual return date). Write the complete `CREATE TABLE` SQL with all primary and foreign keys.

---

Compare with [solutions/](solutions/) once done.
