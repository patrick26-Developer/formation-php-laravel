# Mini-projet : Plateforme d'annonces

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire une plateforme de petites annonces complète : authentification, autorisations (seul l'auteur modifie/supprime son annonce), upload d'images, favoris, et notifications — en assemblant **tous** les modules du Niveau 07 sur un cas réaliste, en reprenant la structure éprouvée du [blog du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md).

## 📋 Modules mobilisés

- [07.1 — Relations Eloquent avancées](../01-eloquent-relations-avancees/README.md) (`belongsToMany` pour les favoris)
- [07.2 — Scopes, accessors, mutators](../02-eloquent-scopes-accessors-mutators/README.md) (`scopeActives`, `imageUrl`)
- [07.4 — Authentification Breeze](../04-authentification-breeze-fortify/README.md)
- [07.5 — Policies et Gates](../05-autorisations-policies-gates/README.md) (`AnnoncePolicy`)
- [07.6 — Upload de fichiers et Storage](../06-upload-fichiers-storage/README.md)
- [07.7 — Notifications et emails](../07-notifications-mail/README.md) (notification au vendeur)

## 🧠 Ce que vous allez apprendre

- Combiner authentification (qui êtes-vous ?) et autorisation (que pouvez-vous faire ?) sur un vrai cas d'usage : n'importe qui peut consulter et contacter, seul le propriétaire peut modifier/supprimer sa propre annonce.
- Gérer un cycle de vie complet de fichier (upload à la création, remplacement à la modification, suppression automatique via Model Event à la suppression de l'annonce).
- Notifier un utilisateur (email + stockage en base) suite à une action d'un visiteur non connecté (le formulaire de contact).
- Utiliser une relation `belongsToMany` pour un système de favoris simple, sans données supplémentaires sur la table pivot.

## 📂 Structure du projet

Fichiers à ajouter à un projet Laravel **avec Breeze déjà installé** (voir [INSTALLATION.md](INSTALLATION.md)) :

```
projet-mini-04-plateforme-annonces/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/            # categories, annonces, messages, favorites
│   ├── factories/
│   └── seeders/AnnoncesSeeder.php
├── app/
│   ├── Models/                    # Category, Annonce, Message (+ ajouts à User)
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

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md) — installer Laravel + Breeze, copier ces fichiers, migrer, peupler.
2. [EXECUTION.md](EXECUTION.md) — parcourir la plateforme, tester les autorisations et les notifications.
3. **Avant de lire le code fourni**, essayez de construire vous-même `AnnoncePolicy` et son branchement dans le contrôleur, à partir du module 07.5.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 08 — Laravel Avancé](../../08-laravel-avance/README.md)
