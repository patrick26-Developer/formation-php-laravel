# 04.1 — Relational Modeling (ERD)

> **Status:** ✅ Available

## 🎯 Objectives

- Understand why you model before coding.
- Identify entities, attributes, and relationships in a business need.
- Understand cardinalities (1-1, 1-N, N-N).
- Move from a Conceptual Data Model (CDM) to a Logical Data Model (LDM).

## 📋 Prerequisites

[Level 02 — Intermediate PHP](../../02-php-intermediaire/README.en.md) completed.

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Why model before coding?

Creating SQL tables directly "by instinct" almost always leads to duplicated, inconsistent data, or a structure that later needs a painful migration. **Relational modeling** is a thinking step, on paper or in a dedicated tool, **before** writing `CREATE TABLE`.

### Basic vocabulary

| Term | Definition | Example |
|---|---|---|
| **Entity** | A business object or concept you want to represent | `User`, `Order`, `Product` |
| **Attribute** | A property of an entity | `User` has a `name`, an `email` |
| **Relationship** | A link between two entities | A `User` **places** `Orders` |
| **Cardinality** | How many instances participate in a relationship | A user can place 0 to N orders |

### The three types of cardinality

**1-1 (one to one)**: each instance of one entity corresponds to at most one instance of the other.
```
User (1) ──── (1) DetailedProfile
```
Example: each user has exactly one detailed profile, and vice versa.

**1-N (one to many)**: one instance on one side can correspond to several on the other, but not the reverse.
```
User (1) ──── (N) Order
```
Example: a user can place several orders, but each order belongs to a single user. This is the most common relationship — you already implemented it in [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) via `utilisateur_id` on the `taches` table.

**N-N (many to many)**: instances on both sides can freely correspond to each other.
```
Student (N) ──── (N) Course
```
Example: a student can take several courses, and a course can have several students. **An N-N relationship necessarily requires an intermediate table** (called a join table or pivot table) when moving to the LDM.

### From CDM to LDM: translating relationships into tables

**1-N relationship**: the primary key on the "1" side becomes a **foreign key** in the table on the "N" side.

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

**N-N relationship**: an intermediate table holds the foreign keys of both linked tables.

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL
);

-- Pivot table: each row represents "this student takes this course"
CREATE TABLE enrollments (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    PRIMARY KEY (student_id, course_id), -- composite primary key: prevents duplicates
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);
```

> 📌 This pivot table (`enrollments`) is exactly what Laravel calls a "pivot table" for `belongsToMany` relationships, covered in [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md). Understanding this mechanism in plain SQL makes that Eloquent relationship immediately intuitive.

**1-1 relationship**: the foreign key can be placed on either side, usually with a `UNIQUE` constraint to guarantee it isn't repeated.

```sql
CREATE TABLE detailed_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE, -- UNIQUE guarantees the 1-1 relationship
    biography TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Normal forms (a practical overview)

**Normalization** avoids data duplication and inconsistency. Without going into the full theory (1NF, 2NF, 3NF), the most useful practical rule:

> Each piece of information should be stored **in only one place**. If you store a customer's name both in `customers` and copied into every `order`, an update to the name would have to be repeated everywhere — a source of inconsistency. Instead, store `customer_id` in `orders`, and fetch the name via a join (module 04.2) when needed.

## ✅ Key takeaways

- Modeling before coding avoids painful migrations later.
- Three cardinalities: 1-1 (rare), 1-N (the most common), N-N (requires a pivot table).
- The foreign key always goes on the "N" side of a 1-N relationship.
- Never duplicate information that can be retrieved via a relationship.

## ➡️ Going further

- [Module 04.2 — Advanced SQL: joins, indexes, transactions](../02-sql-avance-jointures-index-transactions/README.en.md)
- [Module 06.5 — Migrations, seeders, factories (Laravel)](../../06-laravel-fondamentaux/05-migrations-seeders-factories/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [Level 03 — Advanced PHP](../../03-php-avance/README.en.md) · **Next:** [04.2 — Advanced SQL](../02-sql-avance-jointures-index-transactions/README.en.md)
