# 03.1 — Design Patterns in PHP

> **Status:** ✅ Available

## 🎯 Objectives

- Understand what a design pattern is and why to use one.
- Implement the Factory, Strategy, Observer, and Repository patterns in PHP.
- Recognize these patterns in existing code, notably in Laravel.

## 📋 Prerequisites

[Level 02 — Intermediate PHP](../../02-php-intermediaire/README.en.md) completed.

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### What is a design pattern?

A **design pattern** is a proven solution to a recurring software design problem. These aren't rules to apply everywhere systematically, but solutions to **recognize** when the problem they solve comes up. You've already met two of them: the **Singleton** ([module 02.3](../../02-php-intermediaire/03-poo-avancee-traits-static-magic-methods/README.en.md)) and the **Repository** ([module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md)).

### Factory: centralizing object creation

A **Factory** encapsulates the logic for creating objects, especially when that creation depends on a condition.

```php
<?php
declare(strict_types=1);

interface PaymentMethod {
    public function pay(float $amount): string;
}

class CardPayment implements PaymentMethod {
    public function pay(float $amount): string {
        return "Payment of \${$amount} by credit card";
    }
}

class PaypalPayment implements PaymentMethod {
    public function pay(float $amount): string {
        return "Payment of \${$amount} via PayPal";
    }
}

class PaymentMethodFactory {
    public static function create(string $type): PaymentMethod {
        return match ($type) {
            'card' => new CardPayment(),
            'paypal' => new PaypalPayment(),
            default => throw new InvalidArgumentException("Unknown payment method: $type"),
        };
    }
}

$payment = PaymentMethodFactory::create('card');
echo $payment->pay(49.99);
```

> 💡 The benefit: the calling code never needs to know the concrete classes (`CardPayment`, `PaypalPayment`) or their construction logic — it just asks the Factory for "a card-type payment method".

### Strategy: making a behavior interchangeable

The **Strategy** pattern lets you choose an algorithm/behavior at runtime, encapsulating it behind a common interface.

```php
<?php
interface DiscountStrategy {
    public function calculate(float $amount): float;
}

class FixedDiscount implements DiscountStrategy {
    public function __construct(private float $discountAmount) {}

    public function calculate(float $amount): float {
        return max(0, $amount - $this->discountAmount);
    }
}

class PercentageDiscount implements DiscountStrategy {
    public function __construct(private float $percentage) {}

    public function calculate(float $amount): float {
        return $amount * (1 - $this->percentage / 100);
    }
}

class Cart {
    public function __construct(private DiscountStrategy $strategy) {}

    public function calculateTotal(float $grossAmount): float {
        return $this->strategy->calculate($grossAmount);
    }
}

$cartWithFixedDiscount = new Cart(new FixedDiscount(10));
echo $cartWithFixedDiscount->calculateTotal(100); // 90

$cartWithPercentage = new Cart(new PercentageDiscount(20));
echo $cartWithPercentage->calculateTotal(100); // 80
```

> 📌 Notice that `Cart` **never** knows the concrete type of the strategy: this is the exact same polymorphism principle seen in [module 02.2](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.en.md), applied here to make a business behavior interchangeable.

### Observer: reacting to events

The **Observer** pattern lets an object (the "subject") automatically notify other objects (the "observers") when something happens, without the subject needing to know their internal logic.

```php
<?php
interface Observer {
    public function notify(string $event): void;
}

class EmailObserver implements Observer {
    public function notify(string $event): void {
        echo "Email sent for event: $event\n";
    }
}

class LoggingObserver implements Observer {
    public function notify(string $event): void {
        echo "[LOG] Event recorded: $event\n";
    }
}

class OrderManager {
    /** @var Observer[] */
    private array $observers = [];

    public function addObserver(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function validateOrder(): void {
        // ... business validation logic ...
        foreach ($this->observers as $observer) {
            $observer->notify("order_validated");
        }
    }
}

$manager = new OrderManager();
$manager->addObserver(new EmailObserver());
$manager->addObserver(new LoggingObserver());
$manager->validateOrder();
```

> 📌 This pattern is the conceptual foundation of Laravel's **Events/Listeners** system, covered in [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md): Laravel automates exactly this mechanism.

### Repository: a reminder

Already built in practice in [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) (`TacheRepository`, `LivreRepository`): this pattern isolates all data-access logic (SQL) behind a business-oriented interface, so the rest of the application never has to write SQL directly.

## ✅ Key takeaways

- A design pattern is a named, recognizable solution to a recurring design problem, not a rule to apply everywhere.
- **Factory**: centralizes object creation based on a condition.
- **Strategy**: makes an algorithm/behavior interchangeable via a common interface.
- **Observer**: notifies several objects of an event without coupling the subject to their logic.
- These patterns all rest on the same foundations: interfaces and polymorphism (level 02).

## ➡️ Going further

- [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns) — a very thorough visual reference on design patterns
- [Module 03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 02 — Intermediate PHP](../../02-php-intermediaire/README.en.md) · **Next:** [03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.md) *(French only)*
