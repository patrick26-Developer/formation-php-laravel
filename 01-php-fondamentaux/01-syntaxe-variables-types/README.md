# 01.1 — Syntaxe, variables et types

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Écrire et exécuter un script PHP valide.
- Déclarer des variables et comprendre les règles de nommage.
- Connaître les types de données PHP et savoir les identifier.
- Comprendre le typage dynamique et la conversion de types.

## 📋 Prérequis

[Niveau 00 — Introduction](../../00-introduction/README.md) complété.

## ⏱️ Durée estimée

1h30 (théorie + exercices).

## 📖 Théorie

### La balise PHP

Un script PHP s'écrit entre `<?php` et `?>`. Dans un fichier purement PHP (sans HTML mélangé), on omet généralement la balise fermante :

```php
<?php

echo "Bonjour tout le monde";
```

Chaque instruction se termine par un **point-virgule** `;`. L'oublier est l'erreur la plus fréquente chez les débutants.

### Les commentaires

```php
<?php

// Commentaire sur une seule ligne

# Autre syntaxe pour un commentaire sur une ligne

/*
   Commentaire
   sur plusieurs lignes
*/
```

### Les variables

En PHP, une variable commence toujours par le symbole `$`, suivi d'un nom :

```php
<?php

$prenom = "Alice";
$age = 28;
$estActif = true;
```

Règles de nommage :

- Doit commencer par une lettre ou un underscore (`_`), jamais par un chiffre.
- Peut contenir lettres, chiffres, underscores après le premier caractère.
- **Sensible à la casse** : `$nom` et `$Nom` sont deux variables différentes.
- Convention de cette formation : `camelCase` pour les variables (`$dateNaissance`, pas `$date_naissance`), sauf pour les tableaux issus de bases de données où `snake_case` peut apparaître naturellement.

### Le typage dynamique

PHP est un langage à **typage dynamique** : vous n'indiquez pas le type d'une variable à sa déclaration, PHP le déduit de la valeur assignée — et ce type peut changer si vous réassignez une valeur différente.

```php
<?php

$valeur = 10;        // $valeur est un entier (int)
$valeur = "dix";      // $valeur est maintenant une chaîne (string)
```

> ⚠️ Ce comportement est pratique pour débuter, mais peut causer des bugs silencieux dans de gros projets. PHP moderne permet d'ajouter des **types stricts** (vu en détail dans les modules suivants sur les fonctions et la POO), une pratique recommandée en production.

### Les types scalaires

| Type | Exemple | Description |
|---|---|---|
| `int` | `$age = 28;` | Nombre entier |
| `float` | `$prix = 19.99;` | Nombre à virgule flottante |
| `string` | `$nom = "Alice";` | Chaîne de caractères |
| `bool` | `$estActif = true;` | Booléen (`true` ou `false`) |

### Les types composés

| Type | Exemple | Description |
|---|---|---|
| `array` | `$fruits = ["pomme", "poire"];` | Tableau (vu en détail au [module 01.5](../05-tableaux/README.md)) |
| `object` | instance de classe | Objet (vu en détail au [niveau 02](../../02-php-intermediaire/README.md)) |

### Les types spéciaux

| Type | Exemple | Description |
|---|---|---|
| `null` | `$valeur = null;` | Absence de valeur |

### Vérifier et convertir les types

```php
<?php

$age = "28"; // string

var_dump($age);        // affiche : string(2) "28"
echo gettype($age);    // affiche : string

$ageEntier = (int) $age; // conversion explicite (casting)
var_dump($ageEntier);    // affiche : int(28)
```

Fonctions utiles pour tester un type :

```php
<?php

is_int(28);       // true
is_string("28");  // true
is_bool(true);    // true
is_array([1, 2]); // true
is_null(null);    // true
```

### Afficher une valeur

Trois façons courantes d'afficher une valeur, avec des usages différents :

```php
<?php

$nom = "Alice";

echo "Bonjour " . $nom;          // echo : affichage simple, concaténation avec .
echo "Bonjour $nom";             // interpolation directe dans une chaîne entre guillemets doubles
print_r(["a", "b", "c"]);        // print_r : pour visualiser le contenu d'un tableau ou objet
var_dump($nom);                  // var_dump : affiche aussi le type et la longueur, utile en débogage
```

> 📌 `echo` avec des guillemets **simples** (`'Bonjour $nom'`) n'interprète pas les variables : le texte `$nom` s'affichera tel quel. Utilisez des guillemets **doubles** pour l'interpolation.

### Les constantes

Une constante ne peut pas être modifiée après sa définition :

```php
<?php

define('TVA', 0.20);
// ou, syntaxe moderne recommandée :
const TVA_TAUX = 0.20;

echo TVA_TAUX; // pas de symbole $ pour une constante
```

## 💡 Exemple complet

```php
<?php

// Informations sur un produit
$nomProduit = "Clavier mécanique";
$prixHT = 49.99;
const TVA = 0.20;

$prixTTC = $prixHT * (1 + TVA);

echo "Produit : $nomProduit\n";
echo "Prix TTC : " . round($prixTTC, 2) . " €\n";
```

## ✅ Points clés à retenir

- Toute instruction PHP se termine par `;`.
- Une variable commence par `$`, est sensible à la casse, et son type est déduit automatiquement.
- PHP possède 4 types scalaires (`int`, `float`, `string`, `bool`), les tableaux, les objets, et `null`.
- `gettype()` et `var_dump()` servent à inspecter le type réel d'une variable.
- Les guillemets doubles permettent l'interpolation de variables, les guillemets simples non.
- Une constante (`const`) ne change jamais de valeur après sa définition.

## ➡️ Pour aller plus loin

- Documentation officielle : [php.net/manual/fr/language.types.php](https://www.php.net/manual/fr/language.types.php)
- [ressources/cheatsheets/php-cheatsheet.md](../../ressources/cheatsheets/) — aide-mémoire des types et fonctions natives

## 📝 Exercices

Passez maintenant à [EXERCICES.md](EXERCICES.md) — **ne consultez `solutions/` qu'après avoir essayé chaque exercice.**

---

**Précédent :** [Niveau 00 — Introduction](../../00-introduction/README.md) · **Suite :** [01.2 — Opérateurs et structures de contrôle](../02-operateurs-structures-controle/README.md)
