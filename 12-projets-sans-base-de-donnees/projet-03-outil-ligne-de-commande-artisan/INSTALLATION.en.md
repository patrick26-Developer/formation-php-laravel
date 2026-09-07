# Installation

## Prerequisites

- PHP 8.3+, Composer.
- No database needed (no migration to run for this project).

## Steps

### 1. Create a Laravel project

```bash
composer create-project laravel/laravel outil-logs
cd outil-logs
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### 2. Copy this project's files

Copy `app/Console/Commands/AnalyserLogsCommand.php`, merge
`routes/console.php` with the existing one, and copy `tests/Feature/`.

### 3. Verify the command is recognized

```bash
php artisan list logs
```
```
Available commands for the "logs" namespace:
  logs:analyser  Analyzes a Laravel log file and displays a summary by severity level.
```

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
