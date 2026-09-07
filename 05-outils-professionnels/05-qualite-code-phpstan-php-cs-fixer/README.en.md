# 05.5 — Code Quality: PHPStan and PHP-CS-Fixer

> **Status:** ✅ Available

## 🎯 Objectives

- Install and configure PHP-CS-Fixer to automatically apply PSR-12.
- Install and configure PHPStan to detect bugs without running the code.
- Understand PHPStan's analysis levels.
- Integrate both tools into the CI/CD pipeline.

## 📋 Prerequisites

[05.4 — GitHub Actions: CI/CD Fundamentals](../04-github-actions-ci-cd-fondamentaux/README.en.md) and [03.5 — Best Practices, PSR-12, Clean Code](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### PHP-CS-Fixer: automatic formatting

Introduced in [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md), let's now look at its full configuration.

```bash
composer require --dev friendsofphp/php-cs-fixer
```

`.php-cs-fixer.php` configuration file at the project root:

```php
<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'], // enforces [] rather than array()
        'no_unused_imports' => true,               // removes unused "use" statements
        'ordered_imports' => true,                   // sorts "use" statements alphabetically
        'trailing_comma_in_multiline' => true,         // trailing comma on multi-line arrays
    ])
    ->setFinder($finder);
```

```bash
./vendor/bin/php-cs-fixer fix           # automatically fixes files
./vendor/bin/php-cs-fixer fix --dry-run --diff  # shows what would be fixed, without modifying (for CI)
```

### PHPStan: detecting bugs without running the code

**PHPStan** is a **static analysis** tool: it reads your code without running it and detects type inconsistencies, calls to non-existent methods, unchecked potentially-`null` variables, and more.

```bash
composer require --dev phpstan/phpstan
```

```php
<?php
declare(strict_types=1);

function findUser(int $id): ?array {
    // ... may return null if not found ...
    return null;
}

$user = findUser(5);
echo $user['name']; // PHPStan reports: "Cannot access offset 'name' on array|null"
```

Without PHPStan, this bug would only be discovered at runtime (if `findUser` actually returns `null` one day). PHPStan catches it **before the code is even run**.

### Analysis levels

PHPStan offers increasing levels of strictness, from `0` (basic checks) to `9` (the strictest):

```neon
# phpstan.neon
parameters:
    level: 5
    paths:
        - src
```

```bash
./vendor/bin/phpstan analyse
```

> 📌 Practical advice: start a **new** project directly at level 6-8. On an **existing** project with no prior static analysis, start at level 0-2 and increase gradually to avoid being overwhelmed by hundreds of errors at once.

### Example of typical errors caught

```php
<?php
declare(strict_types=1);

class TacheRepository {
    public function trouver(int $id): ?array {
        // ...
    }
}

$repository = new TacheRepository();
$task = $repository->trouver(1);

echo $task['titre'];
// PHPStan (level 5+): "Cannot access offset 'titre' on array|null."
// -> forces an explicit check: if ($task !== null) { ... }

$repository->modifer(1); // typo: "modifer" instead of "modifier"
// PHPStan: "Call to an undefined method TacheRepository::modifer()."
// -> caught WITHOUT running the code, whereas a typo in a lightly-tested
// code path could otherwise remain invisible for a long time.
```

### Integrating both tools into the CI pipeline (module 05.4)

```yaml
      - name: Check PSR-12 style
        run: ./vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: PHPStan static analysis
        run: ./vendor/bin/phpstan analyse
```

> 📌 With these two steps in the pipeline, no code that violates the style guide or contains a detectable type inconsistency can be merged into `main` without CI failing — an automated quality guarantee, independent of individual vigilance in code review.

## ✅ Key takeaways

- PHP-CS-Fixer automatically fixes **style** (spacing, PSR-12) — never logic.
- PHPStan detects **type and logic inconsistencies** without running the code, at increasing levels of strictness (0 to 9).
- Start a fresh project at a high PHPStan level; increase it gradually on an existing project.
- These two tools, integrated into CI (`--dry-run` for one, `analyse` for the other), automate a significant part of code review.

## ➡️ Going further

- [phpstan.org](https://phpstan.org/)
- [cs.symfony.com](https://cs.symfony.com/) (PHP-CS-Fixer documentation)
- [Module 14.2 — Code Review and Refactoring](../../14-preparation-professionnelle/02-code-review-et-refactoring/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [05.4 — GitHub Actions: CI/CD Fundamentals](../04-github-actions-ci-cd-fondamentaux/README.en.md) · **Next:** [Level 06 — Laravel Fundamentals](../../06-laravel-fondamentaux/README.en.md)
