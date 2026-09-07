# Exercises — 02.1 OOP: The Basics

## Exercise 1 — My first class (easy)

Create a `Livre` class with `titre`, `auteur`, `annee` properties (private, via promoted constructor), and a public method `presenter(): string` that returns `"Title (Author, Year)"`. Instantiate two books and print their presentation.

## Exercise 2 — Encapsulation (easy)

Create a `Thermometre` class with a private `temperature` property (float), a constructor that initializes it, a `getTemperature(): float` method, and an `augmenter(float $degres): void` method that adds degrees. Prevent any direct modification of `temperature` from outside the class.

## Exercise 3 — Bank account with business rules (medium)

Create a `CompteBancaire` class with a private `solde`, a `deposer(float $montant): void` method, and a `retirer(float $montant): void` method that throws an `Exception` if the withdrawal exceeds the available balance. Test both cases (valid withdrawal and refused withdrawal).

## Exercise 4 — `readonly` in practice (medium)

Create a `Coordonnees` class with two `readonly` properties (`latitude`, `longitude`). Instantiate an object, print its values, then try to modify them after creation — observe and note the error you get.

## Exercise 5 — Shopping cart (hard)

Create a `Panier` class with a private `articles` property (array, initialized empty), a method `ajouterArticle(string $nom, float $prix): void`, a method `calculerTotal(): float` (use `array_reduce` or a loop over `articles`), and a method `nombreArticles(): int`. Test it by adding several items and printing the total.

---

Compare with [solutions/](solutions/) once done.
