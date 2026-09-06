# 02.2 — Héritage, interfaces et classes abstraites

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Utiliser l'héritage pour réutiliser du code entre classes proches.
- Comprendre et utiliser les interfaces.
- Comprendre et utiliser les classes abstraites.
- Savoir choisir entre héritage, interface et composition.

## 📋 Prérequis

[02.1 — POO : les bases](../01-poo-bases/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### L'héritage : `extends`

L'héritage permet à une classe (la classe **fille**) de réutiliser les propriétés et méthodes d'une autre classe (la classe **mère**).

```php
<?php
declare(strict_types=1);

class Animal {
    public function __construct(
        protected string $nom,
    ) {
    }

    public function seDeplacer(): string {
        return "$this->nom se déplace.";
    }
}

class Oiseau extends Animal {
    public function voler(): string {
        return "$this->nom vole dans le ciel.";
    }
}

$oiseau = new Oiseau("Perroquet");
echo $oiseau->seDeplacer(); // Perroquet se déplace. (méthode héritée)
echo $oiseau->voler();      // Perroquet vole dans le ciel. (méthode propre)
```

> 📌 Remarquez `protected` plutôt que `private` sur `$nom` : une propriété `private` ne serait **pas accessible** depuis `Oiseau`, même en héritant de `Animal`. `protected` autorise l'accès depuis la classe elle-même **et** ses classes filles.

### Redéfinir une méthode (`override`) et `parent::`

```php
<?php
class Animal {
    public function __construct(protected string $nom) {}

    public function crier(): string {
        return "$this->nom fait un bruit.";
    }
}

class Chien extends Animal {
    public function crier(): string {
        return "$this->nom aboie."; // redéfinit complètement la méthode parente
    }
}

class Chat extends Animal {
    public function crier(): string {
        // parent:: appelle explicitement la méthode de la classe parente
        return parent::crier() . " Enfin, plutôt il miaule.";
    }
}
```

### Les interfaces : définir un contrat

Une interface définit **ce qu'une classe doit savoir faire**, sans dire **comment**. Une classe peut implémenter plusieurs interfaces (contrairement à l'héritage, limité à une seule classe mère).

```php
<?php
interface Payable {
    public function calculerMontant(): float;
}

class Facture implements Payable {
    public function __construct(private float $montantHT) {}

    public function calculerMontant(): float {
        return $this->montantHT * 1.20;
    }
}

class Abonnement implements Payable {
    public function __construct(private float $prixMensuel, private int $mois) {}

    public function calculerMontant(): float {
        return $this->prixMensuel * $this->mois;
    }
}

// La fonction ne se soucie pas du type CONCRET, seulement qu'il respecte le contrat Payable
function afficherMontant(Payable $element): void {
    echo "Montant à payer : " . $element->calculerMontant() . " €\n";
}

afficherMontant(new Facture(100));
afficherMontant(new Abonnement(9.99, 12));
```

> 💡 C'est le principe du **polymorphisme** : une même fonction (`afficherMontant`) traite différents types d'objets (`Facture`, `Abonnement`) de façon uniforme, du moment qu'ils respectent le même contrat. Vous retrouverez ce principe partout dans Laravel (les Contracts, l'injection de dépendances).

### Les classes abstraites

Une classe abstraite **ne peut pas être instanciée directement** — elle sert de base commune, en imposant certaines méthodes à implémenter dans les classes filles.

```php
<?php
abstract class FormeGeometrique {
    // Méthode abstraite : chaque classe fille DOIT l'implémenter
    abstract public function calculerAire(): float;

    // Méthode concrète : héritée telle quelle par toutes les classes filles
    public function decrire(): string {
        return "Cette forme a une aire de " . $this->calculerAire() . " m².";
    }
}

class Rectangle extends FormeGeometrique {
    public function __construct(private float $largeur, private float $hauteur) {}

    public function calculerAire(): float {
        return $this->largeur * $this->hauteur;
    }
}

class Cercle extends FormeGeometrique {
    public function __construct(private float $rayon) {}

    public function calculerAire(): float {
        return M_PI * $this->rayon ** 2;
    }
}

// new FormeGeometrique(); // Erreur : impossible d'instancier une classe abstraite

$rectangle = new Rectangle(4, 5);
echo $rectangle->decrire(); // Cette forme a une aire de 20 m².
```

### Interface vs classe abstraite vs héritage simple : comment choisir ?

| Situation | Solution |
|---|---|
| Des classes très proches, qui partagent beaucoup de code | Héritage simple (`extends`) |
| Un "contrat" que plusieurs classes non liées doivent respecter | Interface (`implements`) |
| Une base commune avec du code partagé **et** des méthodes à forcer | Classe abstraite |
| Une classe a besoin de respecter plusieurs contrats différents | Plusieurs interfaces (`implements A, B`) |

## ✅ Points clés à retenir

- `extends` pour hériter d'une classe, `implements` pour respecter une interface (plusieurs possibles).
- `protected` est visible dans les classes filles, contrairement à `private`.
- Une classe abstraite ne s'instancie jamais directement, et peut forcer certaines méthodes via `abstract`.
- Le polymorphisme permet d'écrire du code générique qui fonctionne avec plusieurs types d'objets partageant un même contrat.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.oop5.inheritance.php](https://www.php.net/manual/fr/language.oop5.inheritance.php)
- [php.net/manual/fr/language.oop5.interfaces.php](https://www.php.net/manual/fr/language.oop5.interfaces.php)
- [php.net/manual/fr/language.oop5.abstract.php](https://www.php.net/manual/fr/language.oop5.abstract.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.1 — POO : les bases](../01-poo-bases/README.md) · **Suite :** [02.3 — POO avancée : traits, static, méthodes magiques](../03-poo-avancee-traits-static-magic-methods/README.md)
