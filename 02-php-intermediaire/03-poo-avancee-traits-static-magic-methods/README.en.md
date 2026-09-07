# 02.3 — Advanced OOP: Traits, Static, Magic Methods

> **Status:** ✅ Available

## 🎯 Objectives

- Reuse code between unrelated classes with traits.
- Understand and use static members (`static`).
- Know the most useful magic methods (`__construct`, `__toString`, `__get`, `__set`).
- Use enums (PHP 8.1+).

## 📋 Prerequisites

[02.2 — Inheritance, Interfaces, Abstraction](../02-poo-heritage-interfaces-abstraction/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Traits: sharing code without inheritance

PHP doesn't allow multiple inheritance (a class can only have one `extends`). **Traits** let you inject methods into several classes that aren't related through inheritance.

```php
<?php
declare(strict_types=1);

trait Timestampable {
    private ?DateTimeImmutable $createdAt = null;

    public function initializeTimestamp(): void {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getCreationDate(): ?DateTimeImmutable {
        return $this->createdAt;
    }
}

class Article {
    use Timestampable;

    public function __construct(private string $title) {
        $this->initializeTimestamp();
    }
}

class Comment {
    use Timestampable; // Comment and Article have no inheritance relationship, but share this behavior

    public function __construct(private string $content) {
        $this->initializeTimestamp();
    }
}
```

> 📌 Laravel makes heavy use of traits (for example `HasFactory`, `Notifiable` on Eloquent models, covered in [level 06](../../06-laravel-fondamentaux/README.md)) — understanding this mechanism now will save you a lot of confusion later.

### Static members: shared by every instance

A `static` property or method belongs to the **class itself**, not to a particular instance.

```php
<?php
class VisitCounter {
    private static int $total = 0;

    public static function increment(): void {
        self::$total++;
    }

    public static function getTotal(): int {
        return self::$total;
    }
}

VisitCounter::increment();
VisitCounter::increment();
VisitCounter::increment();

echo VisitCounter::getTotal(); // 3 -- shared across all calls, without instantiating the class
```

`self::` refers to the current class (useful inside static methods, where `$this` doesn't exist).

### The Singleton pattern (an example of using `static`)

```php
<?php
class Configuration {
    private static ?Configuration $instance = null;
    private array $settings = [];

    private function __construct() {
        $this->settings = ['app_name' => 'My PHP Training'];
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key): mixed {
        return $this->settings[$key] ?? null;
    }
}

$config = Configuration::getInstance();
echo $config->get('app_name');
```

> 📌 The Singleton is covered in depth as a design pattern in [module 03.1](../../03-php-avance/01-design-patterns-php/README.md). For now, remember the technical mechanism: a `private` constructor prevents `new Configuration()` from outside, forcing you to go through `getInstance()`.

### Essential magic methods

Magic methods start with `__` and are called automatically by PHP in certain situations.

```php
<?php
class Money {
    public function __construct(private float $amount, private string $currency) {}

    // Called automatically when the object is used as a string (echo, concatenation...)
    public function __toString(): string {
        return number_format($this->amount, 2) . " " . $this->currency;
    }
}

$price = new Money(19.9, "USD");
echo $price; // 19.90 USD -- __toString() is called automatically
echo "The price is: $price"; // also works with interpolation
```

```php
<?php
class FlexibleData {
    private array $data = [];

    // Called when accessing a non-existent property: $object->property
    public function __get(string $name): mixed {
        return $this->data[$name] ?? null;
    }

    // Called when assigning a non-existent property: $object->property = value
    public function __set(string $name, mixed $value): void {
        $this->data[$name] = $value;
    }
}

$object = new FlexibleData();
$object->color = "red"; // triggers __set()
echo $object->color;    // triggers __get() -- displays "red"
```

> ⚠️ `__get`/`__set` are powerful but should be used sparingly: they make code less explicit (you can no longer see directly which properties exist). Laravel uses them for its Eloquent models (accessing database columns as properties), but in your own code, prefer explicitly declared properties unless you have a specific need.

### Enums (PHP 8.1+): a fixed set of values

```php
<?php
enum OrderStatus: string {
    case Pending = 'pending';
    case Shipped = 'shipped';
    case Delivered = 'delivered';

    public function label(): string {
        return match ($this) {
            self::Pending => 'Awaiting processing',
            self::Shipped => 'Package shipped',
            self::Delivered => 'Package delivered',
        };
    }
}

$status = OrderStatus::Shipped;
echo $status->value;  // "shipped"
echo $status->label(); // "Package shipped"
```

> 📌 Enums advantageously replace old-style class constants for representing a fixed, finite set of possible values (statuses, roles, types...) — heavily used in modern Laravel.

## ✅ Key takeaways

- A trait injects methods into classes with no inheritance relationship (`use TraitName;`).
- `static` defines a member shared by the entire class, accessible via `self::` internally or `ClassName::` from outside.
- `__toString()` lets you use an object as a string.
- Typed enums cleanly represent a fixed set of values, with associated methods.

## ➡️ Going further

- [php.net/manual/en/language.oop5.traits.php](https://www.php.net/manual/en/language.oop5.traits.php)
- [php.net/manual/en/language.oop5.magic.php](https://www.php.net/manual/en/language.oop5.magic.php)
- [php.net/manual/en/language.enumerations.php](https://www.php.net/manual/en/language.enumerations.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.2 — Inheritance, Interfaces, Abstraction](../02-poo-heritage-interfaces-abstraction/README.en.md) · **Next:** [02.4 — Exception Handling](../04-gestion-exceptions/README.md) *(French only)*
