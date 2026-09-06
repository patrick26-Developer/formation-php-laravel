# 03.1 — Design patterns en PHP

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre ce qu'est un design pattern et pourquoi les utiliser.
- Implémenter les patterns Factory, Strategy, Observer et Repository en PHP.
- Reconnaître ces patterns dans du code existant, notamment dans Laravel.

## 📋 Prérequis

[Niveau 02 — PHP Intermédiaire](../../02-php-intermediaire/README.md) complété.

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Qu'est-ce qu'un design pattern ?

Un **design pattern** (patron de conception) est une solution éprouvée à un problème de conception logicielle récurrent. Ce ne sont pas des règles à appliquer partout systématiquement, mais des solutions à **reconnaître** quand le problème qu'elles résolvent se présente. Vous en avez déjà rencontré deux : le **Singleton** ([module 02.3](../../02-php-intermediaire/03-poo-avancee-traits-static-magic-methods/README.md)) et le **Repository** ([module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)).

### Factory : centraliser la création d'objets

Une **Factory** (fabrique) encapsule la logique de création d'objets, surtout quand cette création dépend d'une condition.

```php
<?php
declare(strict_types=1);

interface MoyenPaiement {
    public function payer(float $montant): string;
}

class PaiementCarte implements MoyenPaiement {
    public function payer(float $montant): string {
        return "Paiement de $montant€ par carte bancaire";
    }
}

class PaiementPaypal implements MoyenPaiement {
    public function payer(float $montant): string {
        return "Paiement de $montant€ via PayPal";
    }
}

class MoyenPaiementFactory {
    public static function creer(string $type): MoyenPaiement {
        return match ($type) {
            'carte' => new PaiementCarte(),
            'paypal' => new PaiementPaypal(),
            default => throw new InvalidArgumentException("Moyen de paiement inconnu : $type"),
        };
    }
}

$paiement = MoyenPaiementFactory::creer('carte');
echo $paiement->payer(49.99);
```

> 💡 L'intérêt : le code appelant n'a jamais besoin de connaître les classes concrètes (`PaiementCarte`, `PaiementPaypal`) ni leur logique de construction — il demande juste "un moyen de paiement de type carte" à la Factory.

### Strategy : rendre un comportement interchangeable

Le pattern **Strategy** permet de choisir un algorithme/comportement à l'exécution, en l'encapsulant derrière une interface commune.

```php
<?php
interface StrategieRemise {
    public function calculer(float $montant): float;
}

class RemiseFixe implements StrategieRemise {
    public function __construct(private float $montantRemise) {}

    public function calculer(float $montant): float {
        return max(0, $montant - $this->montantRemise);
    }
}

class RemisePourcentage implements StrategieRemise {
    public function __construct(private float $pourcentage) {}

    public function calculer(float $montant): float {
        return $montant * (1 - $this->pourcentage / 100);
    }
}

class Panier {
    public function __construct(private StrategieRemise $strategie) {}

    public function calculerTotal(float $montantBrut): float {
        return $this->strategie->calculer($montantBrut);
    }
}

$panierAvecRemiseFixe = new Panier(new RemiseFixe(10));
echo $panierAvecRemiseFixe->calculerTotal(100); // 90

$panierAvecPourcentage = new Panier(new RemisePourcentage(20));
echo $panierAvecPourcentage->calculerTotal(100); // 80
```

> 📌 Remarquez que `Panier` ne connaît **jamais** le type concret de la stratégie : c'est exactement le même principe de polymorphisme vu au [module 02.2](../../02-php-intermediaire/02-poo-heritage-interfaces-abstraction/README.md), appliqué ici pour rendre un comportement métier interchangeable.

### Observer : réagir à des événements

Le pattern **Observer** permet à un objet ("le sujet") de notifier automatiquement d'autres objets ("les observateurs") quand quelque chose se produit, sans que le sujet ait besoin de connaître leur logique interne.

```php
<?php
interface Observateur {
    public function notifier(string $evenement): void;
}

class EnvoiEmailObservateur implements Observateur {
    public function notifier(string $evenement): void {
        echo "Email envoyé pour l'événement : $evenement\n";
    }
}

class JournalisationObservateur implements Observateur {
    public function notifier(string $evenement): void {
        echo "[LOG] Événement enregistré : $evenement\n";
    }
}

class GestionnaireCommande {
    /** @var Observateur[] */
    private array $observateurs = [];

    public function ajouterObservateur(Observateur $observateur): void {
        $this->observateurs[] = $observateur;
    }

    public function validerCommande(): void {
        // ... logique métier de validation ...
        foreach ($this->observateurs as $observateur) {
            $observateur->notifier("commande_validee");
        }
    }
}

$gestionnaire = new GestionnaireCommande();
$gestionnaire->ajouterObservateur(new EnvoiEmailObservateur());
$gestionnaire->ajouterObservateur(new JournalisationObservateur());
$gestionnaire->validerCommande();
```

> 📌 Ce pattern est la base conceptuelle du système **Events/Listeners** de Laravel, vu au [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md) : Laravel automatise exactement ce mécanisme.

### Repository : rappel

Déjà construit en pratique au [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) (`TacheRepository`, `LivreRepository`) : ce pattern isole toute la logique d'accès aux données (SQL) derrière une interface orientée métier, pour que le reste de l'application n'ait jamais à écrire de SQL directement.

## ✅ Points clés à retenir

- Un design pattern est une solution nommée et reconnaissable à un problème de conception récurrent, pas une règle à appliquer partout.
- **Factory** : centralise la création d'objets selon une condition.
- **Strategy** : rend un algorithme/comportement interchangeable via une interface commune.
- **Observer** : notifie plusieurs objets d'un événement sans coupler le sujet à leur logique.
- Ces patterns reposent tous sur les mêmes bases : interfaces et polymorphisme (niveau 02).

## ➡️ Pour aller plus loin

- [refactoring.guru/fr/design-patterns](https://refactoring.guru/fr/design-patterns) — référence visuelle très complète sur les design patterns
- [Module 03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 02 — PHP Intermédiaire](../../02-php-intermediaire/README.md) · **Suite :** [03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md)
