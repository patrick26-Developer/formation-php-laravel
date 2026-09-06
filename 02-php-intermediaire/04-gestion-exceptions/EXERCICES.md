# Exercices — 02.4 Gestion des exceptions

## Exercice 1 — Exception personnalisée simple (facile)

Créez une classe `AgeInvalideException extends Exception`. Écrivez une fonction `validerAge(int $age): int` qui lève cette exception (avec un message clair) si l'âge n'est pas entre 0 et 150. Testez avec plusieurs valeurs dans un `try`/`catch`.

## Exercice 2 — Exception avec données structurées (moyen)

Créez `StockInsuffisantException extends Exception` qui stocke `stockDisponible` et `quantiteDemandee` (via constructeur), avec des getters. Une classe `Stock` avec une méthode `retirer(int $quantite): void` doit la lever si la quantité demandée dépasse le stock. Dans le `catch`, affichez un message utilisant les getters de l'exception (pas seulement `getMessage()`).

## Exercice 3 — Plusieurs types de catch (moyen)

Écrivez une fonction `traiterCommande(int $quantite, float $prix): float` qui lève une `InvalidArgumentException` si `$quantite <= 0`, une `RuntimeException` si `$prix <= 0`, et retourne `$quantite * $prix` sinon. Appelez-la trois fois (cas valide, quantité invalide, prix invalide) avec des blocs `catch` séparés pour chaque type.

## Exercice 4 — Exceptions enchaînées (difficile)

Simulez une fonction `chargerConfiguration(): array` qui lève une `RuntimeException("Fichier de configuration introuvable")`. Dans une fonction `demarrerApplication(): void`, capturez cette exception et relancez-en une nouvelle `Exception("Impossible de démarrer l'application", 0, $exceptionOriginale)`. Dans le code appelant, affichez le message de l'exception ET celui de sa cause (`getPrevious()`).

## Exercice 5 — Système de validation complet (difficile)

Créez une classe `ValidationException extends Exception` qui stocke un tableau d'erreurs (`array $erreurs`). Écrivez une fonction `validerFormulaire(array $donnees): void` qui vérifie `nom` (non vide), `email` (format valide), `age` (numérique, 18-120), accumule **toutes** les erreurs trouvées (pas seulement la première) dans un tableau, et lève une seule `ValidationException` à la fin si des erreurs existent. Affichez toutes les erreurs dans le `catch`.

---

Comparez avec [solutions/](solutions/) une fois terminé.
