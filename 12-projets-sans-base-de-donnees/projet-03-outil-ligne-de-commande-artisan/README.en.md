# Project: CLI Tool with Artisan

> **Status:** ✅ Available

## 🎯 Learning objective

Create a custom Artisan command that parses log files (module 11.5) and displays a summary by severity level — a reminder that Artisan (module 06.1) is a general-purpose CLI framework, not just a tool for `make:model` and `migrate`, and that not all its commands necessarily involve the database.

## 📋 Modules used

- [06.1 — Installing Laravel and Artisan](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.en.md)
- [11.5 — Monitoring and Log Management](../../11-devops-docker-cicd-avance/05-monitoring-logs/README.en.md)
- [08.3 — Testing with Pest and PHPUnit in Laravel](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md) (testing an Artisan command)

## 🧠 What you'll learn

- Create an Artisan command with arguments and options (`{chemin?}`, `{--niveau=}`).
- Use `$this->table()`, `$this->error()`, `$this->warn()` for readable console output, with no manual formatting to manage.
- Return explicit exit codes (`self::SUCCESS`/`self::FAILURE`), usable by a shell script or a CI/CD pipeline step (module 11.3).
- Test an Artisan command with `$this->artisan()` and its dedicated assertions (`expectsOutputToContain`, `assertExitCode`).
- Schedule a command with Laravel's scheduler (`routes/console.php`).

## 📂 Project structure

Files to add to a freshly installed Laravel project:

```
projet-03-outil-ligne-de-commande-artisan/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── app/Console/Commands/AnalyserLogsCommand.php
├── routes/console.php
└── tests/Feature/AnalyserLogsCommandTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md).
3. [JOURNAL.md](JOURNAL.en.md) — the build process.
4. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Level 13 — Complete Minimal Large Projects](../../13-grands-projets/README.en.md)
