# 04.4 — Practical SQL Exercises

> **Status:** ✅ Available

## 🎯 Objectives

Consolidate the entire Level 04 (modeling, joins, indexes, transactions, optimization) through a series of progressive exercises on a single schema, closer to a real-world case than the isolated examples of the previous modules.

## 📋 Prerequisites

[04.1](../01-modelisation-relationnelle-mcd-mld/README.en.md), [04.2](../02-sql-avance-jointures-index-transactions/README.en.md), and [04.3](../03-optimisation-requetes/README.en.md).

## ⏱️ Estimated duration

2h30.

## 📖 The working schema

Every exercise in this module uses this simplified e-commerce schema. Create it before starting:

```sql
CREATE DATABASE IF NOT EXISTS exercices_sql_04;
USE exercices_sql_04;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    registered_on DATE NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    placed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Pivot table: an order contains several products, each with a quantity
CREATE TABLE order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL, -- price at the time of the order (may differ from the product's current price)
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

> 💡 Notice `unit_price` duplicated in `order_items` rather than looking up `products.price` every time: this is **deliberate**, not a violation of module 04.1's principle. A product's price can change after an order was placed — an invoice must always reflect the price paid **at the time of purchase**, not the current price.

Insert some test data (at least 5 customers, 8 products, 10 orders each with several line items) before continuing.

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md) — about ten progressive exercises covering modeling, multiple joins, aggregations, transactions, and optimization.

---

**Previous:** [04.3 — SQL Query Optimization](../03-optimisation-requetes/README.en.md) · **Next:** [Level 05 — Professional Tools](../../05-outils-professionnels/README.en.md)
