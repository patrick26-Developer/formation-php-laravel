# 02.1 — Object-Oriented Programming: The Basics

> **Status:** ✅ Available

## 🎯 Objectives

- Understand what a class and an object are.
- Create properties, methods, a constructor.
- Understand visibility levels (`public`, `private`, `protected`).
- Use `$this` to reference the current object.

## 📋 Prerequisites

[Level 01 — PHP Fundamentals](../../01-php-fondamentaux/README.en.md) completed.

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Why OOP?

Until now, you've handled data (arrays, variables) and functions separately. **Object-oriented programming** groups data and the functions that operate on it into a single entity: an **object**. This is the paradigm used by nearly all modern PHP code, and **entirely** by Laravel: every model, controller, and service you write later is a class.

### Declaring a class

```php
<?php
declare(strict_types=1);

class User {
    // Properties: the object's data
    public string $firstName;
    public string $email;
    private int $age;

    // Constructor: called automatically when the object is created
    public function __construct(string $firstName, string $email, int $age) {
        $this->firstName = $firstName;
        $this->email = $email;
        $this->age = $age;
    }

    // Method: a function belonging to the class
    public function describe(): string {
        return "$this->firstName ($this->email), $this->age years old";
    }
}
```

`$this` refers to the **current instance** of the object: inside a method, `$this->firstName` accesses the `firstName` property of the object the method was called on.

### Creating an object (instantiating a class)

```php
<?php
$user1 = new User("Alice", "alice@example.com", 28);
$user2 = new User("Bob", "bob@example.com", 35);

echo $user1->describe(); // Alice (alice@example.com), 28 years old
echo $user1->firstName;  // Alice (direct access, public property)
```

`$user1` and `$user2` are two independent **instances** of the same class: each has its own property values.

### Visibility levels

| Visibility | Accessible from... |
|---|---|
| `public` | Anywhere (inside and outside the class) |
| `protected` | The class itself and its child classes (inheritance, see [02.2](../02-poo-heritage-interfaces-abstraction/README.en.md)) |
| `private` | The class itself **only** |

```php
<?php
class BankAccount {
    private float $balance;

    public function __construct(float $initialBalance) {
        $this->balance = $initialBalance;
    }

    public function deposit(float $amount): void {
        $this->balance += $amount;
    }

    public function getBalance(): float {
        return $this->balance;
    }
}

$account = new BankAccount(100);
$account->deposit(50);
echo $account->getBalance(); // 150

// $account->balance;      // Fatal error: private property, inaccessible from outside
// $account->balance = 999; // impossible to "cheat" the balance directly
```

> ⚠️ **This training's rule: properties are `private` by default**, unless there's a specific reason otherwise. You expose **public methods** (`getBalance()`, `deposit()`) to control *how* a property can be read or changed, rather than letting any outside code modify it directly. This is the principle of **encapsulation**, one of the pillars of OOP.

### Promoted constructor properties (PHP 8+)

PHP 8 offers a shorthand syntax widely used in modern code (and in Laravel):

```php
<?php
class User {
    public function __construct(
        private string $firstName,
        private string $email,
        private int $age,
    ) {
    }

    public function describe(): string {
        return "$this->firstName ($this->email), $this->age years old";
    }
}
```

This syntax declares **and** assigns the properties in one step: no need to write `$this->firstName = $firstName;` for each property.

### Read-only properties (`readonly`, PHP 8.1+)

```php
<?php
class Point {
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {
    }
}

$point = new Point(3.5, 7.2);
echo $point->x; // 3.5
// $point->x = 10; // Error: cannot modify a readonly property after creation
```

`readonly` guarantees that a property can be assigned **only once**, in the constructor — useful for representing data that should never change after the object is created.

## ✅ Key takeaways

- A **class** is a blueprint, an **object** is a concrete instance of that blueprint.
- `$this` references the current object inside a method.
- Prefer `private` properties with public methods to access them (encapsulation).
- Promoted constructor syntax (`private string $firstName` directly in the parameters) is the norm in modern PHP.
- `readonly` prevents a property from being modified after it's created.

## ➡️ Going further

- [php.net/manual/en/language.oop5.php](https://www.php.net/manual/en/language.oop5.php)
- [Module 02.2 — Inheritance, Interfaces, Abstraction](../02-poo-heritage-interfaces-abstraction/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 01 — PHP Fundamentals](../../01-php-fondamentaux/README.en.md) · **Next:** [02.2 — Inheritance, Interfaces, Abstraction](../02-poo-heritage-interfaces-abstraction/README.en.md)
