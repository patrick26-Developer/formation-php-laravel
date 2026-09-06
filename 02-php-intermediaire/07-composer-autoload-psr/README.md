# 02.7 — Composer, autoload et standards PSR

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle de Composer dans l'écosystème PHP.
- Installer et utiliser une dépendance externe.
- Comprendre et configurer l'autoloading PSR-4.
- Connaître les standards PSR essentiels à respecter.

## 📋 Prérequis

[02.6 — Sécurité web fondamentale](../06-securite-web-fondamentaux/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Qu'est-ce que Composer ?

Composer est le **gestionnaire de dépendances** de référence pour PHP. Il permet d'installer des librairies tierces (comme `npm` pour Node.js ou `pip` pour Python), et — c'est tout aussi important — de gérer **l'autoloading** de vos propres classes. **Laravel et la quasi-totalité de l'écosystème PHP moderne reposent sur Composer.**

### Initialiser un projet avec Composer

```bash
composer init
```

Cette commande crée un fichier `composer.json` interactif, décrivant votre projet et ses dépendances. Un exemple minimal :

```json
{
    "name": "votre-nom/mon-projet",
    "require": {
        "php": ">=8.3"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

### Installer une dépendance

```bash
composer require monolog/monolog
```

Cette commande télécharge la librairie dans un dossier `vendor/` (à ne **jamais** versionner dans Git — voir [00.3](../../00-introduction/03-git-github-essentiels/README.md)) et met à jour `composer.json` et `composer.lock` (ce dernier fixe les versions exactes installées, à versionner lui, pour garantir que toute l'équipe utilise les mêmes versions).

```bash
composer install    # installe les dépendances listées dans composer.json/composer.lock
composer update      # met à jour les dépendances vers leurs dernières versions compatibles
```

> 📌 `composer install` est la commande que vous utiliserez le plus souvent : c'est elle qui, dans **tout** projet de cette formation à partir de maintenant, sera l'étape "installer les dépendances" décrite dans le fichier `INSTALLATION.md` de chaque projet.

### L'autoloading PSR-4 : la fin des `require_once` manuels

Jusqu'ici (module 01.8), vous avez inclus vos fichiers manuellement avec `require_once`. Avec Composer, un simple `require` du fichier d'autoload suffit pour **tout** votre projet.

Structure de dossiers respectant PSR-4 :

```
mon-projet/
├── composer.json
├── src/
│   ├── Calculatrice.php     # namespace App;  class Calculatrice
│   └── Utilisateur.php       # namespace App;  class Utilisateur
└── index.php
```

`src/Calculatrice.php` :
```php
<?php
declare(strict_types=1);

namespace App;

class Calculatrice {
    public function additionner(int $a, int $b): int {
        return $a + $b;
    }
}
```

`index.php` :
```php
<?php
require __DIR__ . '/vendor/autoload.php'; // le SEUL require nécessaire pour tout le projet

use App\Calculatrice;

$calculatrice = new Calculatrice();
echo $calculatrice->additionner(2, 3);
```

Après toute modification de la correspondance namespace/dossier, régénérez l'autoload :

```bash
composer dump-autoload
```

> 📌 Le principe PSR-4 : le namespace `App\` correspond au dossier `src/`. Une classe `App\Services\EnvoiEmail` doit donc se trouver dans `src/Services/EnvoiEmail.php`. Composer utilise cette convention pour trouver et charger automatiquement la bonne classe, sans aucun `require` manuel.

### Les standards PSR : pourquoi s'y conformer ?

**PSR** (PHP Standards Recommendations) est un ensemble de recommandations établies par le **PHP-FIG**, un groupe représentant les principaux frameworks et projets PHP (dont Laravel, Symfony...). S'y conformer garantit que votre code s'intègre naturellement avec le reste de l'écosystème.

| Standard | Objet |
|---|---|
| **PSR-1** | Règles de base (encodage UTF-8, balises `<?php`, noms de classes en `PascalCase`...) |
| **PSR-4** | Convention d'autoloading (vue ci-dessus) |
| **PSR-12** | Style de code détaillé (indentation, emplacement des accolades, espacement) — approfondi au [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) |

## ✅ Points clés à retenir

- `composer install` installe les dépendances d'un projet à partir de son `composer.json`/`composer.lock`.
- `vendor/` ne se versionne jamais ; `composer.lock` se versionne toujours.
- PSR-4 fait correspondre un namespace à un dossier, permettant un autoloading automatique via `vendor/autoload.php`.
- Suivre les standards PSR rend votre code compatible avec l'écosystème PHP moderne, Laravel inclus.

## ➡️ Pour aller plus loin

- [getcomposer.org/doc/](https://getcomposer.org/doc/)
- [php-fig.org/psr/](https://www.php-fig.org/psr/) — liste complète des standards PSR

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.6 — Sécurité web fondamentale](../06-securite-web-fondamentaux/README.md) · **Suite :** [02.8 — PDO et bases de données MySQL](../08-pdo-bases-de-donnees-mysql/README.md)
