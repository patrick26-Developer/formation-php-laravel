# Exercises — 05.5 Code Quality

## Exercise 1 — Configuring PHP-CS-Fixer (easy)

In a small Composer project, install PHP-CS-Fixer, create a `.php-cs-fixer.php` with the lesson's rules, deliberately misformat a PHP file (bad indentation, `array()` instead of `[]`), then run `fix` and observe the corrections.

## Exercise 2 — Configuring PHPStan at a low level (easy)

Install PHPStan, create `phpstan.neon` with `level: 0`, analyze a file containing an obvious type error, and observe the message.

## Exercise 3 — Detecting a call to a non-existent method (medium)

Create a class with a method `calculerTotal(): float`. In another file, call it with a typo (`calculerTtal()`). Run PHPStan and check it detects the error without executing the code.

## Exercise 4 — Gradually raising the level (medium)

On the [Level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md), run PHPStan at levels 0, 3, 6, and 8 successively on the `src/` folder. Note how many errors appear at each level, and fix at least one error detected at an intermediate level.

## Exercise 5 — Integrating both tools into CI (hard)

Add two extra steps to the GitHub Actions workflow from [module 05.4, exercise 2](../04-github-actions-ci-cd-fondamentaux/EXERCICES.en.md): a PHP-CS-Fixer check (`--dry-run`) and a PHPStan analysis. Push a commit with non-compliant style and verify the CI correctly fails at this precise step (not just on the tests).

---

Compare with [solutions/](solutions/README.en.md) once done.
