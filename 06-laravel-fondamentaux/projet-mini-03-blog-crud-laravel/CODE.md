# Code source complet

L'intégralité du code de ce projet existe déjà dans ce dépôt — cliquez sur un fichier pour l'ouvrir, copiez-le tel quel dans votre propre projet Laravel en suivant [INSTALLATION.md](INSTALLATION.md).

## `app/Http/Controllers`

- [app/Http/Controllers/ArticleController.php](app/Http/Controllers/ArticleController.php)
- [app/Http/Controllers/CategoryController.php](app/Http/Controllers/CategoryController.php)
- [app/Http/Controllers/CommentController.php](app/Http/Controllers/CommentController.php)

## `app/Http/Requests`

- [app/Http/Requests/StoreArticleRequest.php](app/Http/Requests/StoreArticleRequest.php)
- [app/Http/Requests/UpdateArticleRequest.php](app/Http/Requests/UpdateArticleRequest.php)

## `app/Models`

- [app/Models/Article.php](app/Models/Article.php)
- [app/Models/Category.php](app/Models/Category.php)
- [app/Models/Comment.php](app/Models/Comment.php)

## `database/factories`

- [database/factories/ArticleFactory.php](database/factories/ArticleFactory.php)
- [database/factories/CategoryFactory.php](database/factories/CategoryFactory.php)
- [database/factories/CommentFactory.php](database/factories/CommentFactory.php)

## `database/migrations`

- [database/migrations/2024_01_01_000001_create_categories_table.php](database/migrations/2024_01_01_000001_create_categories_table.php)
- [database/migrations/2024_01_01_000002_create_articles_table.php](database/migrations/2024_01_01_000002_create_articles_table.php)
- [database/migrations/2024_01_01_000003_create_comments_table.php](database/migrations/2024_01_01_000003_create_comments_table.php)

## `database/seeders`

- [database/seeders/BlogSeeder.php](database/seeders/BlogSeeder.php)

## `resources/views/articles`

- [resources/views/articles/_form.blade.php](resources/views/articles/_form.blade.php)
- [resources/views/articles/create.blade.php](resources/views/articles/create.blade.php)
- [resources/views/articles/edit.blade.php](resources/views/articles/edit.blade.php)
- [resources/views/articles/index.blade.php](resources/views/articles/index.blade.php)
- [resources/views/articles/show.blade.php](resources/views/articles/show.blade.php)

## `resources/views/categories`

- [resources/views/categories/index.blade.php](resources/views/categories/index.blade.php)

## `resources/views/layouts`

- [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)

## `routes`

- [routes/web.php](routes/web.php)

---

Retour au [README du projet](README.md).
