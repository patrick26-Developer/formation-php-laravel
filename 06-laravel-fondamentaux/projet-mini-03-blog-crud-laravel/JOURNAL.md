# Journal de construction

## Étape 1 — Le schéma : deux relations 1-N imbriquées

Trois migrations, dans l'ordre de leurs dépendances (`categories` avant `articles`, `articles` avant `comments`) : `Category` (1) → `Article` (N) → `Comment` (N). Chaque clé étrangère utilise `cascadeOnDelete()` (module 06.5) : supprimer une catégorie supprime ses articles, qui supprime leurs commentaires — une chaîne de suppression cohérente, sans laisser d'enregistrements orphelins (rappel du [module 04.2](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.md) sur l'intégrité référentielle).

## Étape 2 — Les modèles et leurs relations

`Category::articles()` (`hasMany`) et `Article::categorie()` (`belongsTo`) forment la première relation ; `Article::comments()` et `Comment::article()` la seconde. Remarquez que la colonne est `categorie_id` (français) alors que la méthode de relation Eloquent standard chercherait par défaut `category_id` (nom de la classe) — c'est pourquoi chaque relation précise explicitement sa clé étrangère (`belongsTo(Category::class, 'categorie_id')`, `hasMany(Article::class, 'categorie_id')`) plutôt que de compter sur la convention par défaut.

## Étape 3 — Les Form Requests

`StoreArticleRequest` et `UpdateArticleRequest` sont **volontairement séparés** (plutôt qu'un seul Request réutilisé) car leur règle sur `slug` diffère : `unique` sans condition à la création, `unique(...)->ignore($this->article)` à la modification — exactement le cas de figure détaillé à l'exercice 5 du [module 06.6](../06-validation-formulaires/README.md).

## Étape 4 — Le contrôleur d'articles : le cœur du projet

`ArticleController::index()` assemble tri (liste blanche de colonnes), recherche (`when()` + `LIKE`), filtre par catégorie (`when()`), et pagination (`paginate()->withQueryString()`) — repris presque à l'identique de l'exemple du [module 06.7](../07-crud-complet-laravel-tri-filtre-recherche/README.md). Le point ajouté ici : `->with('categorie')` dans la requête, qui charge la catégorie de **tous** les articles de la page en une seule requête SQL supplémentaire, plutôt qu'une requête par article affiché dans la boucle Blade (`$article->categorie->nom`) — le problème N+1 du [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.md), concrètement évité ici.

## Étape 5 — Les vues : un partiel pour éviter la duplication

`articles/create.blade.php` et `articles/edit.blade.php` sont **volontairement minces** : ils ne contiennent que la balise `<form>` et son action, et incluent tous deux `articles/_form.blade.php` pour les champs eux-mêmes. Sans ce partiel, toute modification d'un champ (ajouter une contrainte, changer un label) devrait être répétée dans deux fichiers — la même logique de factorisation que `Vue::afficher()` avec des templates partagés au [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.md).

## Étape 6 — Les factories et le seeder

`ArticleFactory` génère un `slug` unique en combinant `Str::slug($titre)` et un nombre aléatoire, pour éviter toute collision entre les 20 articles générés. `BlogSeeder` orchestre la création en cascade : catégories, puis pour chacune ses articles, puis pour chacun un nombre aléatoire (0 à 4) de commentaires — produisant un jeu de données réaliste et varié en une seule commande `db:seed`.

## Pour aller plus loin (hors scope de ce mini-projet)

Ce blog n'a **aucune authentification** : n'importe qui peut créer, modifier ou supprimer un article. C'est un choix pédagogique délibéré pour rester centré sur le CRUD Eloquent/Blade du Niveau 06 — la protection par connexion (Breeze) est le sujet du [mini-projet du Niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), qui reprend une structure très similaire en y ajoutant précisément cette couche.
