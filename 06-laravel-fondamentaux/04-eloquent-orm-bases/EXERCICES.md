# Exercices — 06.4 Eloquent ORM : les bases

## Exercice 1 — Premier modèle (facile)

Créez un modèle `Produit` (`nom`, `prix`, `stock`) avec `$fillable` correctement défini. Via Tinker, créez 3 produits avec `Produit::create()`.

## Exercice 2 — CRUD via Tinker (facile)

Via Tinker : récupérez tous les produits (`all()`), trouvez-en un par ID, modifiez son prix et sauvegardez, puis supprimez-en un.

## Exercice 3 — Query Builder (moyen)

Via Tinker : trouvez tous les produits dont le stock est supérieur à 0, triés par prix décroissant. Comptez le nombre de produits en rupture de stock (`stock = 0`).

## Exercice 4 — `$casts` (moyen)

Ajoutez une colonne `disponible` (boolean) à `Produit`. Configurez `$casts` pour la traiter comme un booléen. Vérifiez via Tinker que `$produit->disponible` retourne bien `true`/`false` (pas `1`/`0`).

## Exercice 5 — Comparer avec le Repository du niveau 02 (difficile)

Reprenez `TacheRepository::creer()`, `trouver()`, `modifier()`, `supprimer()` du [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md). Réécrivez chaque méthode comme une méthode statique équivalente utilisant Eloquent, dans un fichier `EloquentEquivalent.md`, avec le SQL original à côté pour comparaison ligne à ligne.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
