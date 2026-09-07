# 02.2 — Inheritance, Interfaces and Abstract Classes

> **Status:** ✅ Available

## 🎯 Objectives

- Use inheritance to reuse code between closely related classes.
- Understand and use interfaces.
- Understand and use abstract classes.
- Know how to choose between inheritance, interface, and composition.

## 📋 Prerequisites

[02.1 — OOP: The Basics](../01-poo-bases/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Inheritance: `extends`

Inheritance lets a class (the **child** class) reuse the properties and methods of another class (the **parent** class).

```php
<?php
declare(strict_types=1);

class Animal {
    public function __construct(
        protected string $name,
    ) {
    }

    public function move(): string {
        return "$this->name moves.";
    }
}

class Bird extends Animal {
    public function fly(): string {
        return "$this->name flies through the sky.";
    }
}

$bird = new Bird("Parrot");
echo $bird->move(); // Parrot moves. (inherited method)
echo $bird->fly();  // Parrot flies through the sky. (own method)
```

> 📌 Notice `protected` rather than `private` on `$name`: a `private` property would **not be accessible** from `Bird`, even when inheriting from `Animal`. `protected` allows access from the class itself **and** its child classes.

### Overriding a method and `parent::`

```php
<?php
class Animal {
    public function __construct(protected string $name) {}

    public function makeSound(): string {
        return "$this->name makes a sound.";
    }
}

class Dog extends Animal {
    public function makeSound(): string {
        return "$this->name barks."; // completely overrides the parent method
    }
}

class Cat extends Animal {
    public function makeSound(): string {
        // parent:: explicitly calls the parent class's method
        return parent::makeSound() . " Well, more like it meows.";
    }
}
```

### Interfaces: defining a contract

An interface defines **what a class must be able to do**, without saying **how**. A class can implement several interfaces (unlike inheritance, limited to a single parent class).

```php
<?php
interface Payable {
    public function calculateAmount(): float;
}

class Invoice implements Payable {
    public function __construct(private float $amountExclTax) {}

    public function calculateAmount(): float {
        return $this->amountExclTax * 1.20;
    }
}

class Subscription implements Payable {
    public function __construct(private float $monthlyPrice, private int $months) {}

    public function calculateAmount(): float {
        return $this->monthlyPrice * $this->months;
    }
}

// This function doesn't care about the CONCRETE type, only that it honors the Payable contract
function displayAmount(Payable $item): void {
    echo "Amount due: " . $item->calculateAmount() . "\n";
}

displayAmount(new Invoice(100));
displayAmount(new Subscription(9.99, 12));
```

> 💡 This is the principle of **polymorphism**: the same function (`displayAmount`) handles different types of objects (`Invoice`, `Subscription`) uniformly, as long as they honor the same contract. You'll find this principle everywhere in Laravel (Contracts, dependency injection).

### Abstract classes

An abstract class **cannot be instantiated directly** — it serves as a common base, requiring certain methods to be implemented in child classes.

```php
<?php
abstract class Shape {
    // Abstract method: every child class MUST implement it
    abstract public function calculateArea(): float;

    // Concrete method: inherited as-is by all child classes
    public function describe(): string {
        return "This shape has an area of " . $this->calculateArea() . " m².";
    }
}

class Rectangle extends Shape {
    public function __construct(private float $width, private float $height) {}

    public function calculateArea(): float {
        return $this->width * $this->height;
    }
}

class Circle extends Shape {
    public function __construct(private float $radius) {}

    public function calculateArea(): float {
        return M_PI * $this->radius ** 2;
    }
}

// new Shape(); // Error: cannot instantiate an abstract class

$rectangle = new Rectangle(4, 5);
echo $rectangle->describe(); // This shape has an area of 20 m².
```

### Interface vs abstract class vs simple inheritance: how to choose?

| Situation | Solution |
|---|---|
| Very closely related classes that share a lot of code | Simple inheritance (`extends`) |
| A "contract" that several unrelated classes must honor | Interface (`implements`) |
| A common base with shared code **and** methods to enforce | Abstract class |
| A class needs to honor several different contracts | Multiple interfaces (`implements A, B`) |

## ✅ Key takeaways

- `extends` to inherit from a class, `implements` to honor an interface (multiple are possible).
- `protected` is visible in child classes, unlike `private`.
- An abstract class is never instantiated directly, and can enforce certain methods via `abstract`.
- Polymorphism lets you write generic code that works with several types of objects sharing the same contract.

## ➡️ Going further

- [php.net/manual/en/language.oop5.inheritance.php](https://www.php.net/manual/en/language.oop5.inheritance.php)
- [php.net/manual/en/language.oop5.interfaces.php](https://www.php.net/manual/en/language.oop5.interfaces.php)
- [php.net/manual/en/language.oop5.abstract.php](https://www.php.net/manual/en/language.oop5.abstract.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [02.1 — OOP: The Basics](../01-poo-bases/README.en.md) · **Next:** [02.3 — Advanced OOP: Traits, Static, Magic Methods](../03-poo-avancee-traits-static-magic-methods/README.en.md)
