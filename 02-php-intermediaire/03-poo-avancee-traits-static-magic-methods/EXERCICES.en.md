# Exercises — 02.3 Advanced OOP: Traits, Static, Magic Methods

## Exercise 1 — `Loggable` trait (easy)

Create a `Loggable` trait with a method `log(string $message): void` that prints `"[ClassName] $message"` (use `static::class` to get the using class's name). Use this trait in two different classes (`ServiceEmail`, `ServicePaiement`) and test it.

## Exercise 2 — Instance counter (easy)

Create a `Produit` class with a static property `$nombreCrees` (int, initialized to 0), incremented in the constructor on every new instance. Add a static method `getNombreCrees(): int`. Create 3 products and print the total.

## Exercise 3 — `__toString` for a business object (medium)

Create an `Adresse` class (street, postal code, city) with a `__toString()` method that returns a formatted one-line address (`"12 rue des Lilas, 69000 Lyon"`). Print the object directly with `echo`.

## Exercise 4 — `Role` enum with permissions (medium)

Create a `Role` enum (`Admin`, `Editeur`, `Lecteur`) with a method `peutModifier(): bool` (true for Admin and Editeur, false for Lecteur) and a method `libelle(): string`. Test all three cases with a `foreach` over `Role::cases()`.

## Exercise 5 — `JournalApplication` Singleton (hard)

Implement a `JournalApplication` Singleton with a method `ajouterEntree(string $message): void` that stores messages in an internal array, and `getEntrees(): array` to retrieve them. Call `JournalApplication::getInstance()` from two different places in the script, add entries via each reference, and prove they share the same state (a single instance).

---

Compare with [solutions/](solutions/) once done.
