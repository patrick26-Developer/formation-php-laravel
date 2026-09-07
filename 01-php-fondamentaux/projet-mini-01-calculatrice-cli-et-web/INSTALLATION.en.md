# Installation

## Prerequisites

- PHP 8.3+ installed and accessible from the command line (`php -v` works). See [00.2 — Environment Setup](../../00-introduction/02-installation-environnement/README.en.md) if that's not the case yet.
- **No external dependency**: this project doesn't use Composer, it's plain native PHP.

## Setup

1. Copy or clone this `projet-mini-01-calculatrice-cli-et-web/` folder to your machine.
2. No further installation is needed — no `composer install`, no `.env` file, no database for this project.

## Verification

From the project folder, run:

```bash
php src/cli.php 4 + 4
```

If you get `4 + 4 = 8`, the installation is working.

**Next:** [EXECUTION.md](EXECUTION.en.md)
