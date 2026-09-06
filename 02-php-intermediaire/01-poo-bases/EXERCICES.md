# Exercices — 02.1 POO : les bases

## Exercice 1 — Ma première classe (facile)

Créez une classe `Livre` avec les propriétés `titre`, `auteur`, `annee` (privées, via constructeur promu), et une méthode publique `presenter(): string` qui retourne `"Titre (Auteur, Année)"`. Instanciez deux livres et affichez leur présentation.

## Exercice 2 — Encapsulation (facile)

Créez une classe `Thermometre` avec une propriété privée `temperature` (float), un constructeur qui l'initialise, une méthode `getTemperature(): float`, et une méthode `augmenter(float $degres): void` qui ajoute des degrés. Empêchez toute modification directe de `temperature` depuis l'extérieur de la classe.

## Exercice 3 — Compte bancaire avec règles métier (moyen)

Créez une classe `CompteBancaire` avec `solde` privé, une méthode `deposer(float $montant): void`, et une méthode `retirer(float $montant): void` qui lève une `Exception` si le retrait dépasse le solde disponible. Testez les deux cas (retrait valide et retrait refusé).

## Exercice 4 — `readonly` en pratique (moyen)

Créez une classe `Coordonnees` avec deux propriétés `readonly` (`latitude`, `longitude`). Instanciez un objet, affichez ses valeurs, puis tentez de les modifier après création — observez et notez l'erreur obtenue.

## Exercice 5 — Panier d'achat (difficile)

Créez une classe `Panier` avec une propriété privée `articles` (tableau, initialisé vide), une méthode `ajouterArticle(string $nom, float $prix): void`, une méthode `calculerTotal(): float` (utilisez `array_reduce` ou une boucle sur `articles`), et une méthode `nombreArticles(): int`. Testez en ajoutant plusieurs articles et en affichant le total.

---

Comparez avec [solutions/](solutions/) une fois terminé.
