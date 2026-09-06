# 09.1 — Conception d'API RESTful : bonnes pratiques

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Nommer des routes API de façon cohérente et prévisible.
- Utiliser les bons codes de statut HTTP systématiquement.
- Structurer `routes/api.php` avec `Route::apiResource()`.
- Connaître les conventions de pagination, filtrage et tri pour une API.

## 📋 Prérequis

[Niveau 08 — Laravel Avancé](../../08-laravel-avance/README.md), [03.4 — Construction d'une API REST en PHP natif](../../03-php-avance/04-construction-api-rest-php-natif/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### `routes/api.php` : un fichier dédié, sans état de session

```php
// routes/api.php
use App\Http\Controllers\Api\AnnonceController;

Route::apiResource('annonces', AnnonceController::class);
```

> 📌 `Route::apiResource()` (plutôt que `Route::resource()`, module 06.2) génère les mêmes 7 routes **sans** `create` ni `edit` — ces deux routes servent uniquement à afficher des **formulaires HTML**, un concept qui n'a pas de sens pour une API JSON consommée par une application mobile ou un frontend séparé.

Toutes les routes de `routes/api.php` sont automatiquement préfixées par `/api` et **sans session/CSRF** (module 02.6) : une API REST est censée être **stateless** — chaque requête doit se suffire à elle-même (généralement via un jeton d'authentification, module 09.3), sans dépendre d'un état de session côté serveur entre deux requêtes.

### Convention de nommage des ressources

| Bonne pratique | Exemple |
|---|---|
| Noms de ressources au pluriel | `/api/annonces`, pas `/api/annonce` |
| Imbrication limitée à un niveau | `/api/annonces/{id}/messages`, pas `/api/annonces/{id}/messages/{id}/reponses/{id}` |
| Verbes dans l'URL évités (le verbe HTTP suffit) | `DELETE /api/annonces/{id}`, pas `/api/annonces/{id}/supprimer` |
| Filtres en query string | `/api/annonces?categorie=3&prix_max=100` |

### Codes de statut : rappel et complément du module 03.4

| Code | Quand l'utiliser dans Laravel |
|---|---|
| `200 OK` | `GET`/`PUT` réussi |
| `201 Created` | `POST` réussi (`response()->json($ressource, 201)`) |
| `204 No Content` | `DELETE` réussi (`response()->noContent()`) |
| `422 Unprocessable Entity` | Échec de validation (Laravel le fait **automatiquement** pour une requête API, module 09.2) |
| `429 Too Many Requests` | Rate limiting dépassé (module 09.6) |

### Versionner l'API dès le départ

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::apiResource('annonces', \App\Http\Controllers\Api\V1\AnnonceController::class);
});
```

> 💡 Même sans besoin immédiat d'une V2, préfixer `/api/v1/...` dès le premier jour évite une migration douloureuse plus tard, quand des clients externes (une app mobile déjà publiée) dépendront de la structure actuelle des réponses. Approfondi au [module 09.5](../05-versioning-documentation-openapi/README.md).

### Pagination, tri, filtrage : cohérence avec le reste de la formation

```php
// app/Http/Controllers/Api/V1/AnnonceController.php
public function index(Request $request)
{
    $annonces = Annonce::query()
        ->actives()
        ->when($request->filled('categorie'), fn ($q) => $q->deLaCategorie($request->integer('categorie')))
        ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->input('recherche') . '%'))
        ->paginate($request->integer('par_page', 15));

    return AnnonceResource::collection($annonces); // module 09.2
}
```

> 📌 **Exactement** le même Query Builder que le [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md) et le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) : une API REST Laravel réutilise l'intégralité de la couche Eloquent déjà maîtrisée — seule la couche de présentation change (JSON via Resources, plutôt que Blade).

## ✅ Points clés à retenir

- `routes/api.php` est stateless : pas de session, authentification par jeton.
- `Route::apiResource()` omet `create`/`edit`, sans objet pour une API JSON.
- Ressources au pluriel, verbes exprimés par la méthode HTTP, filtres en query string.
- Versionner l'API dès le départ (`/api/v1/...`) évite une migration douloureuse future.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Routing (API Resource Routes)](https://laravel.com/docs/controllers#api-resource-routes)
- [restfulapi.net](https://restfulapi.net/) (déjà cité au module 03.4)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 08 — Laravel Avancé](../../08-laravel-avance/README.md) · **Suite :** [09.2 — API Resources et transformation des données](../02-api-resources-transformers/README.md)
