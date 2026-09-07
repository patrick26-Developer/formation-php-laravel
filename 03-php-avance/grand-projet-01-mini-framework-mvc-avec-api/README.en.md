# Large Project: MVC Mini-Framework with API

> **Status:** ✅ Available

## 🎯 Learning objective

This project is the **culmination of framework-free PHP** in this training: build a homemade MVC mini-framework (router, controllers, views), use it to serve both **web pages** and a **JSON REST API**, and cover it with **automated tests** — reusing everything learned since level 01.

## 📋 Modules used

- [03.1 — Design Patterns in PHP](../01-design-patterns-php/README.en.md) (Repository)
- [03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.en.md) (Router, Controllers, Views)
- [03.3 — Unit Testing with PHPUnit](../03-tests-unitaires-phpunit/README.en.md)
- [03.4 — Building a REST API in Native PHP](../04-construction-api-rest-php-natif/README.en.md)
- [02.7 — Composer, Autoloading, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md) (this project uses Composer and PSR-4 autoloading, unlike the level 02 mini-project)
- [02.9 — Full CRUD with PDO](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md)

## 🧠 What you'll learn

- Making a web interface (HTML) and an API (JSON) coexist **without duplicating business logic**: both controllers (`TacheWebController`, `TacheApiController`) share the same `TacheRepository`.
- Writing fast unit tests without depending on a real MySQL server, thanks to in-memory SQLite.
- Recognizing, in an architecture you built yourself, every building block you'll find as-is in Laravel: router ↔ `routes/web.php`, controllers ↔ `app/Http/Controllers`, views ↔ Blade, Repository ↔ Eloquent.

## 📂 Project structure

```
grand-projet-01-mini-framework-mvc-avec-api/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── composer.json                  # dependencies: PHPUnit in dev, PSR-4 autoload (App\ -> src/)
├── config.example.php
├── sql/schema.sql
├── phpunit.xml
├── src/
│   ├── Core/
│   │   ├── Routeur.php               # module 03.2 (+ middlewares from module 03.2 exercise 5)
│   │   ├── Vue.php
│   │   └── Reponse.php                 # JSON helpers from module 03.4
│   ├── Database.php
│   ├── Models/
│   │   └── TacheRepository.php           # module 02.9, reused by both controllers
│   └── Controllers/
│       ├── TacheWebController.php          # HTML pages
│       └── TacheApiController.php            # JSON endpoints
├── vues/taches/
│   ├── liste.php
│   └── creer.php
├── public/
│   └── index.php                               # single front controller
└── tests/
    └── TacheRepositoryTest.php                   # PHPUnit + in-memory SQLite
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md) — `composer install`, database, configuration.
2. [EXECUTION.md](EXECUTION.en.md) — start the web server, run the tests, and test the API with `curl`.
3. **Before reading the provided code**, try building `Routeur` and `TacheApiController` yourself, based on modules 03.2 and 03.4.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process, in order.

**Next in the path:** [Level 04 — Databases in Depth](../../04-bases-de-donnees-approfondi/README.en.md)
