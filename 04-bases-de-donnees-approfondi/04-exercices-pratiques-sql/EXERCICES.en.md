# Exercises — 04.4 Practical SQL Exercises

> Use the `exercices_sql_04` schema described in [README.md](README.en.md).

## Exercise 1 — Total revenue per order (easy)

For each order, calculate its total amount (sum of `quantite * prix_unitaire` over its lines), along with the customer's name.

## Exercise 2 — Never-ordered products (easy)

List every product that appears in **no** order line at all (hint: `LEFT JOIN` + `WHERE ... IS NULL`).

## Exercise 3 — Top 3 customers by amount spent (medium)

Write a query giving the 3 customers who spent the most in total (across all products), with their total amount, sorted descending, using `LIMIT`.

## Exercise 4 — Best-selling products (medium)

List the products with the total quantity sold (summed across all orders), sorted by descending quantity. Only show products sold at least once.

## Exercise 5 — Customers with no recent order (medium)

List customers who haven't placed any order in the last 90 days (including those who have never ordered at all). Use `DATE_SUB(NOW(), INTERVAL 90 DAY)`.

## Exercise 6 — Placing an order inside a transaction (hard)

Write a PHP script `passerCommande(PDO $pdo, int $clientId, array $lignes): int` (where `$lignes` is an array of `['produit_id' => ..., 'quantite' => ...]`) that, inside a transaction: creates the order, inserts each line with the product's current price, decrements each product's stock, and fails cleanly (rollback) if a product doesn't have enough stock.

## Exercise 7 — Verifying referential integrity (hard)

Try to delete a customer who has existing orders, with no `ON DELETE CASCADE` and no prior deletion of the linked orders. Observe and note the MySQL error you get. Explain in a comment why this default behavior (`RESTRICT`) is a useful protection rather than a nuisance.

## Exercise 8 — Optimizing a search query (hard)

This product-name search query is used very frequently on a catalog of 100,000 products:
```sql
SELECT * FROM produits WHERE nom LIKE '%casque%';
```
Explain why a classic index on `nom` wouldn't significantly help this query, and propose an alternative (hint: `FULLTEXT`, see module 04.3).

---

Compare with [solutions/](solutions/README.en.md) once done.
