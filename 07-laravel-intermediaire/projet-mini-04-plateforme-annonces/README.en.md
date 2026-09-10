# Mini-project: Classifieds Platform

> **Status:** ✅ Available

## 🎯 Learning objective

Build a complete classifieds platform: authentication, authorization (only the author edits/deletes their listing), image uploads, favorites, and notifications — bringing together **every** Level 07 module in a realistic case, reusing the proven structure from the [level 06 blog](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md).

## 📋 Modules used

- [07.1 — Advanced Eloquent Relationships](../01-eloquent-relations-avancees/README.en.md) (`belongsToMany` for favorites)
- [07.2 — Scopes, Accessors, Mutators](../02-eloquent-scopes-accessors-mutators/README.en.md) (`scopeActives`, `imageUrl`)
- [07.4 — Breeze Authentication](../04-authentification-breeze-fortify/README.en.md)
- [07.5 — Policies and Gates](../05-autorisations-policies-gates/README.en.md) (`AnnoncePolicy`)
- [07.6 — File Uploads and Storage](../06-upload-fichiers-storage/README.en.md)
- [07.7 — Notifications and Emails](../07-notifications-mail/README.en.md) (notifying the seller)

## 🧠 What you'll learn

- Combining authentication (who are you?) and authorization (what can you do?) on a real use case: anyone can browse and get in touch, only the owner can edit/delete their own listing.
- Managing a file's full lifecycle (upload on creation, replacement on edit, automatic deletion via a Model Event when the listing is deleted).
- Notifying a user (email + database storage) as the result of an action from a non-logged-in visitor (the contact form).
- Using a `belongsToMany` relationship for a simple favorites system, with no extra data on the pivot table.

## 📂 Project structure

Files to add to a Laravel project **with Breeze already installed** (see [INSTALLATION.md](INSTALLATION.en.md)):

```
projet-mini-04-plateforme-annonces/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/            # categories, annonces, messages, favorites
│   ├── factories/
│   └── seeders/AnnoncesSeeder.php
├── app/
│   ├── Models/                    # Category, Annonce, Message (+ additions to User)
│   ├── Policies/AnnoncePolicy.php
│   ├── Notifications/NouveauMessageNotification.php
│   └── Http/
│       ├── Controllers/             # AnnonceController, MessageController, FavoriteController
│       └── Requests/                  # StoreAnnonceRequest, UpdateAnnonceRequest
├── routes/web.php
└── resources/views/
    ├── layouts/app.blade.php
    └── annonces/                        # index, show, create, edit, _form
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md) — install Laravel + Breeze, copy these files, migrate, seed.
2. [EXECUTION.md](EXECUTION.en.md) — browse the platform, test authorization and notifications.
3. **Before reading the provided code**, try building `AnnoncePolicy` and wiring it into the controller yourself, based on module 07.5.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.
5. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Level 08 — Advanced Laravel](../../08-laravel-avance/README.en.md)
