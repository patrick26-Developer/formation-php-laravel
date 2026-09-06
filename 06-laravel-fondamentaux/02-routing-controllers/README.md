# 06.2 — Routing et Controllers

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Définir des routes GET/POST/PUT/DELETE.
- Utiliser des paramètres de route et le model binding.
- Créer et utiliser des contrôleurs, y compris les Resource Controllers.
- Nommer des routes et générer des URLs.

## 📋 Prérequis

[06.1 — Installation de Laravel et Artisan](../01-installation-configuration-artisan/README.md), [03.2 — Architecture MVC from scratch](../../03-php-avance/02-architecture-mvc-from-scratch/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Définir des routes

```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TacheController;

Route::get('/taches', [TacheController::class, 'index']);
Route::get('/taches/creer', [TacheController::class, 'create']);
Route::post('/taches', [TacheController::class, 'store']);
Route::get('/taches/{tache}', [TacheController::class, 'show']);
Route::get('/taches/{tache}/modifier', [TacheController::class, 'edit']);
Route::put('/taches/{tache}', [TacheController::class, 'update']);
Route::delete('/taches/{tache}', [TacheController::class, 'destroy']);
```

> 📌 Reconnaissez immédiatement le `Routeur.php` du [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.md) : `Route::get()`/`post()` sont exactement vos méthodes `get()`/`post()`, en plus complet.

### Le Model Binding : Laravel résout vos paramètres automatiquement

```php
Route::get('/taches/{tache}', [TacheController::class, 'show']);
```

```php
// app/Http/Controllers/TacheController.php
public function show(Tache $tache)
{
    return view('taches.show', ['tache' => $tache]);
}
```

> 💡 Laravel **résout automatiquement** `{tache}` en interrogeant la base de données (`Tache::findOrFail($id)`) et injecte directement l'objet Eloquent dans votre méthode — équivalent à ce que vous faisiez manuellement avec `$this->taches->trouver((int) $id)` au [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md). Si aucune tâche ne correspond à l'ID, Laravel renvoie automatiquement une erreur 404 — vous n'avez **jamais** à écrire ce contrôle vous-même.

### Créer un contrôleur

```bash
php artisan make:controller TacheController
```

```php
// app/Http/Controllers/TacheController.php
namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::all();
        return view('taches.index', ['taches' => $taches]);
    }

    public function store(Request $request)
    {
        Tache::create($request->only(['titre', 'description']));
        return redirect()->route('taches.index');
    }
}
```

### Resource Controllers : une ligne pour 7 routes CRUD

```bash
php artisan make:controller TacheController --resource
```

```php
// routes/web.php
Route::resource('taches', TacheController::class);
```

Cette seule ligne génère automatiquement les 7 routes CRUD standards :

| Méthode HTTP | URI | Action du contrôleur | Nom de route |
|---|---|---|---|
| GET | `/taches` | `index` | `taches.index` |
| GET | `/taches/creer` | `create` | `taches.create` |
| POST | `/taches` | `store` | `taches.store` |
| GET | `/taches/{tache}` | `show` | `taches.show` |
| GET | `/taches/{tache}/edit` | `edit` | `taches.edit` |
| PUT/PATCH | `/taches/{tache}` | `update` | `taches.update` |
| DELETE | `/taches/{tache}` | `destroy` | `taches.destroy` |

> 📌 C'est **exactement** le tableau de méthodes HTTP/actions du [module 03.4](../../03-php-avance/04-construction-api-rest-php-natif/README.md) sur les API REST, appliqué aux pages web. Un `Route::resource()` remplace les 7 lignes que vous auriez écrites à la main dans `Routeur.php`.

### Routes nommées et génération d'URL

```php
Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');
```

```php
// Dans une vue Blade ou un contrôleur :
redirect()->route('taches.index');
route('taches.show', ['tache' => $tache->id]); // génère "/taches/5"
```

> ⚠️ **Bonne pratique professionnelle** : toujours utiliser `route('nom.route')` plutôt que d'écrire l'URL en dur (`/taches`). Si l'URL change un jour (`/taches` devient `/mes-taches`), un seul endroit à modifier (la déclaration de route) au lieu de chercher toutes les occurrences codées en dur dans les vues.

### Groupes de routes

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('taches', TacheController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
    // URL finale : /admin/utilisateurs, nom de route : admin.utilisateurs
});
```

## ✅ Points clés à retenir

- `Route::resource()` génère les 7 routes CRUD standards en une seule ligne.
- Le Model Binding injecte directement l'objet Eloquent correspondant à un paramètre de route, avec 404 automatique si non trouvé.
- Toujours nommer ses routes et utiliser `route()`/`redirect()->route()` plutôt que des URLs en dur.
- Les groupes de routes factorisent middleware, préfixe et nommage communs.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Routing](https://laravel.com/docs/routing)
- [laravel.com/docs — Controllers](https://laravel.com/docs/controllers)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.1 — Installation de Laravel et Artisan](../01-installation-configuration-artisan/README.md) · **Suite :** [06.3 — Le moteur de templates Blade](../03-blade-templates/README.md)
