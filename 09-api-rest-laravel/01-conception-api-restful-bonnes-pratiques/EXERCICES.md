# Exercices — 09.1 Conception d'API RESTful

## Exercice 1 — apiResource (facile)

Créez `routes/api.php` avec `Route::apiResource('produits', ...)`. Comparez `php artisan route:list` avec celui d'un `Route::resource()` équivalent (module 06.2) : listez les routes manquantes.

## Exercice 2 — Versionner dès le départ (facile)

Enveloppez vos routes API dans `Route::prefix('v1')`. Vérifiez que toutes les URLs commencent bien par `/api/v1/`.

## Exercice 3 — Filtres cohérents (moyen)

Reprenez `index()` du [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) et adaptez-le pour une API : mêmes filtres (recherche, catégorie, prix_max), mais retournant du JSON plutôt qu'une vue.

## Exercice 4 — Codes de statut corrects (moyen)

Implémentez `store()`, `destroy()` avec les bons codes (201, 204). Testez avec `curl -i` et vérifiez les codes retournés.

## Exercice 5 — Auditer une API mal conçue (difficile)

Cette API viole plusieurs bonnes pratiques du module. Identifiez-les toutes et proposez une version corrigée :
```
GET  /api/getAnnonce?id=5
POST /api/annonce/delete/5
GET  /api/annonces/liste/actives
POST /api/annonces/5/setStatutPublie
```

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
