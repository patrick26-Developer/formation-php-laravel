# Exercises — 03.1 Design Patterns in PHP

## Exercise 1 — Shape factory (easy)

Reuse the `Rectangle`, `Cercle`, `Triangle` classes from [module 02.2](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.en.md). Create a `FormeFactory::creer(string $type, array $parametres): FormeGeometrique` that instantiates the right class based on `$type` (`'rectangle'`, `'cercle'`, `'triangle'`).

## Exercise 2 — Sorting Strategy (easy)

Create a `StrategieTri` interface with a method `trier(array $donnees): array`. Implement `TriAlphabetique` and `TriParLongueur` (sorts strings by ascending length). A `ListeMots` class takes a strategy in its constructor and uses it in a method `obtenirTriee(array $mots): array`.

## Exercise 3 — Observer for a rating system (medium)

Create a `GestionnaireAvis` (the subject) with a method `ajouterAvis(int $note): void` that notifies its observers. Create an observer `CalculMoyenneObservateur` that keeps a running average updated on every new review, and an `AlerteAvisNegatifObservateur` that displays an alert if the rating is below 2 (out of 5).

## Exercise 4 — Factory + Strategy combined (medium)

Combine the first two exercises: a `NotificationFactory::creer(string $canal): StrategieNotification` (channel = 'email' or 'sms', each strategy implementing `envoyer(string $message): string`). Use the factory to create and use a strategy based on a variable.

## Exercise 5 — Repository with an injected sorting Strategy (hard)

Reuse `LivreRepository` from [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md). Instead of a `string $tri` parameter, inject a `CritereTri` interface with a method `versSql(): string` (returning, for example, `"annee DESC"`), validated upstream. Implement `TriParAnnee` and `TriParTitre`. Explain in a comment the advantage (or downside) of this approach compared to module 02.9's simple whitelist.

---

Compare with [solutions/](solutions/README.en.md) once done.
