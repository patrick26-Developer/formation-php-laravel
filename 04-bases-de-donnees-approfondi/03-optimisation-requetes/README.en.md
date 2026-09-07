# 04.3 — SQL Query Optimization

> **Status:** ✅ Available

## 🎯 Objectives

- Use `EXPLAIN` to understand how MySQL executes a query.
- Identify and fix the most common slow queries.
- Understand the performance impact of column type choices.

## 📋 Prerequisites

[04.2 — Advanced SQL: joins, indexes, transactions](../02-sql-avance-jointures-index-transactions/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### `EXPLAIN`: seeing how MySQL executes a query

```sql
EXPLAIN SELECT * FROM orders WHERE user_id = 42;
```

The most important columns in the result:

| Column | Meaning |
|---|---|
| `type` | Access strategy: `ALL` (full scan, to avoid) is the worst case, `ref`/`eq_ref`/`const` are good (use an index) |
| `key` | The index actually used (`NULL` = no index used) |
| `rows` | Estimated number of rows examined (lower is better) |
| `Extra` | Additional information (`Using filesort`, `Using temporary` are warning signs) |

> 📌 `type = ALL` on a large table means MySQL reads the **entire** table on every execution of this query — the first reflex is then to check whether an index exists on the `WHERE` column (module 04.2).

### Mistakes that prevent index usage

```sql
-- ❌ A function applied to the column prevents MySQL from using the index on "email"
SELECT * FROM users WHERE LOWER(email) = 'alice@example.com';

-- ✅ Store/compare directly in lowercase, or use an indexed generated column
SELECT * FROM users WHERE email = 'alice@example.com';
```

```sql
-- ❌ A LIKE starting with % prevents efficient use of a classic index
SELECT * FROM products WHERE name LIKE '%phone%';

-- ✅ A LIKE starting from the beginning of the string CAN use an index
SELECT * FROM products WHERE name LIKE 'iphone%';
```

> 📌 For a real, performant "contains" search on large volumes, MySQL offers **FULLTEXT indexes**, outside the scope of this training but good to know: `CREATE FULLTEXT INDEX idx_name ON products(name);` then `WHERE MATCH(name) AGAINST('phone')`.

### Choosing the right column types

- Use the **smallest type possible** that covers the real need: `TINYINT` for an age, not `BIGINT`.
- Use `VARCHAR(n)` with a realistic length rather than a systematic `TEXT` for short strings (emails, names) — faster to index.
- Use `DECIMAL` for money, never `FLOAT`/`DOUBLE` (rounding imprecision on financial calculations).
- Use `ENUM` or a reference table for a fixed set of values rather than a free-form `VARCHAR`.

### `SELECT *` vs explicit columns

```sql
-- ❌ Fetches ALL columns, even unused ones (unnecessary network/memory cost)
SELECT * FROM users WHERE id = 1;

-- ✅ Only fetches what's actually needed
SELECT name, email FROM users WHERE id = 1;
```

> 📌 On a small table, the difference is negligible. On a table with large columns (`TEXT`, `JSON`) or many columns, the difference becomes significant at scale.

### The N+1 problem, revisited with `EXPLAIN`

Already covered in [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.en.md): a query inside a PHP loop is often the most costly performance problem in an application, well ahead of column-type micro-optimizations. **Always check first whether a loop is running repeated queries** before optimizing an individual query.

## ✅ Key takeaways

- `EXPLAIN` before optimizing: never guess, always check `type`, `key`, `rows`.
- A function applied to an indexed column in a `WHERE` often prevents the index from being used.
- Choosing the right column type (size, precision) has a real impact at scale.
- The N+1 problem (module 03.6) remains, in practice, the most frequent cause of application slowness.

## ➡️ Going further

- [dev.mysql.com — EXPLAIN Output Format](https://dev.mysql.com/doc/refman/8.0/en/explain-output.html)
- [Module 08.2 — Cache and Performance Optimization (Laravel)](../../08-laravel-avance/02-cache-optimisation-performance/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [04.2 — Advanced SQL](../02-sql-avance-jointures-index-transactions/README.en.md) · **Next:** [04.4 — Practical SQL Exercises](../04-exercices-pratiques-sql/README.en.md)
