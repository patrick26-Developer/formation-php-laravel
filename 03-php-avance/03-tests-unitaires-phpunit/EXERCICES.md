# Exercices — 03.3 Tests unitaires avec PHPUnit

> Ces exercices nécessitent `composer require --dev phpunit/phpunit` dans un petit projet Composer (voir [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md)).

## Exercice 1 — Premiers tests (facile)

Reprenez la classe `Calculatrice` du cours. Écrivez des tests pour `additionner()` couvrant : deux positifs, un négatif et un positif, deux négatifs. Utilisez `assertSame()`.

## Exercice 2 — Tester une exception (facile)

Pour la méthode `diviser()`, écrivez un test qui vérifie qu'une division par zéro lève bien une `InvalidArgumentException`, et un autre qui vérifie qu'une division valide retourne le bon résultat.

## Exercice 3 — Tester une classe avec état (moyen)

Reprenez la classe `CompteBancaire` du [module 02.1](../../02-php-intermediaire/01-poo-bases/README.md). Écrivez des tests pour : un dépôt qui augmente bien le solde, un retrait valide qui diminue le solde, un retrait excessif qui lève une exception (le solde ne doit alors PAS avoir changé — testez-le aussi).

## Exercice 4 — `setUp()` pour éviter la répétition (moyen)

Réécrivez les tests de l'exercice 3 en utilisant une méthode `setUp(): void` (appelée automatiquement par PHPUnit avant chaque test) pour créer une instance fraîche de `CompteBancaire` partagée entre les tests, plutôt que de la recréer dans chaque méthode de test.

## Exercice 5 — Mock d'une dépendance (difficile)

Créez une classe `ServiceEmail` avec une méthode `envoyer(string $destinataire, string $message): bool` (simulez un envoi réel, par exemple en écrivant dans un tableau ou en retournant `true`). Créez une classe `InscriptionService` qui prend un `ServiceEmail` en constructeur, et une méthode `inscrire(string $email): void` qui appelle `envoyer()` avec un message de bienvenue. Écrivez un test qui utilise `createMock()` pour vérifier que `envoyer()` est bien appelée avec les bons arguments, sans jamais utiliser un vrai `ServiceEmail`.

---

Comparez avec [solutions/](solutions/) une fois terminé.
