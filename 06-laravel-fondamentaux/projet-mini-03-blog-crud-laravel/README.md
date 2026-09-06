# Mini-projet : Blog avec CRUD Laravel

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire un blog complet avec Laravel : articles classés par catégories, commentaires, et un CRUD complet avec tri, filtre, recherche et pagination — en appliquant tous les modules du Niveau 06 sur un cas réaliste, avec de vraies relations Eloquent (1-N à deux niveaux).

## 📋 Modules mobilisés

- [06.2 — Routing et Controllers](../02-routing-controllers/README.md) (Resource Controllers)
- [06.3 — Blade](../03-blade-templates/README.md) (layouts, partiels, composants)
- [06.4 — Eloquent ORM](../04-eloquent-orm-bases/README.md) (relations `belongsTo`/`hasMany`)
- [06.5 — Migrations, seeders, factories](../05-migrations-seeders-factories/README.md)
- [06.6 — Validation](../06-validation-formulaires/README.md) (Form Requests)
- [06.7 — CRUD complet](../07-crud-complet-laravel-tri-filtre-recherche/README.md) (tri, filtre, recherche, pagination)

## 🧠 Ce que vous allez apprendre

- Modéliser et implémenter deux relations 1-N imbriquées (`Category` → `Article` → `Comment`) avec Eloquent.
- Utiliser l'**eager loading** (`with()`) pour éviter le problème N+1 (module 03.6) lors de l'affichage de la liste d'articles avec leur catégorie.
- Factoriser un formulaire Blade partagé entre création et modification (`_form.blade.php`) plutôt que de dupliquer le code.
- Combiner recherche, filtre par catégorie, tri et pagination dans une seule méthode `index()` propre.

## 📂 Structure du projet

Ce dossier contient les fichiers **à ajouter à un projet Laravel fraîchement installé** (pas un projet Laravel complet en lui-même — voir [INSTALLATION.md](INSTALLATION.md)) :

```
projet-mini-03-blog-crud-laravel/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/           # categories, articles, comments
│   ├── factories/               # génération de données réalistes
│   └── seeders/BlogSeeder.php
├── app/
│   ├── Models/                    # Category, Article, Comment (avec relations)
│   └── Http/
│       ├── Controllers/             # ArticleController, CategoryController, CommentController
│       └── Requests/                  # StoreArticleRequest, UpdateArticleRequest
├── routes/web.php
└── resources/views/
    ├── layouts/app.blade.php
    ├── articles/                        # index, show, create, edit, _form (partiel partagé)
    └── categories/index.blade.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md) — créer le projet Laravel, copier ces fichiers, migrer et peupler la base.
2. [EXECUTION.md](EXECUTION.md) — lancer le serveur et parcourir le blog.
3. **Avant de lire le code fourni**, essayez de construire vous-même `ArticleController::index()` avec tri/filtre/recherche à partir du module 06.7.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.

**Suite du parcours :** [Niveau 07 — Laravel Intermédiaire](../../07-laravel-intermediaire/README.md)
