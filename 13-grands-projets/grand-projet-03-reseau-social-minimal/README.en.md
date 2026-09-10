# Large Project: Minimal Social Network

> **Status:** ✅ Available

## 🎯 Learning objective

Build a minimal social network: posts, a follow system (a self-referencing N-N relationship), likes, notifications, and an API for a future mobile app — a synthesis of advanced Eloquent relationships, authentication, and notifications.

## 📋 Modules used

- [07.1 — Advanced Eloquent Relationships](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.en.md) (a self-referencing N-N `follows` relationship, `withCount`)
- [07.7 — Notifications and Emails](../../07-laravel-intermediaire/07-notifications-mail/README.en.md) (a database notification center)
- [09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md) (Sanctum, Resources, `whenCounted`)
- [08.3 — Pest Tests](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md) (`Notification::fake()`)

## 🧠 What you'll learn

- Model a **self-referencing** N-N relationship (`User` follows `User`) with two distinct relationship methods (`following()`/`followers()`) pointing to the same pivot table but different columns.
- Build a news feed filtered by subscriptions (`whereIn` on a dynamically computed set of IDs).
- Notify intelligently: never a notification for liking your own post, nor for following yourself (blocked upstream).
- Expose the same domain (`Post`) both in Blade (web) and in an API (Sanctum), with a `PostResource` computing `aime_par_moi` based on the requesting user.

## 📂 Project structure

```
grand-projet-03-reseau-social-minimal/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/{migrations,factories,seeders}/
├── app/
│   ├── Models/Post.php (+ additions to User)
│   ├── Notifications/          # NouvelAbonneNotification, PostAimeNotification
│   ├── Policies/PostPolicy.php
│   ├── Http/
│   │   ├── Controllers/         # PostController, FollowController, LikeController, Api/FeedController
│   │   └── Resources/PostResource.php
├── routes/{web.php,api.php}
├── resources/views/posts/feed.blade.php
└── tests/Feature/FeedTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md) — start with `FeedTest`.
3. **Before reading the provided code**, try designing `following()`/`followers()` yourself, based on module 07.1.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.
5. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Large Project: Multi-tenant Billing SaaS](../grand-projet-04-saas-facturation/README.en.md)
