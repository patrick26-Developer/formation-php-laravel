# 02.9 — Full CRUD with PDO (Sort, Filter, Search)

> **Status:** ✅ Available

## 🎯 Objectives

- Structure a complete CRUD (Create, Read, Update, Delete) with PDO and OOP.
- Add dynamic sorting, filtering, and search to a data list.
- Implement simple pagination.
- Organize this code into a reusable "Repository" class.

## 📋 Prerequisites

[02.8 — PDO and MySQL Databases](../08-pdo-bases-de-donnees-mysql/README.en.md)

## ⏱️ Estimated duration

3h.

## 📖 Theory

### CRUD: the 4 fundamental operations

CRUD = **C**reate, **R**ead, **U**pdate, **D**elete. This is the backbone of nearly every professional web application: blog, task management, e-commerce, back-office... **Every project in the rest of this training will use this pattern**, whether in native PHP (this module) or via Eloquent with Laravel (module 06.7).

### Organizing CRUD into a "Repository" class

Rather than scattering SQL queries across every page, we centralize access to a table in a dedicated class — a pattern called **Repository**, covered in depth as a design pattern in [module 03.1](../../03-php-avance/01-design-patterns-php/README.md).

```php
<?php
declare(strict_types=1);

namespace App;

class TaskRepository {
    public function __construct(private \PDO $pdo) {}

    // CREATE
    public function create(string $title, string $description): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO tasks (title, description, completed, created_at) VALUES (:title, :description, 0, NOW())"
        );
        $stmt->execute(['title' => $title, 'description' => $description]);

        return (int) $this->pdo->lastInsertId();
    }

    // READ (a single record)
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result === false ? null : $result;
    }

    // UPDATE
    public function update(int $id, string $title, string $description): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE tasks SET title = :title, description = :description WHERE id = :id"
        );
        $stmt->execute(['title' => $title, 'description' => $description, 'id' => $id]);

        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
```

### Advanced READ: sort, filter, search, pagination

This is where the "R" in CRUD becomes truly useful in production — a plain, raw list is rarely enough.

```php
<?php
class TaskRepository {
    // ... (previous methods) ...

    /**
     * @param string $sort Column to sort on (whitelisted for security)
     * @param string $order 'ASC' or 'DESC'
     * @param string|null $search Search term on the title
     * @param bool|null $completed Optional filter on status
     */
    public function list(
        string $sort = 'created_at',
        string $order = 'DESC',
        ?string $search = null,
        ?bool $completed = null,
        int $page = 1,
        int $perPage = 10,
    ): array {
        // ⚠️ IMPORTANT: $sort and $order potentially come from the user
        // (URL parameters). They CANNOT be passed as a regular bound parameter
        // like a normal value (PDO doesn't let you "bind" a column name),
        // so they are validated against a whitelist BEFORE being inserted
        // directly into the SQL query.
        $allowedColumns = ['title', 'created_at', 'completed'];
        if (!in_array($sort, $allowedColumns, true)) {
            $sort = 'created_at';
        }

        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $conditions = [];
        $parameters = [];

        if ($search !== null && $search !== '') {
            $conditions[] = "title LIKE :search";
            $parameters['search'] = '%' . $search . '%';
        }

        if ($completed !== null) {
            $conditions[] = "completed = :completed";
            $parameters['completed'] = (int) $completed;
        }

        $whereClause = $conditions !== [] ? "WHERE " . implode(" AND ", $conditions) : "";

        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM tasks $whereClause ORDER BY $sort $order LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        foreach ($parameters as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function count(?string $search = null, ?bool $completed = null): int {
        $conditions = [];
        $parameters = [];

        if ($search !== null && $search !== '') {
            $conditions[] = "title LIKE :search";
            $parameters['search'] = '%' . $search . '%';
        }

        if ($completed !== null) {
            $conditions[] = "completed = :completed";
            $parameters['completed'] = (int) $completed;
        }

        $whereClause = $conditions !== [] ? "WHERE " . implode(" AND ", $conditions) : "";

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM tasks $whereClause");
        $stmt->execute($parameters);

        return (int) $stmt->fetch()['total'];
    }
}
```

> ⚠️ **The most important security point in this module**: `$sort` (the column name) **cannot** be passed as a regular bound parameter — PDO only lets you bind *values*, not SQL identifiers (column/table names). That's why it's validated against a **whitelist** (`$allowedColumns`) before being inserted into the query. Never insert a sort/column parameter into SQL without this validation.

### Using it from a page (connecting to module 01.7)

```php
<?php
$repository = new TaskRepository($pdo);

$sort = $_GET['sort'] ?? 'created_at';
$order = $_GET['order'] ?? 'DESC';
$search = $_GET['search'] ?? null;
$page = max(1, (int) ($_GET['page'] ?? 1));

$tasks = $repository->list(sort: $sort, order: $order, search: $search, page: $page);
$total = $repository->count(search: $search);
$totalPages = (int) ceil($total / 10);
```

```html
<a href="?sort=title&order=ASC">Sort by title ↑</a>
<a href="?sort=created_at&order=DESC">Sort by date ↓</a>
<form method="GET">
    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit">Search</button>
</form>
```

## ✅ Key takeaways

- A Repository centralizes all of a table's SQL queries into a single class.
- A column name used for sorting must **always** be validated against a whitelist, never bound like a regular value.
- `LIKE '%term%'` for a partial search, with the value passed as a bound parameter.
- `LIMIT`/`OFFSET` for pagination, alongside a `COUNT(*)` to know the total number of pages.
- This Repository + sort/filter/search/pagination pattern maps directly onto Eloquent in [module 06.7](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.md).

## ➡️ Going further

- [dev.mysql.com — LIMIT](https://dev.mysql.com/doc/refman/8.0/en/select.html) (the `LIMIT ... OFFSET` clause)
- [Module 03.1 — Design Patterns in PHP](../../03-php-avance/01-design-patterns-php/README.en.md) (the Repository pattern in detail)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.8 — PDO and MySQL](../08-pdo-bases-de-donnees-mysql/README.en.md) · **Next:** [Mini-project: Task Manager (CRUD PDO)](../projet-mini-02-gestion-taches-crud-pdo/README.en.md)
