# Installation

## Prérequis

- PHP 8.3+, Composer.
- Aucune base de données nécessaire (aucune migration à exécuter pour ce projet).

## Étapes

### 1. Créer un projet Laravel

```bash
composer create-project laravel/laravel outil-logs
cd outil-logs
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### 2. Copier les fichiers de ce projet

Copiez `app/Console/Commands/AnalyserLogsCommand.php`, fusionnez
`routes/console.php` avec celui existant, et copiez `tests/Feature/`.

### 3. Vérifier que la commande est reconnue

```bash
php artisan list logs
```
```
Available commands for the "logs" namespace:
  logs:analyser  Analyse un fichier de log Laravel et affiche un résumé par niveau de gravité.
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
