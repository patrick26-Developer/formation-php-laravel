# Exercises — 04.3 Query Optimization

## Exercise 1 — Reading an EXPLAIN (easy)

On the `journal_activite` table from [module 04.2, exercise 5](../02-sql-avance-jointures-index-transactions/README.en.md), run `EXPLAIN` on three different queries (with and without an indexed `WHERE`, with an `ORDER BY`). Note the `type`, `key`, and `rows` values for each.

## Exercise 2 — Fixing a non-indexable WHERE (easy)

This query never uses the index on `email`, even though it exists:
```sql
SELECT * FROM utilisateurs WHERE UPPER(email) = 'ALICE@EXAMPLE.COM';
```
Rewrite it so it can use the index.

## Exercise 3 — Choosing the right types (medium)

This table has some questionable type choices. Propose a corrected version with a justification for each change:
```sql
CREATE TABLE produits (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nom TEXT NOT NULL,
    prix FLOAT NOT NULL,
    en_stock VARCHAR(10) NOT NULL -- holds "yes" or "no"
);
```

## Exercise 4 — SELECT * vs explicit columns (medium)

On an `articles` table with a `contenu TEXT` column (potentially large) in addition to `id`, `titre`, `auteur_id`, write the query for an article list page that displays ONLY the title and author — with no `SELECT *`.

## Exercise 5 — Full diagnosis (hard)

This query is slow on a table of 500,000 rows:
```sql
SELECT * FROM commandes
WHERE YEAR(date_commande) = 2025
ORDER BY montant DESC;
```
Identify at least two potential performance problems (hint: a function on a date column, no index covering the sort) and propose a corrected query and/or index.

---

Compare with [solutions/](solutions/) once done.
