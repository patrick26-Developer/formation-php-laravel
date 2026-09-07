# Exercises — 06.5 Migrations, Seeders, Factories

## Exercise 1 — First migration (easy)

Create a migration for a `categories` table (`nom`, `slug` unique). Run it with `php artisan migrate` and check the table created in the database.

## Exercise 2 — Relationship and constraint (easy)

Create a `produits` migration with `categorie_id` as a foreign key to `categories`, `ON DELETE CASCADE`. Test deleting a category that has linked products.

## Exercise 3 — Realistic factory (medium)

Create a `ProduitFactory` generating a name (`fake()->words(3, true)`), a price (`fake()->randomFloat(2, 5, 500)`), a stock (`fake()->numberBetween(0, 100)`). Generate 30 products via Tinker.

## Exercise 4 — Seeder with relationships (medium)

Create a `CategorieSeeder` that creates 5 categories, then, for each one, 10 linked products (`Produit::factory()->count(10)->for($categorie)->create()`). Register it in `DatabaseSeeder` and run `migrate:fresh --seed`.

## Exercise 5 — Rollback and schema change (hard)

After migrating `produits`, create a **new** migration that adds a `disponible` column (boolean, default `true`) to the existing table (never edit a migration that's already run in production). Migrate, then test `migrate:rollback` to check the column is correctly removed by the `down()` method.

---

See [solutions/README.md](solutions/README.md) for the answer key.
