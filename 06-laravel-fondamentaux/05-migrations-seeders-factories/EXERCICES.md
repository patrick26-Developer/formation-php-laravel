# Exercices — 06.5 Migrations, seeders, factories

## Exercice 1 — Première migration (facile)

Créez une migration pour une table `categories` (`nom`, `slug` unique). Exécutez-la avec `php artisan migrate` et vérifiez la table créée en base.

## Exercice 2 — Relation et contrainte (facile)

Créez une migration `produits` avec `categorie_id` en clé étrangère vers `categories`, `ON DELETE CASCADE`. Testez la suppression d'une catégorie ayant des produits liés.

## Exercice 3 — Factory réaliste (moyen)

Créez une factory `ProduitFactory` générant un nom (`fake()->words(3, true)`), un prix (`fake()->randomFloat(2, 5, 500)`), un stock (`fake()->numberBetween(0, 100)`). Générez 30 produits via Tinker.

## Exercice 4 — Seeder avec relations (moyen)

Créez un `CategorieSeeder` qui crée 5 catégories, puis, pour chacune, 10 produits liés (`Produit::factory()->count(10)->for($categorie)->create()`). Enregistrez-le dans `DatabaseSeeder` et exécutez `migrate:fresh --seed`.

## Exercice 5 — Rollback et modification de schéma (difficile)

Après avoir migré `produits`, créez une **nouvelle** migration qui ajoute une colonne `disponible` (boolean, défaut `true`) à la table existante (n'éditez jamais une migration déjà exécutée en production). Migrez, puis testez `migrate:rollback` pour vérifier que la colonne est bien retirée par la méthode `down()`.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
