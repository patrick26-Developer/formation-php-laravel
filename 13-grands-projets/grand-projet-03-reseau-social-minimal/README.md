# Grand projet : Réseau social minimal

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire un réseau social minimal : publications, système de follow (relation N-N auto-référencée), likes, notifications, et une API pour une future application mobile — synthèse des relations Eloquent avancées, de l'authentification et des notifications.

## 📋 Modules mobilisés

- [07.1 — Relations Eloquent avancées](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md) (relation N-N auto-référencée `follows`, `withCount`)
- [07.7 — Notifications et emails](../../07-laravel-intermediaire/07-notifications-mail/README.md) (centre de notifications en base)
- [09 — API REST avec Laravel](../../09-api-rest-laravel/README.md) (Sanctum, Resources, `whenCounted`)
- [08.3 — Tests Pest](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md) (`Notification::fake()`)

## 🧠 Ce que vous allez apprendre

- Modéliser une relation N-N **auto-référencée** (`User` suit `User`) avec deux méthodes de relation distinctes (`following()`/`followers()`) pointant vers la même table pivot mais des colonnes différentes.
- Construire un fil d'actualité filtré par abonnements (`whereIn` sur un ensemble d'IDs calculé dynamiquement).
- Notifier intelligemment : jamais de notification pour un like sur son propre post, ni pour un follow de soi-même (interdit en amont).
- Exposer le même domaine (`Post`) à la fois en Blade (web) et en API (Sanctum), avec une `PostResource` calculant `aime_par_moi` selon l'utilisateur de la requête.

## 📂 Structure du projet

```
grand-projet-03-reseau-social-minimal/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/{migrations,factories,seeders}/
├── app/
│   ├── Models/Post.php (+ ajouts à User)
│   ├── Notifications/          # NouvelAbonneNotification, PostAimeNotification
│   ├── Policies/PostPolicy.php
│   ├── Http/
│   │   ├── Controllers/         # PostController, FollowController, LikeController, Api/FeedController
│   │   └── Resources/PostResource.php
├── routes/{web.php,api.php}
├── resources/views/posts/feed.blade.php
└── tests/Feature/FeedTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md) — commencez par `FeedTest`.
3. **Avant de lire le code fourni**, essayez de concevoir vous-même `following()`/`followers()` à partir du module 07.1.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Grand projet : SaaS de facturation multi-tenant](../grand-projet-04-saas-facturation/README.md)
