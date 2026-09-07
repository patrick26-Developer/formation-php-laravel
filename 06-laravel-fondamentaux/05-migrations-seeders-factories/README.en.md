# 06.5 — Migrations, Seeders, Factories

> **Status:** ✅ Available

## 🎯 Objectives

- Version a database schema with migrations.
- Define relationships and constraints in a migration.
- Generate realistic test data with factories.
- Populate the database with seeders.

## 📋 Prerequisites

[06.4 — Eloquent ORM: The Basics](../04-eloquent-orm-bases/README.en.md), [04.1 — Relational Modeling](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Why migrations?

A **migration** is a PHP file describing a database schema change, timestamped and version-controlled alongside the code. It's the equivalent of the `CREATE TABLE` statements you hand-wrote in [modules 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) and [04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.en.md), but **version-controlled in Git** and **runnable in order** on any machine (a colleague's, a production server) — no more need to separately share a `schema.sql` file.

```bash
php artisan make:migration create_taches_table
```

```php
// database/migrations/xxxx_xx_xx_create_taches_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->boolean('terminee')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
```

> 📌 `foreignId('user_id')->constrained()->cascadeOnDelete()` automatically generates a foreign key to `users.id` with `ON DELETE CASCADE` — exactly the constraint you hand-wrote in [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) (`FOREIGN KEY ... ON DELETE CASCADE`).

### Migration commands

```bash
php artisan migrate               # runs all pending migrations (calls up())
php artisan migrate:rollback        # undoes the last "batch" of migrations (calls down())
php artisan migrate:fresh             # drops ALL tables and replays every migration from scratch
php artisan migrate:status              # lists executed or pending migrations
```

> ⚠️ `migrate:fresh` **deletes all data**. Reserve it for local development, never production.

### Common column types

```php
$table->id();                          // auto-incrementing primary key (BIGINT UNSIGNED)
$table->string('titre', 150);           // VARCHAR(150)
$table->text('description');             // TEXT
$table->integer('quantite');               // INT
$table->decimal('prix', 10, 2);              // DECIMAL(10,2) — for money (recall module 04.3)
$table->boolean('terminee')->default(false);   // BOOLEAN
$table->date('date_naissance');                  // DATE
$table->timestamp('publie_le')->nullable();        // TIMESTAMP, can be NULL
$table->timestamps();                                // automatic created_at + updated_at
$table->softDeletes();                                 // deleted_at, for soft deletes (level 07)
```

### Factories: generating realistic fake data

```bash
php artisan make:factory TacheFactory --model=Tache
```

```php
// database/factories/TacheFactory.php
class TacheFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'terminee' => fake()->boolean(20), // 20% chance of being true
        ];
    }
}
```

```php
// Via Tinker
Tache::factory()->count(50)->create();          // creates 50 tasks with realistic data
Tache::factory()->create(['terminee' => true]);  // overrides a specific field
```

> 💡 `fake()` (based on the Faker library) generates realistic names, sentences, emails, dates — far more convenient than the generic `"Test task $i"` you would have hand-written.

### Seeders: populating the database for development

```bash
php artisan make:seeder TacheSeeder
```

```php
// database/seeders/TacheSeeder.php
class TacheSeeder extends Seeder
{
    public function run(): void
    {
        Tache::factory()->count(20)->create();
    }
}
```

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    $this->call([
        TacheSeeder::class,
    ]);
}
```

```bash
php artisan db:seed                # runs DatabaseSeeder (which calls the registered seeders)
php artisan migrate:fresh --seed     # combines migrate:fresh + db:seed into one command
```

> 📌 This is the professional equivalent of the hand-written `seed.php` from the [level 02 mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md) — except here, a single command recreates a complete development environment, with dozens of realistic records, reproducibly for the whole team.

## ✅ Key takeaways

- A migration versions the database schema in Git, runnable in order on any machine.
- `foreignId()->constrained()->cascadeOnDelete()` automatically generates referential integrity constraints.
- A factory generates realistic test data; a seeder orchestrates their creation to populate the database.
- `migrate:fresh --seed` recreates a complete development environment in a single command.

## ➡️ Going further

- [laravel.com/docs — Migrations](https://laravel.com/docs/migrations)
- [laravel.com/docs — Eloquent: Factories](https://laravel.com/docs/eloquent-factories)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [06.4 — Eloquent ORM](../04-eloquent-orm-bases/README.en.md) · **Next:** [06.6 — Form Validation](../06-validation-formulaires/README.en.md)
