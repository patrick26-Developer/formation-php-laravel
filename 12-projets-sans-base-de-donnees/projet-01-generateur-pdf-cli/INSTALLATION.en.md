# Installation

## Prerequisites

- PHP 8.3+, Composer (see [00.2](../../00-introduction/02-installation-environnement/README.en.md)).
- No database needed.

## Steps

```bash
composer install
```

Installs `dompdf/dompdf` and configures PSR-4 autoloading (`App\` → `src/`).

## Verification

```bash
composer test
```
*(or directly: `vendor/bin/phpunit tests`)*

Move on to [EXECUTION.md](EXECUTION.en.md).
