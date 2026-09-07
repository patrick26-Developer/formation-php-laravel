# 03.5 — Best Practices, PSR-12 and Clean Code

> **Status:** ✅ Available

## 🎯 Objectives

- Know and apply the PSR-12 style rules.
- Understand the SOLID principles and their practical value.
- Recognize and fix the most common "code smells".
- Automate style checking with PHP-CS-Fixer.

## 📋 Prerequisites

[03.4 — Building a REST API in Native PHP](../04-construction-api-rest-php-natif/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### PSR-12: the standard code style

PSR-12 (introduced in [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md)) defines precise formatting rules. The most important ones for everyday use:

```php
<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Notifiable;

class NotificationManager implements Notifiable
{
    public function __construct(
        private string $channel,
    ) {
    }

    public function send(string $message): bool
    {
        if ($this->channel === 'email') {
            // ...
        }

        return true;
    }
}
```

Key rules:
- The opening brace `{` of a **class** or a **method** is on its **own line**.
- The opening brace of a control structure (`if`, `foreach`...) is on the **same line**.
- **4-space** indentation, never tabs.
- One statement per line.
- `use` statements grouped at the top of the file, after `namespace`.

> 📌 You don't need to memorize every rule: a tool (PHP-CS-Fixer, covered below) applies them automatically.

### The SOLID principles (a practical overview)

| Principle | In one sentence |
|---|---|
| **S**ingle Responsibility | A class should have only **one reason to change** |
| **O**pen/Closed | You should be able to extend a behavior without modifying existing code |
| **L**iskov Substitution | A child class should be able to replace its parent class without breaking the program |
| **I**nterface Segregation | Prefer several small, specific interfaces over one large general one |
| **D**ependency Inversion | Depend on abstractions (interfaces), not concrete implementations |

Example of a Single Responsibility violation and its fix:

```php
<?php
// ❌ This class has TWO reasons to change: business logic AND sending email
class UserRegistration {
    public function register(string $email, string $password): void {
        // ... validation, hashing, saving to the database ...

        // Why does a "Registration" class know how to send emails via mail()?
        mail($email, "Welcome", "Thanks for signing up!");
    }
}

// ✅ Each class has a single responsibility, one uses the other
class UserRegistration {
    public function __construct(private EmailService $emailService) {}

    public function register(string $email, string $password): void {
        // ... validation, hashing, saving to the database ...

        $this->emailService->send($email, "Welcome", "Thanks for signing up!");
    }
}
```

> 📌 This is directly tied to exercise 5 of [module 03.3](../03-tests-unitaires-phpunit/README.en.md): a `RegistrationService` that depends on `EmailService` (**Dependency Inversion** in seed form) is easier to test **and** easier to evolve (swap email providers without touching the registration logic).

### Recognizing common "code smells"

| Code smell | Symptom | Remedy |
|---|---|---|
| **Function too long** | A 100+ line method, hard to grasp at a glance | Extract well-named sub-methods |
| **Vague naming** | `$d`, `$data`, `process()` | Names that precisely describe intent (`$expirationDate`, `calculateLoyaltyDiscount()`) |
| **Duplicated code** | The same block copy-pasted in several places | Extract a shared function/method (see the Repository, module 02.9) |
| **Magic numbers/strings** | `if ($status === 3)` with no explanation | Use a named constant or enum (`OrderStatus::Delivered`, module 02.3) |
| **A comment explaining confusing code** | `// checks whether the user can...` above a 5-operator condition | Extract the condition into a well-named method (`$user->canEditThisArticle()`) |

### Automating with PHP-CS-Fixer

```bash
composer require --dev friendsofphp/php-cs-fixer
```

```bash
./vendor/bin/php-cs-fixer fix src/ --rules=@PSR12
```

> 📌 Covered in depth with its full configuration in [module 05.5 — Code Quality: PHPStan and PHP-CS-Fixer](../../05-outils-professionnels/05-qualite-code-phpstan-php-cs-fixer/README.md), where we'll also see how to integrate it into a CI/CD pipeline.

## ✅ Key takeaways

- PSR-12 standardizes formatting; a tool (PHP-CS-Fixer) applies it automatically, no need to memorize it.
- SOLID, and especially the single responsibility principle, guides you toward small, easily testable classes.
- Explicit naming is often more effective than a comment at making code understandable.
- A code smell isn't a blocking error, but a signal that refactoring would improve maintainability.

## ➡️ Going further

- [php-fig.org/psr/psr-12/](https://www.php-fig.org/psr/psr-12/)
- [Module 05.5 — Code Quality: PHPStan and PHP-CS-Fixer](../../05-outils-professionnels/05-qualite-code-phpstan-php-cs-fixer/README.md) *(French only)*
- [Module 14.2 — Code Review and Refactoring](../../14-preparation-professionnelle/02-code-review-et-refactoring/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [03.4 — Building a REST API in Native PHP](../04-construction-api-rest-php-natif/README.en.md) · **Next:** [03.6 — PHP Performance and Optimization](../06-performance-et-optimisation/README.en.md)
