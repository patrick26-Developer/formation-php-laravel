# Exercises — 04.2 Advanced SQL

> Use this schema for all exercises:
> ```sql
> CREATE TABLE utilisateurs (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(100));
> CREATE TABLE commandes (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     utilisateur_id INT NOT NULL,
>     montant DECIMAL(10,2) NOT NULL,
>     FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
> );
> ```
> Insert a few users, including at least one with no order, and several orders.

## Exercise 1 — INNER JOIN (easy)

Write a query listing each user's name and the amount of each order.

## Exercise 2 — LEFT JOIN (easy)

Write a query listing ALL users with the amount of their orders (or `NULL` if they have none). Compare the number of rows returned with exercise 1.

## Exercise 3 — GROUP BY and HAVING (medium)

Write a query giving, for each user, their number of orders and total amount spent, showing only those who spent more than €50 in total.

## Exercise 4 — PDO transaction (medium)

Write a PHP script simulating a transfer between two accounts (a `comptes` table with `id`, `solde`) inside a PDO transaction. Test the case where everything goes well, then simulate an error (for example by forcing an exception after the first `UPDATE`) and check that `rollBack()` correctly cancels the first `UPDATE`.

## Exercise 5 — Indexes and EXPLAIN (hard)

Create a `journal_activite` table with at least 10,000 generated rows (use a PHP loop + inserts, or an SQL procedure), with an unindexed `utilisateur_id` column. Run `EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;` and note the number of rows examined. Create an index on `utilisateur_id`, rerun the same `EXPLAIN`, and compare.

---

Compare with [solutions/](solutions/README.en.md) once done.
