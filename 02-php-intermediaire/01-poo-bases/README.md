# 02.1 — Programmation Orientée Objet : les bases

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre ce qu'est une classe et un objet.
- Créer des propriétés, des méthodes, un constructeur.
- Comprendre les niveaux de visibilité (`public`, `private`, `protected`).
- Utiliser `$this` pour référencer l'objet courant.

## 📋 Prérequis

[Niveau 01 — PHP Fondamentaux](../../01-php-fondamentaux/README.md) complété.

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Pourquoi la POO ?

Jusqu'ici, vous avez manipulé des données (tableaux, variables) et des fonctions séparément. La **programmation orientée objet** regroupe des données et les fonctions qui les manipulent au sein d'une même entité : un **objet**. C'est le paradigme utilisé par la quasi-totalité du code PHP moderne, et **entièrement** par Laravel : chaque modèle, contrôleur, service que vous écrirez plus tard est une classe.

### Déclarer une classe

```php
<?php
declare(strict_types=1);

class Utilisateur {
    // Propriétés : les données de l'objet
    public string $prenom;
    public string $email;
    private int $age;

    // Constructeur : appelé automatiquement à la création de l'objet
    public function __construct(string $prenom, string $email, int $age) {
        $this->prenom = $prenom;
        $this->email = $email;
        $this->age = $age;
    }

    // Méthode : une fonction appartenant à la classe
    public function seDefinir(): string {
        return "$this->prenom ($this->email), $this->age ans";
    }
}
```

`$this` fait référence à **l'instance courante** de l'objet : à l'intérieur d'une méthode, `$this->prenom` accède à la propriété `prenom` de l'objet sur lequel la méthode a été appelée.

### Créer un objet (instancier une classe)

```php
<?php
$utilisateur1 = new Utilisateur("Alice", "alice@example.com", 28);
$utilisateur2 = new Utilisateur("Bob", "bob@example.com", 35);

echo $utilisateur1->seDefinir(); // Alice (alice@example.com), 28 ans
echo $utilisateur1->prenom;      // Alice (accès direct, propriété publique)
```

`$utilisateur1` et `$utilisateur2` sont deux **instances** indépendantes de la même classe : chacune a ses propres valeurs de propriétés.

### Les niveaux de visibilité

| Visibilité | Accessible depuis... |
|---|---|
| `public` | N'importe où (à l'intérieur comme à l'extérieur de la classe) |
| `protected` | La classe elle-même et ses classes filles (héritage, voir [02.2](../02-poo-heritage-interfaces-abstraction/README.md)) |
| `private` | La classe elle-même **uniquement** |

```php
<?php
class CompteBancaire {
    private float $solde;

    public function __construct(float $soldeInitial) {
        $this->solde = $soldeInitial;
    }

    public function deposer(float $montant): void {
        $this->solde += $montant;
    }

    public function getSolde(): float {
        return $this->solde;
    }
}

$compte = new CompteBancaire(100);
$compte->deposer(50);
echo $compte->getSolde(); // 150

// $compte->solde;      // Erreur fatale : propriété privée, inaccessible depuis l'extérieur
// $compte->solde = 999; // impossible de "tricher" sur le solde directement
```

> ⚠️ **Règle de cette formation : les propriétés sont `private` par défaut**, sauf raison précise. On expose des **méthodes publiques** (`getSolde()`, `deposer()`) pour contrôler *comment* une propriété peut être lue ou modifiée, plutôt que de laisser n'importe quel code extérieur la modifier directement. C'est le principe d'**encapsulation**, un des piliers de la POO.

### Propriétés en constructeur promu (PHP 8+)

PHP 8 permet une syntaxe raccourcie très utilisée dans le code moderne (et dans Laravel) :

```php
<?php
class Utilisateur {
    public function __construct(
        private string $prenom,
        private string $email,
        private int $age,
    ) {
    }

    public function seDefinir(): string {
        return "$this->prenom ($this->email), $this->age ans";
    }
}
```

Cette syntaxe déclare **et** assigne les propriétés en une seule fois : plus besoin d'écrire `$this->prenom = $prenom;` pour chaque propriété.

### Propriétés en lecture seule (`readonly`, PHP 8.1+)

```php
<?php
class Point {
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {
    }
}

$point = new Point(3.5, 7.2);
echo $point->x; // 3.5
// $point->x = 10; // Erreur : impossible de modifier une propriété readonly après sa création
```

`readonly` garantit qu'une propriété ne peut être assignée **qu'une seule fois**, dans le constructeur — utile pour représenter des données qui ne doivent jamais changer après création de l'objet.

## ✅ Points clés à retenir

- Une **classe** est un modèle, un **objet** est une instance concrète de ce modèle.
- `$this` référence l'objet courant à l'intérieur d'une méthode.
- Préférez des propriétés `private` avec des méthodes publiques pour y accéder (encapsulation).
- La syntaxe de constructeur promu (`private string $prenom` directement dans les paramètres) est la norme en PHP moderne.
- `readonly` empêche la modification d'une propriété après sa création.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.oop5.php](https://www.php.net/manual/fr/language.oop5.php)
- [Module 02.2 — Héritage, interfaces, abstraction](../02-poo-heritage-interfaces-abstraction/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 01 — PHP Fondamentaux](../../01-php-fondamentaux/README.md) · **Suite :** [02.2 — Héritage, interfaces, abstraction](../02-poo-heritage-interfaces-abstraction/README.md)
