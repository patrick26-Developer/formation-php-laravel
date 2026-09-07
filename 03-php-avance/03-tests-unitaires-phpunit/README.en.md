# 03.3 — Unit Testing with PHPUnit

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the value of automated tests.
- Install and configure PHPUnit in a project.
- Write unit tests with assertions.
- Use test doubles (mocks) to isolate a unit of code.

## 📋 Prerequisites

[03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.en.md) and [02.7 — Composer, Autoloading, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Why test automatically?

Until now, you've verified your code "by hand": run a script, look at the result, compare it to what was expected. This approach doesn't scale: every future code change forces you to manually re-verify everything. An **automated test** encodes this verification once and for all, and can be replayed in a second, on every change — this is what makes **CI/CD** possible ([level 05](../../05-outils-professionnels/README.md) and [11](../../11-devops-docker-cicd-avance/README.md)): automatically verifying your code on every push to GitHub.

### Installing PHPUnit

```bash
composer require --dev phpunit/phpunit
```

> 📌 `--dev` indicates that PHPUnit is only needed in development, never in production — Composer separates these two categories of dependencies.

Typical structure:
```
my-project/
├── composer.json
├── src/
│   └── Calculator.php
└── tests/
    └── CalculatorTest.php
```

### Writing a first test

```php
<?php
declare(strict_types=1);

namespace App;

class Calculator {
    public function add(int $a, int $b): int {
        return $a + $b;
    }

    public function divide(float $a, float $b): float {
        if ($b === 0.0) {
            throw new \InvalidArgumentException("Cannot divide by zero.");
        }

        return $a / $b;
    }
}
```

```php
<?php
declare(strict_types=1);

namespace App\Tests;

use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    public function testAddTwoPositiveNumbers(): void {
        $calculator = new Calculator();

        $result = $calculator->add(2, 3);

        $this->assertSame(5, $result);
    }

    public function testDivideByZeroThrowsAnException(): void {
        $calculator = new Calculator();

        $this->expectException(\InvalidArgumentException::class);

        $calculator->divide(10, 0);
    }
}
```

Running the tests:
```bash
./vendor/bin/phpunit tests
```

### The most common assertions

| Assertion | Checks that... |
|---|---|
| `assertSame($expected, $actual)` | The two values are identical (type AND value, equivalent to `===`) |
| `assertEquals($expected, $actual)` | The two values are equal (equivalent to `==`, looser) |
| `assertTrue($value)` / `assertFalse($value)` | The value is indeed `true`/`false` |
| `assertNull($value)` | The value is `null` |
| `assertCount($number, $array)` | An array contains exactly this number of elements |
| `assertInstanceOf($class, $object)` | The object is indeed an instance of this class |

> 📌 Prefer `assertSame()` over `assertEquals()` by default: strict comparison avoids false positives (for example, `assertEquals(1, "1")` passes, even though these are two different types).

### The AAA structure (Arrange, Act, Assert)

A good practice for structuring every test, even without explicit comments:

```php
<?php
public function testCreateATask(): void {
    // Arrange: set up the test context
    $repository = new InMemoryTaskRepository();

    // Act: run the action under test
    $id = $repository->creer("Buy groceries");

    // Assert: check the result
    $this->assertNotNull($repository->trouver($id));
}
```

### Isolating a unit of code with mocks

A **unit test** should test a single unit of code, **isolated** from its dependencies (database, network calls...). PHPUnit provides "stand-in" objects (mocks) to simulate these dependencies.

```php
<?php
declare(strict_types=1);

namespace App\Tests;

use App\NotificationService;
use App\EmailSender;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase {
    public function testSendsAWelcomeNotificationByEmail(): void {
        // We create a "fake" EmailSender, never sending a REAL email
        $mockSender = $this->createMock(EmailSender::class);

        // We define what we EXPECT from this dependency: that it be
        // called exactly once, with these specific arguments.
        $mockSender->expects($this->once())
            ->method('send')
            ->with('alice@example.com', 'Welcome!');

        $service = new NotificationService($mockSender);
        $service->notifyWelcome('alice@example.com');
    }
}
```

> 💡 The benefit: this test verifies `NotificationService`'s **behavior** (does it correctly call the sender?) without ever sending a real email — fast, reliable, reproducible, with no side effects.

## ✅ Key takeaways

- An automated test encodes a check once and for all, replayable at will.
- AAA structure: Arrange (set up), Act (act), Assert (verify).
- `assertSame()` by default, stricter and safer than `assertEquals()`.
- A mock isolates a unit of code from its external dependencies for a true **unit** test.

## ➡️ Going further

- [phpunit.de/documentation.html](https://phpunit.de/documentation.html)
- [Module 08.3 — Testing with Pest and PHPUnit in Laravel](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md) *(French only)*
- [Module 05.4 — GitHub Actions: CI/CD Fundamentals](../../05-outils-professionnels/04-github-actions-ci-cd-fondamentaux/README.md) *(French only)* (running these tests automatically on every push)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.en.md) · **Next:** [03.4 — Building a REST API in Native PHP](../04-construction-api-rest-php-natif/README.en.md)
