# Solutions — 06.5 Migrations, Seeders, Factories

## Exercise 1

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

## Exercise 2

```php
Schema::create('produits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('categorie_id')->constrained()->cascadeOnDelete();
    $table->string('nom');
    $table->decimal('prix', 10, 2);
    $table->timestamps();
});
```
Deleting a category that has linked products (`Categorie::find(1)->delete()`) automatically deletes its products — the `cascadeOnDelete()` behavior.

## Exercise 3

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

## Exercise 4

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

## Exercise 5

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
php artisan migrate            # adds the column
php artisan migrate:rollback     # runs down(): the "disponible" column disappears
```
Important principle: a migration that has already run in production is **never** modified (it has already "happened" in the history) — any schema change goes through a **new** migration, exactly like a Git commit that's already been pushed and shared is never rewritten (module 05.1).
