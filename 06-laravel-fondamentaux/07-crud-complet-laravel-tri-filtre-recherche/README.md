# 06.7 — CRUD complet Laravel (tri, filtre, recherche, pagination)

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Assembler routing, Eloquent, Blade et validation en un CRUD complet.
- Implémenter tri, filtre et recherche dynamiques avec le Query Builder.
- Utiliser la pagination native de Laravel.
- Structurer un contrôleur Resource complet et propre.

## 📋 Prérequis

Tous les modules précédents du Niveau 06, et [02.9 — CRUD complet avec PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

Ce module assemble tout ce qui précède pour reproduire — en une fraction du code — le CRUD complet construit à la main au module 02.9 et au mini-projet du niveau 02.

### Le contrôleur Resource complet

```php
// app/Http/Controllers/TacheController.php
namespace App\Http\Controllers;

use App\Models\Tache;
use App\Http\Requests\StoreTacheRequest;
use App\Http\Requests\UpdateTacheRequest;

class TacheController extends Controller
{
    public function index(Request $request)
    {
        $taches = Tache::query()
            ->where('user_id', $request->user()->id)
            ->when($request->filled('recherche'), function ($query) use ($request) {
                $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
            })
            ->when($request->filled('statut'), function ($query) use ($request) {
                $query->where('terminee', $request->input('statut') === 'terminees');
            })
            ->orderBy(
                $request->input('tri', 'created_at'),
                $request->input('ordre', 'desc')
            )
            ->paginate(10)
            ->withQueryString(); // conserve tri/recherche/statut en changeant de page

        return view('taches.index', ['taches' => $taches]);
    }

    public function create()
    {
        return view('taches.create');
    }

    public function store(StoreTacheRequest $request)
    {
        $request->user()->taches()->create($request->validated());

        return redirect()->route('taches.index')->with('succes', 'Tâche créée.');
    }

    public function edit(Tache $tache)
    {
        $this->authorize('update', $tache); // module 07.5
        return view('taches.edit', ['tache' => $tache]);
    }

    public function update(UpdateTacheRequest $request, Tache $tache)
    {
        $this->authorize('update', $tache);
        $tache->update($request->validated());

        return redirect()->route('taches.index')->with('succes', 'Tâche modifiée.');
    }

    public function destroy(Tache $tache)
    {
        $this->authorize('delete', $tache);
        $tache->delete();

        return redirect()->route('taches.index')->with('succes', 'Tâche supprimée.');
    }
}
```

> 💡 Comparez ce contrôleur au `TacheRepository` **et** aux 5 fichiers PHP du [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md) (`index.php`, `creer.php`, `modifier.php`, `supprimer.php`, `Auth.php`) : la même fonctionnalité (CRUD + tri + filtre + recherche + pagination + isolation par utilisateur) tient dans un seul fichier, environ 5 fois plus court.

### `when()` : conditionner une clause proprement

```php
->when($request->filled('recherche'), function ($query) use ($request) {
    $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
})
```

> 📌 `when()` remplace élégamment le pattern `if ($recherche !== null && $recherche !== '') { $conditions[] = ...; }` du module 02.9 : la clause n'est ajoutée à la requête que si la condition est vraie, sans `if` imbriqué disgracieux dans une chaîne de méthodes.

### La pagination native

```php
$taches = Tache::paginate(10);
```

```blade
{{-- resources/views/taches/index.blade.php --}}
@foreach ($taches as $tache)
    <p>{{ $tache->titre }}</p>
@endforeach

{{ $taches->links() }}
```

`$taches->links()` génère **automatiquement** les liens de pagination (précédent/suivant/numéros de page), avec le style Tailwind par défaut — remplaçant la boucle manuelle `for ($p = 1; $p <= $totalPages; $p++)` du module 02.9.

> ⚠️ `withQueryString()` est **essentiel** dès qu'on combine pagination et filtres : sans lui, cliquer sur "page 2" perdrait les paramètres `?recherche=...&tri=...` de l'URL courante.

### Tri cliquable dans la vue

```blade
<a href="{{ request()->fullUrlWithQuery(['tri' => 'titre', 'ordre' => request('ordre') === 'asc' ? 'desc' : 'asc']) }}">
    Titre
</a>
```

> 📌 Contrairement au module 02.9, où la colonne de tri devait être validée manuellement contre une **liste blanche** avant d'être insérée dans le SQL (`in_array($tri, $colonnesAutorisees, true)`), Eloquent expose `orderBy()` comme une **méthode**, pas une concaténation de chaîne SQL — mais la vigilance reste de mise : ne passez **jamais** directement `$request->input('tri')` sans vérifier qu'il correspond à une colonne réellement existante et autorisée, sous peine d'erreur SQL si un utilisateur malveillant envoie une valeur arbitraire. Une bonne pratique reste de whitelister :

```php
$colonnesAutorisees = ['titre', 'created_at', 'terminee'];
$tri = in_array($request->input('tri'), $colonnesAutorisees, true) ? $request->input('tri') : 'created_at';
```

## ✅ Points clés à retenir

- Un contrôleur Resource complet avec tri/filtre/recherche/pagination Eloquent tient en une fraction du code équivalent en PHP natif.
- `when()` conditionne élégamment une clause de requête sans `if` imbriqué.
- `paginate()` + `$taches->links()` + `withQueryString()` gèrent toute la pagination, y compris la préservation des filtres actifs.
- La vigilance sur le nom de colonne de tri (liste blanche) reste nécessaire même avec Eloquent.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Query Builder: Ordering, Grouping, Limit and Offset](https://laravel.com/docs/queries#ordering-grouping-limit-and-offset)
- [laravel.com/docs — Pagination](https://laravel.com/docs/pagination)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.6 — Validation des formulaires](../06-validation-formulaires/README.md) · **Suite :** [Mini-projet : Blog avec CRUD Laravel](../projet-mini-03-blog-crud-laravel/README.md)
