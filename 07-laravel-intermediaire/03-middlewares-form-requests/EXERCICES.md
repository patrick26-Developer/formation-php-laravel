# Exercices — 07.3 Middlewares et Form Requests

## Exercice 1 — Premier middleware (facile)

Créez un middleware `LogRequete` qui journalise (`logger()`) la méthode et l'URL de chaque requête entrante, puis laisse passer. Enregistrez-le globalement dans `bootstrap/app.php`.

## Exercice 2 — Middleware conditionnel (facile)

Créez un middleware `EstEnHeuresOuvrables` qui bloque l'accès (403) en dehors de 8h-20h (simulez avec `now()->hour`). Appliquez-le à une route de test.

## Exercice 3 — Middleware avec paramètre (moyen)

Créez un middleware `role:xxx` qui vérifie `$request->user()->role === $role`. Appliquez-le à deux routes différentes avec des rôles différents (`role:admin`, `role:editeur`).

## Exercice 4 — Ordre d'exécution (moyen)

Créez deux middlewares `PremierMiddleware` et `SecondMiddleware`, chacun journalisant son passage avant ET après `$next($request)`. Appliquez-les dans un ordre puis dans l'ordre inverse sur deux routes différentes, observez les logs, et expliquez en commentaire pourquoi l'ordre de `$next()` produit un effet "pile" (le premier entré est le dernier sorti).

## Exercice 5 — Form Request avec autorisation (difficile)

Sur le [mini-projet du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md), ajoutez une colonne `user_id` à `articles` (simulez un auteur). Modifiez `UpdateArticleRequest` pour que `authorize()` retourne `true` uniquement si l'utilisateur connecté est l'auteur de l'article. Testez le cas refusé (403) avec un autre utilisateur.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
