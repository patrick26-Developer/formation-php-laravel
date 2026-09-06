# Exercices — 02.3 POO avancée : traits, static, méthodes magiques

## Exercice 1 — Trait `Loggable` (facile)

Créez un trait `Loggable` avec une méthode `log(string $message): void` qui affiche `"[NomDeLaClasse] $message"` (utilisez `static::class` pour obtenir le nom de la classe utilisatrice). Utilisez ce trait dans deux classes différentes (`ServiceEmail`, `ServicePaiement`) et testez.

## Exercice 2 — Compteur d'instances (facile)

Créez une classe `Produit` avec une propriété statique `$nombreCrees` (int, initialisée à 0), incrémentée dans le constructeur à chaque nouvelle instance. Ajoutez une méthode statique `getNombreCrees(): int`. Créez 3 produits et affichez le total.

## Exercice 3 — `__toString` pour un objet métier (moyen)

Créez une classe `Adresse` (rue, codePostal, ville) avec une méthode `__toString()` qui retourne une adresse formatée sur une ligne (`"12 rue des Lilas, 69000 Lyon"`). Affichez directement l'objet avec `echo`.

## Exercice 4 — Enum `Role` avec permissions (moyen)

Créez un enum `Role` (`Admin`, `Editeur`, `Lecteur`) avec une méthode `peutModifier(): bool` (true pour Admin et Editeur, false pour Lecteur) et une méthode `libelle(): string`. Testez les trois cas avec un `foreach` sur `Role::cases()`.

## Exercice 5 — Singleton `JournalApplication` (difficile)

Implémentez un Singleton `JournalApplication` avec une méthode `ajouterEntree(string $message): void` qui stocke les messages dans un tableau interne, et `getEntrees(): array` pour les récupérer. Appelez `JournalApplication::getInstance()` depuis deux endroits différents du script, ajoutez des entrées via chaque référence, et prouvez qu'elles partagent bien le même état (une seule instance).

---

Comparez avec [solutions/](solutions/) une fois terminé.
