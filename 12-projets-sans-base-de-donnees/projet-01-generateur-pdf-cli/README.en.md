# Project: Command-line PDF Generator

> **Status:** ✅ Available

## 🎯 Learning objective

Show that PHP remains fully relevant **without a database**: a CLI tool that reads a local CSV file and generates a PDF report, reusing only skills from levels 01 (files) and 03 (Composer, tests, clean architecture).

## 📋 Modules used

- [01.8 — Files, Includes and Code Organization](../../01-php-fondamentaux/08-fichiers-et-includes/README.en.md) (reading CSV)
- [02.7 — Composer, Autoloading, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md) (the `dompdf/dompdf` dependency)
- [03.3 — Unit Testing with PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.en.md)
- [03.5 — Best Practices, PSR-12 and Clean Code](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md) (single responsibility: `RapportGenerator` ONLY generates — CSV reading and PDF conversion are cleanly separated private methods)

## 🧠 What you'll learn

- Use a third-party Composer dependency (`dompdf/dompdf`) for a task PHP can't do natively.
- Read and parse a CSV file with native functions (`fopen`, `fgetcsv`).
- Systematically escape data before injecting it into HTML, even in an "internal" context (PDF generation) where you might be tempted to skip this protection.
- Test a class that produces a binary file (PDF), by checking its signature rather than its exact content.

## 📂 Project structure

```
projet-01-generateur-pdf-cli/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── composer.json
├── src/RapportGenerator.php
├── bin/generer-rapport.php
├── donnees/ventes.csv
└── tests/RapportGeneratorTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md).
3. [JOURNAL.md](JOURNAL.en.md) — the build process.
4. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Project: Consuming an External API](../projet-02-api-consommation-externe/README.en.md)
