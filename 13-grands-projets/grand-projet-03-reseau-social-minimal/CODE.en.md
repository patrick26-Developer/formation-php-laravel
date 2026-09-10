# Complete Source Code

This project's entire code already exists in this repository — click a file to open it, copy it as-is into your own Laravel project by following [INSTALLATION.md](INSTALLATION.en.md).

## `app/Http/Controllers`

- [app/Http/Controllers/FollowController.php](app/Http/Controllers/FollowController.php)
- [app/Http/Controllers/LikeController.php](app/Http/Controllers/LikeController.php)
- [app/Http/Controllers/PostController.php](app/Http/Controllers/PostController.php)

## `app/Http/Controllers/Api`

- [app/Http/Controllers/Api/FeedController.php](app/Http/Controllers/Api/FeedController.php)

## `app/Http/Resources`

- [app/Http/Resources/PostResource.php](app/Http/Resources/PostResource.php)

## `app/Models`

- [app/Models/Post.php](app/Models/Post.php)
- [app/Models/User-additions.php](app/Models/User-additions.php)

## `app/Notifications`

- [app/Notifications/NouvelAbonneNotification.php](app/Notifications/NouvelAbonneNotification.php)
- [app/Notifications/PostAimeNotification.php](app/Notifications/PostAimeNotification.php)

## `app/Policies`

- [app/Policies/PostPolicy.php](app/Policies/PostPolicy.php)

## `database/factories`

- [database/factories/PostFactory.php](database/factories/PostFactory.php)

## `database/migrations`

- [database/migrations/2024_06_01_000001_create_posts_table.php](database/migrations/2024_06_01_000001_create_posts_table.php)
- [database/migrations/2024_06_01_000002_create_follows_table.php](database/migrations/2024_06_01_000002_create_follows_table.php)
- [database/migrations/2024_06_01_000003_create_likes_table.php](database/migrations/2024_06_01_000003_create_likes_table.php)

## `database/seeders`

- [database/seeders/ReseauSocialSeeder.php](database/seeders/ReseauSocialSeeder.php)

## `resources/views/posts`

- [resources/views/posts/feed.blade.php](resources/views/posts/feed.blade.php)

## `routes`

- [routes/api.php](routes/api.php)
- [routes/web.php](routes/web.php)

## `tests/Feature`

- [tests/Feature/FeedTest.php](tests/Feature/FeedTest.php)

---

Back to the [project README](README.en.md).
