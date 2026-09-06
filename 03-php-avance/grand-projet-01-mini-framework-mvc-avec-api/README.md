# Grand projet : Mini-framework MVC avec API

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Ce projet est le **point culminant du PHP sans framework** dans cette formation : construire un mini-framework MVC maison (routeur, contrôleurs, vues), l'utiliser pour servir à la fois des **pages web** et une **API REST JSON**, et le couvrir par des **tests automatisés** — en réutilisant tout ce qui a été appris depuis le niveau 01.

## 📋 Modules mobilisés

- [03.1 — Design patterns en PHP](../01-design-patterns-php/README.md) (Repository)
- [03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md) (Routeur, Contrôleurs, Vues)
- [03.3 — Tests unitaires avec PHPUnit](../03-tests-unitaires-phpunit/README.md)
- [03.4 — Construction d'une API REST en PHP natif](../04-construction-api-rest-php-natif/README.md)
- [02.7 — Composer, autoload, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md) (ce projet utilise Composer et l'autoloading PSR-4, contrairement au mini-projet du niveau 02)
- [02.9 — CRUD complet avec PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)

## 🧠 Ce que vous allez apprendre

- Faire cohabiter une interface web (HTML) et une API (JSON) **sans dupliquer la logique métier** : les deux contrôleurs (`TacheWebController`, `TacheApiController`) partagent le même `TacheRepository`.
- Écrire des tests unitaires rapides sans dépendre d'un vrai serveur MySQL, grâce à SQLite en mémoire.
- Reconnaître, dans une architecture que vous avez construite vous-même, chaque brique que vous retrouverez telle quelle dans Laravel : routeur ↔ `routes/web.php`, contrôleurs ↔ `app/Http/Controllers`, vues ↔ Blade, Repository ↔ Eloquent.

## 📂 Structure du projet

```
grand-projet-01-mini-framework-mvc-avec-api/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── composer.json                  # dépendances : PHPUnit en dev, autoload PSR-4 (App\ -> src/)
├── config.example.php
├── sql/schema.sql
├── phpunit.xml
├── src/
│   ├── Core/
│   │   ├── Routeur.php               # module 03.2 (+ middlewares du module 03.2 exercice 5)
│   │   ├── Vue.php
│   │   └── Reponse.php                 # helpers JSON du module 03.4
│   ├── Database.php
│   ├── Models/
│   │   └── TacheRepository.php           # module 02.9, réutilisé par les deux contrôleurs
│   └── Controllers/
│       ├── TacheWebController.php          # pages HTML
│       └── TacheApiController.php            # endpoints JSON
├── vues/taches/
│   ├── liste.php
│   └── creer.php
├── public/
│   └── index.php                               # front controller unique
└── tests/
    └── TacheRepositoryTest.php                   # PHPUnit + SQLite en mémoire
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md) — `composer install`, base de données, configuration.
2. [EXECUTION.md](EXECUTION.md) — lancer le serveur web, les tests, et tester l'API avec `curl`.
3. **Avant de lire le code fourni**, essayez de construire vous-même `Routeur` et `TacheApiController` à partir des modules 03.2 et 03.4.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction, dans l'ordre.

**Suite du parcours :** [Niveau 04 — Bases de données approfondies](../../04-bases-de-donnees-approfondi/README.md)
