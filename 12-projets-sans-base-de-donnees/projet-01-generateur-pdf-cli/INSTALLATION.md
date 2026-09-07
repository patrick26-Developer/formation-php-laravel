# Installation

## Prérequis

- PHP 8.3+, Composer (voir [00.2](../../00-introduction/02-installation-environnement/README.md)).
- Aucune base de données nécessaire.

## Étapes

```bash
composer install
```

Installe `dompdf/dompdf` et configure l'autoloading PSR-4 (`App\` → `src/`).

## Vérification

```bash
composer test
```
*(ou directement : `vendor/bin/phpunit tests`)*

Passez à [EXECUTION.md](EXECUTION.md).
