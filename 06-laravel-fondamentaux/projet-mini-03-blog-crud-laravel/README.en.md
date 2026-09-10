# Mini-project: Blog with Laravel CRUD

> **Status:** ✅ Available

## 🎯 Learning objective

Build a complete blog with Laravel: articles organized by categories, comments, and a full CRUD with sorting, filtering, search, and pagination — applying every Level 06 module to a realistic case, with real Eloquent relationships (two-level 1-N).

## 📋 Modules used

- [06.2 — Routing and Controllers](../02-routing-controllers/README.en.md) (Resource Controllers)
- [06.3 — Blade](../03-blade-templates/README.en.md) (layouts, partials, components)
- [06.4 — Eloquent ORM](../04-eloquent-orm-bases/README.en.md) (`belongsTo`/`hasMany` relationships)
- [06.5 — Migrations, Seeders, Factories](../05-migrations-seeders-factories/README.en.md)
- [06.6 — Validation](../06-validation-formulaires/README.en.md) (Form Requests)
- [06.7 — Full CRUD](../07-crud-complet-laravel-tri-filtre-recherche/README.en.md) (sort, filter, search, pagination)

## 🧠 What you'll learn

- Modeling and implementing two nested 1-N relationships (`Category` → `Article` → `Comment`) with Eloquent.
- Using **eager loading** (`with()`) to avoid the N+1 problem (module 03.6) when displaying the article list with its category.
- Factoring a Blade form shared between creation and editing (`_form.blade.php`) instead of duplicating code.
- Combining search, category filter, sort, and pagination into a single, clean `index()` method.

## 📂 Project structure

This folder contains the files **to add to a freshly installed Laravel project** (not a complete Laravel project on its own — see [INSTALLATION.md](INSTALLATION.en.md)):

```
projet-mini-03-blog-crud-laravel/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/           # categories, articles, comments
│   ├── factories/               # realistic data generation
│   └── seeders/BlogSeeder.php
├── app/
│   ├── Models/                    # Category, Article, Comment (with relationships)
│   └── Http/
│       ├── Controllers/             # ArticleController, CategoryController, CommentController
│       └── Requests/                  # StoreArticleRequest, UpdateArticleRequest
├── routes/web.php
└── resources/views/
    ├── layouts/app.blade.php
    ├── articles/                        # index, show, create, edit, _form (shared partial)
    └── categories/index.blade.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md) — create the Laravel project, copy these files, migrate and seed the database.
2. [EXECUTION.md](EXECUTION.en.md) — start the server and browse the blog.
3. **Before reading the provided code**, try building `ArticleController::index()` with sort/filter/search yourself, based on module 06.7.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.
5. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Level 07 — Intermediate Laravel](../../07-laravel-intermediaire/README.en.md)
