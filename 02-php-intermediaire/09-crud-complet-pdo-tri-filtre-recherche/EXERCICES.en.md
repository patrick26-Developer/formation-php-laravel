# Exercises — 02.9 Full CRUD with PDO

> Use the `livres` table created in module 02.8, or recreate it:
> ```sql
> CREATE TABLE livres (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     titre VARCHAR(150) NOT NULL,
>     auteur VARCHAR(100) NOT NULL,
>     annee INT NOT NULL,
>     disponible BOOLEAN DEFAULT TRUE
> );
> ```

## Exercise 1 — `LivreRepository`: basic CRUD (easy)

Create a `LivreRepository` class with a constructor taking a `PDO`, and the methods `creer()`, `trouver(int $id)`, `modifier()`, `supprimer()`. Test each one.

## Exercise 2 — List with sorting (medium)

Add a method `lister(string $tri = 'annee', string $ordre = 'DESC'): array` that validates `$tri` against a whitelist (`titre`, `auteur`, `annee`) before using it in the query. Test with several sort columns.

## Exercise 3 — Combined search and filter (medium)

Extend `lister()` to accept a `?string $recherche` parameter (search on `titre` OR `auteur`) and a `?bool $disponible` parameter (exact filter). Combine both in a single query (search AND filter applied simultaneously when both are provided).

## Exercise 4 — Pagination (hard)

Add `page` and `parPage` to `lister()`, with `LIMIT`/`OFFSET`, and a method `compter(?string $recherche = null, ?bool $disponible = null): int` reflecting the same filters. Insert at least 15 test books, then display page 2 with 5 results per page.

## Exercise 5 — Small CLI dashboard (hard)

Write a command-line script that accepts arguments (`php script.php --tri=titre --ordre=asc --recherche=Orwell`) via `$argv`, parses them simply, calls `lister()` with these values, and prints a formatted text table of the results in the terminal.

---

Compare with [solutions/](solutions/README.en.md) once done.
