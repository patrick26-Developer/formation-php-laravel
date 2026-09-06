# 02.4 — Gestion des exceptions

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la hiérarchie des exceptions PHP.
- Créer ses propres classes d'exceptions personnalisées.
- Capturer plusieurs types d'exceptions distinctement.
- Adopter de bonnes pratiques de gestion d'erreurs dans du code orienté objet.

## 📋 Prérequis

[02.3 — POO avancée : traits, static, méthodes magiques](../03-poo-avancee-traits-static-magic-methods/README.md) et [01.9 — Introduction à la gestion d'erreurs](../../01-php-fondamentaux/09-gestion-erreurs-debutant/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### La hiérarchie des exceptions PHP

Toutes les exceptions PHP héritent (directement ou indirectement) de l'interface `Throwable`. Les deux branches principales :

- **`Error`** et ses sous-classes (`TypeError`, `ValueError`, `DivisionByZeroError`...) : erreurs de programmation, généralement **non censées être rattrapées** en usage normal (un bug à corriger).
- **`Exception`** et ses sous-classes (`InvalidArgumentException`, `RuntimeException`, `LogicException`...) : erreurs "attendues" dans le déroulement normal d'un programme, que l'on **capture et gère**.

```php
<?php
try {
    $resultat = 10 / 0; // DivisionByZeroError en PHP 8+ (pas une simple Exception)
} catch (DivisionByZeroError $e) {
    echo "Erreur : " . $e->getMessage();
}
```

### Créer une exception personnalisée

Dans une vraie application, on crée des classes d'exceptions spécifiques à son métier, en héritant d'`Exception` :

```php
<?php
declare(strict_types=1);

class SoldeInsuffisantException extends Exception {
    public function __construct(
        private float $soldeDisponible,
        private float $montantDemande,
    ) {
        parent::__construct("Solde insuffisant : $soldeDisponible€ disponibles, $montantDemande€ demandés.");
    }

    public function getSoldeDisponible(): float {
        return $this->soldeDisponible;
    }

    public function getMontantDemande(): float {
        return $this->montantDemande;
    }
}

class CompteBancaire {
    public function __construct(private float $solde) {}

    public function retirer(float $montant): void {
        if ($montant > $this->solde) {
            throw new SoldeInsuffisantException($this->solde, $montant);
        }

        $this->solde -= $montant;
    }
}

$compte = new CompteBancaire(100);

try {
    $compte->retirer(500);
} catch (SoldeInsuffisantException $e) {
    echo $e->getMessage() . "\n";
    echo "Il manque : " . ($e->getMontantDemande() - $e->getSoldeDisponible()) . "€\n";
}
```

> 💡 L'intérêt d'une exception personnalisée : elle porte des **données structurées** sur l'erreur (ici `soldeDisponible` et `montantDemande`), pas seulement un message texte. Le code appelant peut réagir précisément selon le type d'exception attrapé.

### Capturer plusieurs types d'exceptions

```php
<?php
try {
    // ... code pouvant lever différentes exceptions
} catch (SoldeInsuffisantException $e) {
    echo "Problème de solde : " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo "Argument invalide : " . $e->getMessage();
} catch (Exception $e) {
    // Filet de sécurité : capture tout le reste (à placer TOUJOURS en dernier)
    echo "Erreur inattendue : " . $e->getMessage();
}
```

> ⚠️ L'ordre des blocs `catch` compte : PHP teste chaque bloc dans l'ordre et exécute le **premier** qui correspond. Un `catch (Exception $e)` placé en premier capturerait *tout*, empêchant les blocs plus spécifiques placés après de jamais s'exécuter.

Depuis PHP 8, on peut aussi capturer plusieurs types dans un seul bloc :

```php
<?php
try {
    // ...
} catch (SoldeInsuffisantException | InvalidArgumentException $e) {
    echo "Erreur de validation : " . $e->getMessage();
}
```

### Enchaîner les exceptions (`previous`)

Utile pour garder la trace de la cause originale quand on "traduit" une exception technique en exception métier :

```php
<?php
try {
    try {
        throw new RuntimeException("Erreur de connexion à la base de données");
    } catch (RuntimeException $erreurTechnique) {
        throw new Exception("Impossible de charger le profil utilisateur", 0, $erreurTechnique);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";                     // Impossible de charger le profil utilisateur
    echo $e->getPrevious()->getMessage() . "\n";        // Erreur de connexion à la base de données
}
```

## ✅ Points clés à retenir

- `Error` = bug de programmation (souvent non capturé), `Exception` = situation métier attendue (à capturer).
- Créer des exceptions personnalisées permet de transporter des données structurées sur l'erreur, pas seulement un texte.
- Ordonner les blocs `catch` du plus spécifique au plus général.
- `getPrevious()` permet de conserver la cause originale d'une erreur "traduite".

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.exceptions.php](https://www.php.net/manual/fr/language.exceptions.php)
- [php.net/manual/fr/spl.exceptions.php](https://www.php.net/manual/fr/spl.exceptions.php) — les exceptions SPL standard (`InvalidArgumentException`, `RuntimeException`, etc.)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.3 — POO avancée](../03-poo-avancee-traits-static-magic-methods/README.md) · **Suite :** [02.5 — Sessions, cookies, authentification maison](../05-sessions-cookies-authentification-maison/README.md)
