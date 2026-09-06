# Exercices — 06.2 Routing et Controllers

## Exercice 1 — Routes simples (facile)

Créez 3 routes GET (`/`, `/a-propos`, `/contact`) retournant chacune une chaîne différente directement depuis une fonction anonyme.

## Exercice 2 — Contrôleur classique (facile)

Créez un `ArticleController` avec une méthode `index()` retournant une vue (créez une vue minimale `resources/views/articles/index.blade.php` avec juste un `<h1>`).

## Exercice 3 — Model Binding (moyen)

Créez un modèle `Article` avec une migration simple (`titre`, `contenu`). Créez une route `/articles/{article}` et une méthode `show(Article $article)` qui affiche le titre de l'article. Testez avec un ID existant et un ID inexistant (observez le 404 automatique).

## Exercice 4 — Resource Controller complet (moyen)

Générez `php artisan make:controller ArticleController --resource`, déclarez `Route::resource('articles', ArticleController::class)`, et vérifiez les 7 routes avec `php artisan route:list --name=articles`.

## Exercice 5 — Groupes et routes nommées (difficile)

Créez un groupe de routes préfixé `admin` avec le nommage `admin.*`, contenant au moins deux routes. Utilisez `route('admin.xxx')` dans un contrôleur pour rediriger vers l'une d'elles. Vérifiez les URLs et noms générés avec `route:list`.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
