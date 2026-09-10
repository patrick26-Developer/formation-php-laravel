# Code source complet

L'intégralité du code de ce projet existe déjà dans ce dépôt — cliquez sur un fichier pour l'ouvrir, copiez-le tel quel dans votre propre projet Laravel en suivant [INSTALLATION.md](INSTALLATION.md).

## `app/Http/Controllers`

- [app/Http/Controllers/AnnonceController.php](app/Http/Controllers/AnnonceController.php)
- [app/Http/Controllers/FavoriteController.php](app/Http/Controllers/FavoriteController.php)
- [app/Http/Controllers/MessageController.php](app/Http/Controllers/MessageController.php)

## `app/Http/Requests`

- [app/Http/Requests/StoreAnnonceRequest.php](app/Http/Requests/StoreAnnonceRequest.php)
- [app/Http/Requests/UpdateAnnonceRequest.php](app/Http/Requests/UpdateAnnonceRequest.php)

## `app/Models`

- [app/Models/Annonce.php](app/Models/Annonce.php)
- [app/Models/Category.php](app/Models/Category.php)
- [app/Models/Message.php](app/Models/Message.php)
- [app/Models/User-additions.php](app/Models/User-additions.php)

## `app/Notifications`

- [app/Notifications/NouveauMessageNotification.php](app/Notifications/NouveauMessageNotification.php)

## `app/Policies`

- [app/Policies/AnnoncePolicy.php](app/Policies/AnnoncePolicy.php)

## `database/factories`

- [database/factories/AnnonceFactory.php](database/factories/AnnonceFactory.php)
- [database/factories/CategoryFactory.php](database/factories/CategoryFactory.php)

## `database/migrations`

- [database/migrations/2024_02_01_000001_create_categories_table.php](database/migrations/2024_02_01_000001_create_categories_table.php)
- [database/migrations/2024_02_01_000002_create_annonces_table.php](database/migrations/2024_02_01_000002_create_annonces_table.php)
- [database/migrations/2024_02_01_000003_create_messages_table.php](database/migrations/2024_02_01_000003_create_messages_table.php)
- [database/migrations/2024_02_01_000004_create_favorites_table.php](database/migrations/2024_02_01_000004_create_favorites_table.php)

## `database/seeders`

- [database/seeders/AnnoncesSeeder.php](database/seeders/AnnoncesSeeder.php)

## `resources/views/annonces`

- [resources/views/annonces/_form.blade.php](resources/views/annonces/_form.blade.php)
- [resources/views/annonces/create.blade.php](resources/views/annonces/create.blade.php)
- [resources/views/annonces/edit.blade.php](resources/views/annonces/edit.blade.php)
- [resources/views/annonces/index.blade.php](resources/views/annonces/index.blade.php)
- [resources/views/annonces/show.blade.php](resources/views/annonces/show.blade.php)

## `resources/views/layouts`

- [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)

## `routes`

- [routes/web.php](routes/web.php)

---

Retour au [README du projet](README.md).
