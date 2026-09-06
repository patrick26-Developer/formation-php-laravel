# Installation

## Prérequis

- PHP 8.3+ avec les extensions `pdo_mysql` et `pdo_sqlite` (cette dernière pour les tests).
- [Composer](https://getcomposer.org) installé (voir [00.2](../../00-introduction/02-installation-environnement/README.md)).
- Un serveur MySQL/MariaDB (pour l'application elle-même — les tests, eux, n'en ont pas besoin).

## Étapes

### 1. Installer les dépendances

```bash
composer install
```

Cette commande installe PHPUnit (défini en `require-dev` dans `composer.json`) et génère l'autoloading PSR-4 (`vendor/autoload.php`), qui permet à `App\Core\Routeur`, `App\Models\TacheRepository`, etc. d'être chargées automatiquement sans le moindre `require_once` manuel — la mécanique vue au [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md), enfin appliquée en conditions réelles.

### 2. Créer la base de données

```bash
mysql -u root -p < sql/schema.sql
```

### 3. Configurer la connexion

```bash
cp config.example.php config.php
```

Ajustez `config.php` selon votre installation locale.

## Vérification

Passez à [EXECUTION.md](EXECUTION.md) pour lancer le serveur, les tests, et essayer l'API.
