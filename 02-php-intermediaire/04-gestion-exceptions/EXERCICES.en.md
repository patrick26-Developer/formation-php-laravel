# Exercises — 02.4 Exception Handling

## Exercise 1 — Simple custom exception (easy)

Create a class `AgeInvalideException extends Exception`. Write a function `validerAge(int $age): int` that throws this exception (with a clear message) if the age isn't between 0 and 150. Test it with several values inside a `try`/`catch`.

## Exercise 2 — Exception with structured data (medium)

Create `StockInsuffisantException extends Exception` that stores `stockDisponible` and `quantiteDemandee` (via the constructor), with getters. A `Stock` class with a `retirer(int $quantite): void` method must throw it if the requested quantity exceeds the stock. In the `catch`, print a message using the exception's getters (not just `getMessage()`).

## Exercise 3 — Several catch types (medium)

Write a function `traiterCommande(int $quantite, float $prix): float` that throws an `InvalidArgumentException` if `$quantite <= 0`, a `RuntimeException` if `$prix <= 0`, and otherwise returns `$quantite * $prix`. Call it three times (valid case, invalid quantity, invalid price) with separate `catch` blocks for each type.

## Exercise 4 — Chained exceptions (hard)

Simulate a function `chargerConfiguration(): array` that throws a `RuntimeException("Configuration file not found")`. In a function `demarrerApplication(): void`, catch this exception and throw a new one, `Exception("Unable to start the application", 0, $exceptionOriginale)`. In the calling code, print the exception's message AND its cause's (`getPrevious()`).

## Exercise 5 — Complete validation system (hard)

Create a class `ValidationException extends Exception` that stores an array of errors (`array $erreurs`). Write a function `validerFormulaire(array $donnees): void` that checks `nom` (not empty), `email` (valid format), `age` (numeric, 18-120), accumulates **all** errors found (not just the first) into an array, and throws a single `ValidationException` at the end if any errors exist. Print all errors in the `catch`.

---

Compare with [solutions/](solutions/) once done.
