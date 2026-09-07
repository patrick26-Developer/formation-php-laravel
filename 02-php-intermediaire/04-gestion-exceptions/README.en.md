# 02.4 — Exception Handling

> **Status:** ✅ Available

## 🎯 Objectives

- Understand PHP's exception hierarchy.
- Create your own custom exception classes.
- Catch several types of exceptions distinctly.
- Adopt good error-handling practices in object-oriented code.

## 📋 Prerequisites

[02.3 — Advanced OOP: Traits, Static, Magic Methods](../03-poo-avancee-traits-static-magic-methods/README.en.md) and [01.9 — Introduction to Error Handling](../../01-php-fondamentaux/09-gestion-erreurs-debutant/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### PHP's exception hierarchy

Every PHP exception implements (directly or indirectly) the `Throwable` interface. The two main branches:

- **`Error`** and its subclasses (`TypeError`, `ValueError`, `DivisionByZeroError`...): programming errors, generally **not meant to be caught** in normal use (a bug to fix).
- **`Exception`** and its subclasses (`InvalidArgumentException`, `RuntimeException`, `LogicException`...): "expected" errors in a program's normal flow, which you **catch and handle**.

```php
<?php
try {
    $result = 10 / 0; // DivisionByZeroError in PHP 8+ (not a plain Exception)
} catch (DivisionByZeroError $e) {
    echo "Error: " . $e->getMessage();
}
```

### Creating a custom exception

In a real application, you create exception classes specific to your domain, by extending `Exception`:

```php
<?php
declare(strict_types=1);

class InsufficientBalanceException extends Exception {
    public function __construct(
        private float $availableBalance,
        private float $requestedAmount,
    ) {
        parent::__construct("Insufficient balance: \${$availableBalance} available, \${$requestedAmount} requested.");
    }

    public function getAvailableBalance(): float {
        return $this->availableBalance;
    }

    public function getRequestedAmount(): float {
        return $this->requestedAmount;
    }
}

class BankAccount {
    public function __construct(private float $balance) {}

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            throw new InsufficientBalanceException($this->balance, $amount);
        }

        $this->balance -= $amount;
    }
}

$account = new BankAccount(100);

try {
    $account->withdraw(500);
} catch (InsufficientBalanceException $e) {
    echo $e->getMessage() . "\n";
    echo "Missing: \$" . ($e->getRequestedAmount() - $e->getAvailableBalance()) . "\n";
}
```

> 💡 The benefit of a custom exception: it carries **structured data** about the error (here `availableBalance` and `requestedAmount`), not just a text message. The calling code can react precisely based on the type of exception caught.

### Catching several types of exceptions

```php
<?php
try {
    // ... code that may throw different exceptions
} catch (InsufficientBalanceException $e) {
    echo "Balance issue: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo "Invalid argument: " . $e->getMessage();
} catch (Exception $e) {
    // Safety net: catches everything else (ALWAYS place this last)
    echo "Unexpected error: " . $e->getMessage();
}
```

> ⚠️ The order of `catch` blocks matters: PHP tests each block in order and runs the **first** one that matches. A `catch (Exception $e)` placed first would catch *everything*, preventing the more specific blocks placed after it from ever running.

Since PHP 8, you can also catch several types in a single block:

```php
<?php
try {
    // ...
} catch (InsufficientBalanceException | InvalidArgumentException $e) {
    echo "Validation error: " . $e->getMessage();
}
```

### Chaining exceptions (`previous`)

Useful for preserving the original cause when "translating" a technical exception into a business exception:

```php
<?php
try {
    try {
        throw new RuntimeException("Database connection error");
    } catch (RuntimeException $technicalError) {
        throw new Exception("Unable to load the user profile", 0, $technicalError);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";                     // Unable to load the user profile
    echo $e->getPrevious()->getMessage() . "\n";        // Database connection error
}
```

## ✅ Key takeaways

- `Error` = programming bug (often not caught), `Exception` = expected business situation (to be caught).
- Creating custom exceptions lets you carry structured data about the error, not just text.
- Order `catch` blocks from most specific to most general.
- `getPrevious()` lets you preserve the original cause of a "translated" error.

## ➡️ Going further

- [php.net/manual/en/language.exceptions.php](https://www.php.net/manual/en/language.exceptions.php)
- [php.net/manual/en/spl.exceptions.php](https://www.php.net/manual/en/spl.exceptions.php) — the standard SPL exceptions (`InvalidArgumentException`, `RuntimeException`, etc.)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.3 — Advanced OOP](../03-poo-avancee-traits-static-magic-methods/README.en.md) · **Next:** [02.5 — Sessions, Cookies, Homemade Authentication](../05-sessions-cookies-authentification-maison/README.en.md)
