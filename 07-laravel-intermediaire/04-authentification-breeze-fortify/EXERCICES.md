# Exercices — 07.4 Authentification Breeze/Fortify

## Exercice 1 — Installer Breeze (facile)

Sur un nouveau projet Laravel, installez Breeze (variante Blade), migrez, et testez l'inscription puis la connexion d'un utilisateur via l'interface générée.

## Exercice 2 — Explorer le code généré (facile)

Ouvrez `app/Http/Controllers/Auth/RegisteredUserController.php` et `AuthenticatedSessionController.php`. Identifiez la ligne qui hache le mot de passe et celle qui régénère la session après connexion.

## Exercice 3 — Protéger le blog du niveau 06 (moyen)

Installez Breeze sur le [mini-projet Blog](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md). Protégez les routes de création/modification/suppression d'articles avec `middleware('auth')`, en laissant `index` et `show` publics.

## Exercice 4 — Afficher l'utilisateur connecté (moyen)

Ajoutez dans le layout du blog un bloc `@auth`/`@else` affichant soit le nom de l'utilisateur connecté avec un lien de déconnexion, soit des liens connexion/inscription.

## Exercice 5 — Lier les articles à leur auteur (difficile)

Ajoutez une colonne `user_id` à `articles`. Modifiez `ArticleController::store()` pour associer automatiquement l'article à `$request->user()`. Affichez le nom de l'auteur sur la page de chaque article (`$article->user->name`, avec eager loading `with('user')`).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
