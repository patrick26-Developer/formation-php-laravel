# 01.8 — Fichiers, includes et organisation du code

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Lire et écrire des fichiers texte avec PHP.
- Utiliser `include`, `require` et leurs variantes `_once`.
- Organiser un projet PHP en plusieurs fichiers de façon cohérente.

## 📋 Prérequis

[01.7 — Formulaires HTML et GET/POST](../07-formulaires-http-get-post/README.md)

## ⏱️ Durée estimée

1h.

## 📖 Théorie

### Lire un fichier

```php
<?php
$contenu = file_get_contents("notes.txt"); // tout le fichier en une chaîne
echo $contenu;

$lignes = file("notes.txt"); // un tableau, une entrée par ligne
foreach ($lignes as $ligne) {
    echo trim($ligne) . "\n";
}
```

### Écrire dans un fichier

```php
<?php
file_put_contents("notes.txt", "Nouvelle ligne\n"); // écrase le contenu existant
file_put_contents("notes.txt", "Ligne ajoutée\n", FILE_APPEND); // ajoute à la fin
```

### Vérifier l'existence et manipuler les chemins

```php
<?php
if (file_exists("notes.txt")) {
    echo "Le fichier existe.";
}

// __DIR__ : le dossier du fichier PHP en cours d'exécution (chemin absolu)
$cheminAbsolu = __DIR__ . "/notes.txt";
```

> ⚠️ Utilisez toujours `__DIR__` pour construire des chemins vers d'autres fichiers de votre projet plutôt que des chemins relatifs comme `"../notes.txt"`. Un chemin relatif dépend du dossier depuis lequel le script est lancé, ce qui casse facilement dès qu'on inclut ce fichier depuis ailleurs.

### `include` vs `require`

```php
<?php
include "config.php";   // si le fichier n'existe pas : avertissement, le script continue
require "config.php";   // si le fichier n'existe pas : erreur fatale, le script s'arrête
```

> 📌 Règle de cette formation : utilisez **`require`** pour tout fichier indispensable au fonctionnement (configuration, fonctions utilisées ensuite). Réservez `include` aux cas où l'absence du fichier n'est pas bloquante (un bloc optionnel d'une page, par exemple).

### `_once` : éviter les inclusions multiples

```php
<?php
require_once "fonctions.php"; // n'inclut le fichier qu'une seule fois, même si appelé plusieurs fois
```

Sans `_once`, inclure deux fois un fichier qui déclare une fonction provoquerait une erreur fatale ("Cannot redeclare function"). **`require_once` est le standard à utiliser par défaut** pour tout fichier de déclarations (fonctions, classes, configuration).

### Organiser un petit projet multi-fichiers

Structure typique d'un mini-projet PHP sans framework :

```
mon-projet/
├── config.php        # constantes, paramètres
├── fonctions.php       # fonctions réutilisables
├── index.php            # point d'entrée
└── partials/
    ├── header.php
    └── footer.php
```

`fonctions.php` :
```php
<?php

function formaterPrix(float $prix): string {
    return number_format($prix, 2) . " €";
}
```

`index.php` :
```php
<?php
require_once __DIR__ . "/fonctions.php";

$prix = 19.9;
echo formaterPrix($prix); // 19.90 €
```

> 📌 Cette organisation manuelle par `require_once` est volontairement basique : elle vous fait comprendre le mécanisme d'inclusion avant de découvrir l'**autoloading** avec Composer au [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md), qui automatise complètement ce chargement de fichiers dans tout projet PHP moderne (et dans Laravel).

## ✅ Points clés à retenir

- `require_once` est le choix par défaut pour inclure des fichiers de déclarations.
- `__DIR__` évite les problèmes de chemins relatifs fragiles.
- `file_get_contents`/`file_put_contents` suffisent pour manipuler des fichiers texte simples.
- Séparer configuration, fonctions et point d'entrée est la première étape vers une architecture propre.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/function.require-once.php](https://www.php.net/manual/fr/function.require-once.php)
- [Module 02.7 — Composer, autoload, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.7 — Formulaires HTML et GET/POST](../07-formulaires-http-get-post/README.md) · **Suite :** [01.9 — Introduction à la gestion d'erreurs](../09-gestion-erreurs-debutant/README.md)
