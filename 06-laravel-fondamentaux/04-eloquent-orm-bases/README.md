# 06.4 — Eloquent ORM : les bases

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle d'un modèle Eloquent.
- Effectuer les opérations CRUD de base sans écrire de SQL.
- Utiliser le Query Builder pour des requêtes plus complexes.
- Comprendre les conventions Eloquent (nommage, clé primaire, timestamps).

## 📋 Prérequis

[06.3 — Le moteur de templates Blade](../03-blade-templates/README.md), [02.9 — CRUD complet avec PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Qu'est-ce qu'Eloquent ?

**Eloquent** est l'**ORM** (Object-Relational Mapping) de Laravel : chaque table de base de données est représentée par une classe (un **modèle**), et chaque ligne par une instance de cette classe. Eloquent est votre `TacheRepository` (module 02.9) **généralisé et automatisé** — vous n'écrivez plus de SQL pour les opérations courantes.

```php
// app/Models/Tache.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = ['titre', 'description', 'terminee'];
}
```

> ⚠️ `$fillable` liste les colonnes **autorisées** à être assignées en masse (via `create()`/`update()` avec un tableau). C'est une protection contre l'**assignation de masse non désirée** : sans elle, un attaquant pourrait injecter des champs non prévus (par exemple `est_admin => true`) dans un formulaire, si le contrôleur passe `$request->all()` sans filtrage.

### Conventions Eloquent (à connaître pour ne pas les combattre)

| Convention | Exemple |
|---|---|
| Nom de table = pluriel snake_case du modèle | Modèle `Tache` → table `taches` ; `LigneCommande` → `ligne_commandes` |
| Clé primaire = `id` (auto-incrémentée) | Personnalisable via `protected $primaryKey` |
| Timestamps automatiques | `created_at`/`updated_at` gérés automatiquement (désactivable via `public $timestamps = false`) |

### CRUD avec Eloquent

```php
// CREATE
$tache = Tache::create(['titre' => 'Faire les courses', 'description' => '']);

// READ
$toutesLesTaches = Tache::all();
$tache = Tache::find(1);           // retourne null si non trouvé
$tache = Tache::findOrFail(1);      // lève une ModelNotFoundException (404 automatique en HTTP)
$premiere = Tache::first();

// UPDATE
$tache = Tache::find(1);
$tache->titre = 'Nouveau titre';
$tache->save();
// ou en une ligne :
Tache::find(1)->update(['titre' => 'Nouveau titre']);

// DELETE
Tache::find(1)->delete();
Tache::destroy(1); // ou : Tache::destroy([1, 2, 3]);
```

> 💡 Comparez avec `TacheRepository::creer()`/`trouver()`/`modifier()`/`supprimer()` du module 02.9 : Eloquent élimine complètement l'écriture manuelle des requêtes SQL préparées, **tout en gardant la même protection contre l'injection SQL** (Eloquent utilise des requêtes préparées en interne).

### Le Query Builder : pour des requêtes plus riches

```php
$taches = Tache::where('terminee', false)
    ->where('titre', 'like', '%courses%')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

$nombre = Tache::where('terminee', true)->count();

$existe = Tache::where('titre', 'Faire les courses')->exists();
```

> 📌 Ce Query Builder génère le même SQL que vous écriviez manuellement au [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) (`WHERE`, `ORDER BY`, `LIMIT`), mais avec une syntaxe orientée objet fluide (méthodes chaînées), sans jamais manipuler de chaîne SQL brute.

### Attributs castés

```php
class Tache extends Model
{
    protected $casts = [
        'terminee' => 'boolean',
        'creee_le' => 'datetime',
    ];
}
```

`$casts` convertit automatiquement les types stockés en base (souvent `0`/`1` ou des chaînes) vers de vrais types PHP (`bool`, `DateTime`) à la lecture, et inversement à l'écriture.

## ✅ Points clés à retenir

- Un modèle Eloquent représente une table ; `$fillable` protège contre l'assignation de masse non désirée.
- `find()`/`findOrFail()`/`all()`/`create()`/`update()`/`delete()` couvrent le CRUD de base sans SQL manuel.
- Le Query Builder (`where`, `orderBy`, `limit`...) reste disponible pour des requêtes plus riches, toujours protégé contre l'injection SQL.
- Respectez les conventions Eloquent (nommage pluriel, `id`, timestamps) : les combattre inutilement complique chaque étape suivante.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Eloquent: Getting Started](https://laravel.com/docs/eloquent)
- [Module 06.5 — Migrations, seeders, factories](../05-migrations-seeders-factories/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.3 — Blade](../03-blade-templates/README.md) · **Suite :** [06.5 — Migrations, seeders, factories](../05-migrations-seeders-factories/README.md)
