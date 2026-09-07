# 04.2 — Advanced SQL: Joins, Indexes, Transactions

> **Status:** ✅ Available

## 🎯 Objectives

- Master the different types of SQL joins.
- Understand the role of indexes and when to use them.
- Use transactions to guarantee data consistency.
- Understand referential integrity constraints.

## 📋 Prerequisites

[04.1 — Relational Modeling](../01-modelisation-relationnelle-mcd-mld/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Joins: combining data from several tables

Reusing the `users`/`orders` schema from the previous module:

```sql
-- INNER JOIN: only rows that have a match in BOTH tables
SELECT users.name, orders.amount
FROM orders
INNER JOIN users ON users.id = orders.user_id;
-- A user with NO order does NOT appear in the result.

-- LEFT JOIN: ALL rows from the left table, with NULL if there's no match
SELECT users.name, orders.amount
FROM users
LEFT JOIN orders ON orders.user_id = users.id;
-- A user with NO order still appears, with orders.amount as NULL.
```

> 📌 Practical rule: use `LEFT JOIN` whenever you want "all the X's, with their Y's if they exist" (e.g., all users, with their order count, including 0). Use `INNER JOIN` when you only care about the intersection.

### Multiple joins

```sql
SELECT loans.loan_date, books.title, members.name
FROM loans
INNER JOIN books ON books.id = loans.book_id
INNER JOIN members ON members.id = loans.member_id
WHERE loans.actual_return_date IS NULL; -- loans currently in progress
```

### `GROUP BY` and aggregations

```sql
-- Number of orders per user
SELECT users.name, COUNT(orders.id) AS order_count
FROM users
LEFT JOIN orders ON orders.user_id = users.id
GROUP BY users.id, users.name;

-- Total amount spent per user, only those who spent more than $100
SELECT users.name, SUM(orders.amount) AS total_spent
FROM users
INNER JOIN orders ON orders.user_id = users.id
GROUP BY users.id, users.name
HAVING SUM(orders.amount) > 100;
```

> 📌 `WHERE` filters rows **before** grouping, `HAVING` filters groups **after** aggregation (`SUM`, `COUNT`...). That's why `HAVING` is needed here: you can't write `WHERE SUM(...)`.

### Indexes: speeding up searches

An **index** is a data structure that lets MySQL find rows without scanning the entire table (like a book's index). A primary key is automatically indexed; other columns frequently filtered or joined on need to be indexed manually.

```sql
-- Speeds up queries that filter/join on orders.user_id
CREATE INDEX idx_orders_user ON orders(user_id);

-- Composite index: useful if you OFTEN filter on these two columns together
CREATE INDEX idx_tasks_user_status ON tasks(user_id, completed);
```

> ⚠️ Indexes speed up reads (`SELECT`) but **slightly slow down writes** (`INSERT`/`UPDATE`/`DELETE`, since the index also has to be updated) and consume disk space. Don't index "just in case" on every column — index the ones actually used in frequent `WHERE`, `JOIN`, or `ORDER BY` clauses. Covered in depth with `EXPLAIN` in [module 04.3](../03-optimisation-requetes/README.md).

### Transactions: guaranteeing consistency

A **transaction** groups several SQL operations into an **atomic** whole: either all of them succeed, or none of them are applied. Essential whenever several writes need to stay consistent with each other.

```sql
START TRANSACTION;

UPDATE accounts SET balance = balance - 100 WHERE id = 1; -- debit
UPDATE accounts SET balance = balance + 100 WHERE id = 2; -- credit

COMMIT; -- permanently applies both changes
-- or: ROLLBACK; -- cancels everything if an error is detected in between
```

In PHP with PDO:

```php
<?php
try {
    $pdo->beginTransaction();

    $pdo->prepare("UPDATE accounts SET balance = balance - :amount WHERE id = :id")
        ->execute(['amount' => 100, 'id' => 1]);

    $pdo->prepare("UPDATE accounts SET balance = balance + :amount WHERE id = :id")
        ->execute(['amount' => 100, 'id' => 2]);

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack(); // cancels EVERYTHING if one of the two queries failed
    throw $e;
}
```

> ⚠️ Without a transaction, a server crash or an exception **between** the two `UPDATE`s would leave the database in an inconsistent state (the money debited but never credited). This is exactly the kind of bug transactions prevent.

### Referential integrity constraints

```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE   -- deletes the orders if the user is deleted
        ON UPDATE CASCADE    -- propagates an ID change (rare in practice)
);
```

| `ON DELETE` option | Behavior |
|---|---|
| `CASCADE` | Also deletes related rows (already used in [mini-project 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md)) |
| `SET NULL` | Sets the foreign key to `NULL` (requires the column to accept `NULL`) |
| `RESTRICT` (default) | Prevents deletion as long as related rows exist |

## ✅ Key takeaways

- `INNER JOIN` = intersection, `LEFT JOIN` = everything from the left table + any matches.
- `WHERE` filters before grouping, `HAVING` filters after aggregation.
- An index speeds up reads but slows down writes: use it on columns that are actually filtered/joined on.
- A transaction guarantees that a group of operations succeeds or fails **entirely**, never partially.
- `ON DELETE CASCADE`/`SET NULL`/`RESTRICT` define the behavior when a referenced row is deleted.

## ➡️ Going further

- [dev.mysql.com — JOIN](https://dev.mysql.com/doc/refman/8.0/en/join.html)
- [Module 04.3 — SQL Query Optimization](../03-optimisation-requetes/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [04.1 — Relational Modeling](../01-modelisation-relationnelle-mcd-mld/README.en.md) · **Next:** [04.3 — SQL Query Optimization](../03-optimisation-requetes/README.en.md)
