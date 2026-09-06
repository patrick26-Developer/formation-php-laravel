# 06.5 — Migrations, seeders, factories

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Versionner un schéma de base de données avec les migrations.
- Définir des relations et contraintes dans une migration.
- Générer des données de test réalistes avec les factories.
- Peupler la base de données avec des seeders.

## 📋 Prérequis

[06.4 — Eloquent ORM : les bases](../04-eloquent-orm-bases/README.md), [04.1 — Modélisation relationnelle](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Pourquoi les migrations ?

Une **migration** est un fichier PHP décrivant une modification du schéma de base de données, horodaté et versionné avec le code. C'est l'équivalent des `CREATE TABLE` que vous écriviez à la main aux [modules 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) et [04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.md), mais **versionné dans Git** et **exécutable dans l'ordre** sur n'importe quelle machine (celle d'un collègue, un serveur de production) — plus besoin de partager un fichier `schema.sql` séparément.

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

> 📌 `foreignId('user_id')->constrained()->cascadeOnDelete()` génère automatiquement une clé étrangère vers `users.id` avec `ON DELETE CASCADE` — exactement la contrainte que vous écriviez à la main au [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) (`FOREIGN KEY ... ON DELETE CASCADE`).

### Les commandes de migration

```bash
php artisan migrate               # exécute toutes les migrations en attente (appelle up())
php artisan migrate:rollback        # annule la dernière "vague" de migrations (appelle down())
php artisan migrate:fresh             # supprime TOUTES les tables et rejoue toutes les migrations depuis zéro
php artisan migrate:status              # liste les migrations exécutées ou en attente
```

> ⚠️ `migrate:fresh` **supprime toutes les données**. À réserver au développement local, jamais en production.

### Types de colonnes courants

```php
$table->id();                          // clé primaire auto-incrémentée (BIGINT UNSIGNED)
$table->string('titre', 150);           // VARCHAR(150)
$table->text('description');             // TEXT
$table->integer('quantite');               // INT
$table->decimal('prix', 10, 2);              // DECIMAL(10,2) — pour l'argent (rappel module 04.3)
$table->boolean('terminee')->default(false);   // BOOLEAN
$table->date('date_naissance');                  // DATE
$table->timestamp('publie_le')->nullable();        // TIMESTAMP, peut être NULL
$table->timestamps();                                // created_at + updated_at automatiques
$table->softDeletes();                                 // deleted_at, pour la suppression douce (module 07)
```

### Les factories : générer de fausses données réalistes

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
            'terminee' => fake()->boolean(20), // 20% de chances d'être true
        ];
    }
}
```

```php
// Via Tinker
Tache::factory()->count(50)->create();          // crée 50 tâches avec des données réalistes
Tache::factory()->create(['terminee' => true]);  // surcharge un champ précis
```

> 💡 `fake()` (basé sur la librairie Faker) génère des noms, phrases, emails, dates réalistes — bien plus pratique que les `"Tâche de test $i"` génériques que vous auriez écrits à la main.

### Les seeders : peupler la base pour le développement

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
php artisan db:seed                # exécute DatabaseSeeder (qui appelle les seeders enregistrés)
php artisan migrate:fresh --seed     # combine migrate:fresh + db:seed en une commande
```

> 📌 C'est l'équivalent professionnel du `seed.php` écrit à la main au [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md) — sauf qu'ici, une seule commande recrée un environnement de développement complet, avec des dizaines d'enregistrements réalistes, de façon reproductible pour toute l'équipe.

## ✅ Points clés à retenir

- Une migration versionne le schéma de base de données dans Git, exécutable dans l'ordre sur n'importe quelle machine.
- `foreignId()->constrained()->cascadeOnDelete()` génère les contraintes d'intégrité référentielle automatiquement.
- Une factory génère des données de test réalistes ; un seeder orchestre leur création pour peupler la base.
- `migrate:fresh --seed` recrée un environnement de développement complet en une seule commande.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Migrations](https://laravel.com/docs/migrations)
- [laravel.com/docs — Eloquent: Factories](https://laravel.com/docs/eloquent-factories)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.4 — Eloquent ORM](../04-eloquent-orm-bases/README.md) · **Suite :** [06.6 — Validation des formulaires](../06-validation-formulaires/README.md)
