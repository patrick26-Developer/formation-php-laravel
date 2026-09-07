# Exercises — 03.3 Unit Testing with PHPUnit

> These exercises require `composer require --dev phpunit/phpunit` in a small Composer project (see [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md)).

## Exercise 1 — First tests (easy)

Reuse the lesson's `Calculatrice` class. Write tests for `additionner()` covering: two positives, a negative and a positive, two negatives. Use `assertSame()`.

## Exercise 2 — Testing an exception (easy)

For the `diviser()` method, write a test that checks a division by zero correctly throws an `InvalidArgumentException`, and another that checks a valid division returns the correct result.

## Exercise 3 — Testing a stateful class (medium)

Reuse the `CompteBancaire` class from [module 02.1](../../02-php-intermediaire/01-poo-bases/README.en.md). Write tests for: a deposit that correctly increases the balance, a valid withdrawal that decreases the balance, an excessive withdrawal that throws an exception (the balance must then NOT have changed — test that too).

## Exercise 4 — `setUp()` to avoid repetition (medium)

Rewrite exercise 3's tests using a `setUp(): void` method (automatically called by PHPUnit before each test) to create a fresh `CompteBancaire` instance shared across tests, instead of recreating it in every test method.

## Exercise 5 — Mocking a dependency (hard)

Create a `ServiceEmail` class with a method `envoyer(string $destinataire, string $message): bool` (simulate an actual send, for example by writing to an array or returning `true`). Create an `InscriptionService` class that takes a `ServiceEmail` in its constructor, and a method `inscrire(string $email): void` that calls `envoyer()` with a welcome message. Write a test that uses `createMock()` to verify `envoyer()` is called with the correct arguments, without ever using a real `ServiceEmail`.

---

Compare with [solutions/](solutions/) once done.
