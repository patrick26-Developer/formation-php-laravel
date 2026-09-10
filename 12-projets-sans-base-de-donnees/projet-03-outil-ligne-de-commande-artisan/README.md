# Projet : Outil CLI avec Artisan

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Créer une commande Artisan personnalisée qui analyse les fichiers de logs (module 11.5) et affiche un résumé par niveau de gravité — un rappel qu'Artisan (module 06.1) est un framework CLI généraliste, pas seulement un outil pour `make:model` et `migrate`, et que toutes ses commandes n'impliquent pas forcément la base de données.

## 📋 Modules mobilisés

- [06.1 — Installation de Laravel et Artisan](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.md)
- [11.5 — Monitoring et gestion des logs](../../11-devops-docker-cicd-avance/05-monitoring-logs/README.md)
- [08.3 — Tests avec Pest et PHPUnit dans Laravel](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md) (tester une commande Artisan)

## 🧠 Ce que vous allez apprendre

- Créer une commande Artisan avec arguments et options (`{chemin?}`, `{--niveau=}`).
- Utiliser `$this->table()`, `$this->error()`, `$this->warn()` pour une sortie console lisible, sans gérer manuellement le formatage.
- Retourner des codes de sortie explicites (`self::SUCCESS`/`self::FAILURE`), exploitables par un script shell ou un pipeline CI/CD (module 11.3).
- Tester une commande Artisan avec `$this->artisan()` et ses assertions dédiées (`expectsOutputToContain`, `assertExitCode`).
- Planifier une commande avec le scheduler Laravel (`routes/console.php`).

## 📂 Structure du projet

Fichiers à ajouter à un projet Laravel fraîchement installé :

```
projet-03-outil-ligne-de-commande-artisan/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── app/Console/Commands/AnalyserLogsCommand.php
├── routes/console.php
└── tests/Feature/AnalyserLogsCommandTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md).
3. [JOURNAL.md](JOURNAL.md) — la démarche de construction.
4. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 13 — Grands projets minimaux complets](../../13-grands-projets/README.md)
