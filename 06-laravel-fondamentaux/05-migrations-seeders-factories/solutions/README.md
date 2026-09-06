# Solutions — 06.5 Migrations, seeders, factories

## Exercice 1

```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('nom');
    $table->string('slug')->unique();
    $table->timestamps();
});
```
```bash
php artisan migrate
```

## Exercice 2

```php
Schema::create('produits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('categorie_id')->constrained()->cascadeOnDelete();
    $table->string('nom');
    $table->decimal('prix', 10, 2);
    $table->timestamps();
});
```
Supprimer une catégorie ayant des produits liés (`Categorie::find(1)->delete()`) supprime automatiquement ses produits — comportement `cascadeOnDelete()`.

## Exercice 3

```php
class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->words(3, true),
            'prix' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
```
```php
// Tinker
Produit::factory()->count(30)->create();
```

## Exercice 4

```php
class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        Categorie::factory()->count(5)->create()->each(function ($categorie) {
            Produit::factory()->count(10)->for($categorie)->create();
        });
    }
}
```
```php
// DatabaseSeeder.php
public function run(): void
{
    $this->call([CategorieSeeder::class]);
}
```
```bash
php artisan migrate:fresh --seed
```

## Exercice 5

```bash
php artisan make:migration add_disponible_to_produits_table --table=produits
```
```php
public function up(): void
{
    Schema::table('produits', function (Blueprint $table) {
        $table->boolean('disponible')->default(true);
    });
}

public function down(): void
{
    Schema::table('produits', function (Blueprint $table) {
        $table->dropColumn('disponible');
    });
}
```
```bash
php artisan migrate            # ajoute la colonne
php artisan migrate:rollback     # exécute down() : la colonne "disponible" disparaît
```
Principe important : on ne modifie **jamais** une migration déjà exécutée en production (elle a déjà "eu lieu" dans l'historique) — toute évolution de schéma passe par une **nouvelle** migration, exactement comme on ne réécrit jamais un commit Git déjà poussé et partagé (module 05.1).
