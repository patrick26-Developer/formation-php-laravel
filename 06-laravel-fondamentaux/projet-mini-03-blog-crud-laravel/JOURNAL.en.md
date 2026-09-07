# Build Journal

## Step 1 — The schema: two nested 1-N relationships

Three migrations, in dependency order (`categories` before `articles`, `articles` before `comments`): `Category` (1) → `Article` (N) → `Comment` (N). Every foreign key uses `cascadeOnDelete()` (module 06.5): deleting a category deletes its articles, which deletes their comments — a consistent deletion chain, leaving no orphan records (recall [module 04.2](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.en.md) on referential integrity).

## Step 2 — The models and their relationships

`Category::articles()` (`hasMany`) and `Article::categorie()` (`belongsTo`) form the first relationship; `Article::comments()` and `Comment::article()` the second. Notice that the column is `categorie_id` (French) whereas the standard Eloquent relationship method would by default look for `category_id` (the class name) — that's why each relationship explicitly specifies its foreign key (`belongsTo(Category::class, 'categorie_id')`, `hasMany(Article::class, 'categorie_id')`) rather than relying on the default convention.

## Step 3 — The Form Requests

`StoreArticleRequest` and `UpdateArticleRequest` are **deliberately kept separate** (rather than one reused Request) because their rule on `slug` differs: `unique` with no condition on creation, `unique(...)->ignore($this->article)` on update — exactly the scenario detailed in exercise 5 of [module 06.6](../06-validation-formulaires/README.en.md).

## Step 4 — The article controller: the heart of the project

`ArticleController::index()` combines sorting (column whitelist), search (`when()` + `LIKE`), category filtering (`when()`), and pagination (`paginate()->withQueryString()`) — reused almost identically from the example in [module 06.7](../07-crud-complet-laravel-tri-filtre-recherche/README.en.md). The addition here: `->with('categorie')` in the query, which loads **every** article's category on the page in a single extra SQL query, rather than one query per article displayed in the Blade loop (`$article->categorie->nom`) — the N+1 problem from [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.en.md), concretely avoided here.

## Step 5 — The views: a partial to avoid duplication

`articles/create.blade.php` and `articles/edit.blade.php` are **deliberately thin**: they contain only the `<form>` tag and its action, and both include `articles/_form.blade.php` for the fields themselves. Without this partial, any change to a field (adding a constraint, changing a label) would have to be repeated in two files — the same factoring logic as `Vue::afficher()` with shared templates in [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md).

## Step 6 — The factories and the seeder

`ArticleFactory` generates a unique `slug` by combining `Str::slug($titre)` with a random number, to avoid any collision among the 20 generated articles. `BlogSeeder` orchestrates cascading creation: categories, then for each one its articles, then for each article a random number (0 to 4) of comments — producing a realistic, varied dataset with a single `db:seed` command.

## Going further (out of scope for this mini-project)

This blog has **no authentication at all**: anyone can create, edit, or delete an article. This is a deliberate pedagogical choice to stay focused on Level 06's Eloquent/Blade CRUD — login protection (Breeze) is the subject of the [Level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) *(French only)*, which reuses a very similar structure while adding precisely that layer.
