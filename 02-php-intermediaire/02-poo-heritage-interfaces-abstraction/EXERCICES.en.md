# Exercises — 02.2 Inheritance, Interfaces, Abstraction

## Exercise 1 — Vehicle hierarchy (easy)

Create a `Vehicule` class (a `marque` property, a `demarrer(): string` method). Create `Voiture` and `Moto` that inherit from it, each adding a specific method (`ouvrirCoffre()` for Voiture, `fairePetPet()` for Moto). Instantiate both and call all their methods.

## Exercise 2 — `parent::` (easy)

Reuse `Vehicule` with a `demarrer(): string` method that returns `"$marque démarre."`. In `Voiture`, override `demarrer()` so it calls the parent version then appends `" Vérification de la ceinture."`.

## Exercise 3 — `Notifiable` interface (medium)

Create a `Notifiable` interface with a method `envoyerNotification(string $message): string`. Implement it in two classes, `Email` and `SMS`, each formatting the message differently (`"Email sent: ..."` / `"SMS sent: ..."`). Write a function `notifierTous(array $canaux, string $message): void` that accepts an array of `Notifiable` objects and calls their method.

## Exercise 4 — Abstract `Employe` class (medium)

Create an abstract `Employe` class with a `nom` property, an abstract method `calculerSalaire(): float`, and a concrete method `presenter(): string` that uses `calculerSalaire()`. Create `EmployeFixe` (fixed monthly salary) and `EmployeCommission` (base salary + a percentage of a sales amount).

## Exercise 5 — Shape system with polymorphism (hard)

Reuse the lesson's `FormeGeometrique` example, add a `Triangle` class (base, height), then write a function `calculerAireTotale(array $formes): float` that accepts an array mixing `Rectangle`, `Cercle`, and `Triangle`, and returns the sum of all their areas — without ever checking each element's concrete type.

---

Compare with [solutions/](solutions/README.en.md) once done.
