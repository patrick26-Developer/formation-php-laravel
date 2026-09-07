# Mini-project: Task Manager (CRUD PDO)

> **Status:** ✅ Available

## 🎯 Learning objective

Build a complete, realistic web application: personal task management, with **authentication**, **full CRUD**, **sorting**, **filtering**, and **search** — applying all of Level 02's modules together, with no framework at all.

## 📋 Modules used

- [02.1 to 02.3](../01-poo-bases/README.en.md) — OOP (classes, encapsulation, Singleton)
- [02.4](../04-gestion-exceptions/README.en.md) — Exception handling (`PDOException`)
- [02.5](../05-sessions-cookies-authentification-maison/README.en.md) — Session-based authentication
- [02.6](../06-securite-web-fondamentaux/README.en.md) — CSRF protection, XSS escaping, prepared statements
- [02.7](../07-composer-autoload-psr/README.en.md) — Code organization (this project deliberately does not use Composer yet, so you can clearly see the role of each `require_once` before it gets automated in level 03)
- [02.8 and 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.en.md) — PDO, Repository, CRUD, sort/filter/search/pagination

## 🧠 What you'll learn

- Assembling authentication, security, and CRUD into one coherent application, rather than as isolated building blocks.
- Structuring a PHP project with a clear separation between logic (`src/`) and the interface (`public/`).
- Applying the **"each user only sees their own data"** principle — every query in `TacheRepository` systematically filters by `utilisateur_id`.

## 📂 Project structure

```
projet-mini-02-gestion-taches-crud-pdo/
├── README.md              # this file
├── INSTALLATION.md          # setup (database, config)
├── EXECUTION.md               # launching and using the application
├── JOURNAL.md                    # step-by-step build process
├── RESSOURCES.md                    # useful links
├── config.example.php                 # configuration template (to be copied to config.php)
├── .gitignore                            # ignores config.php (never version-controlled)
├── sql/
│   └── schema.sql                          # table creation
└── src/
    ├── Database.php                          # PDO connection (Singleton)
    ├── Auth.php                                # session-based authentication
    ├── CsrfHelper.php                            # reusable CSRF protection
    ├── TacheRepository.php                         # CRUD + sort/filter/search/pagination
    ├── seed.php                                      # creates a demo user
    └── public/                                        # web entry point (to be served with php -S)
        ├── connexion.php
        ├── deconnexion.php
        ├── index.php                                    # task list (sort/filter/search/pagination)
        ├── creer.php
        ├── modifier.php
        └── supprimer.php
```

## 🚀 Getting started

1. Read [INSTALLATION.md](INSTALLATION.en.md) — database, configuration, dependencies (no Composer dependency here).
2. Read [EXECUTION.md](EXECUTION.en.md) to launch the application and log in.
3. **Before reading the provided code**, try building `TacheRepository::lister()` with sort/filter/search yourself, based on module 02.9.
4. Check [JOURNAL.md](JOURNAL.en.md) to see the full build process.

**Next in the path:** [Level 03 — Advanced PHP](../../03-php-avance/README.md) *(French only)*
