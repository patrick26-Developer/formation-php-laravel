# 03.5 — Bonnes pratiques, PSR-12 et Clean Code

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Connaître et appliquer les règles de style PSR-12.
- Comprendre les principes SOLID et leur intérêt pratique.
- Reconnaître et corriger les "code smells" les plus courants.
- Automatiser la vérification du style avec PHP-CS-Fixer.

## 📋 Prérequis

[03.4 — Construction d'une API REST en PHP natif](../04-construction-api-rest-php-natif/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### PSR-12 : le style de code standard

PSR-12 (introduit au [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md)) définit des règles précises de mise en forme. Les plus importantes au quotidien :

```php
<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Notifiable;

class GestionnaireNotification implements Notifiable
{
    public function __construct(
        private string $canal,
    ) {
    }

    public function envoyer(string $message): bool
    {
        if ($this->canal === 'email') {
            // ...
        }

        return true;
    }
}
```

Règles clés :
- L'accolade ouvrante `{` d'une **classe** ou d'une **méthode** est sur sa **propre ligne**.
- L'accolade ouvrante d'une structure de contrôle (`if`, `foreach`...) est sur la **même ligne**.
- Indentation de **4 espaces**, jamais de tabulations.
- Une seule instruction par ligne.
- `use` groupés en haut de fichier, après le `namespace`.

> 📌 Vous n'avez pas besoin de mémoriser chaque règle : un outil (PHP-CS-Fixer, vu plus bas) les applique automatiquement.

### Les principes SOLID (aperçu pratique)

| Principe | En une phrase |
|---|---|
| **S**ingle Responsibility | Une classe ne devrait avoir qu'**une seule raison de changer** |
| **O**pen/Closed | On devrait pouvoir étendre un comportement sans modifier le code existant |
| **L**iskov Substitution | Une classe fille doit pouvoir remplacer sa classe mère sans casser le programme |
| **I**nterface Segregation | Préférer plusieurs petites interfaces spécifiques à une seule grosse interface générale |
| **D**ependency Inversion | Dépendre d'abstractions (interfaces), pas d'implémentations concrètes |

Exemple de violation du **Single Responsibility** et sa correction :

```php
<?php
// ❌ Cette classe a DEUX raisons de changer : la logique métier ET l'envoi d'email
class InscriptionUtilisateur {
    public function inscrire(string $email, string $motDePasse): void {
        // ... validation, hachage, sauvegarde en base ...

        // Pourquoi une classe "Inscription" sait-elle envoyer des emails via mail() ?
        mail($email, "Bienvenue", "Merci de votre inscription !");
    }
}

// ✅ Chaque classe a une seule responsabilité, l'une utilise l'autre
class InscriptionUtilisateur {
    public function __construct(private ServiceEmail $serviceEmail) {}

    public function inscrire(string $email, string $motDePasse): void {
        // ... validation, hachage, sauvegarde en base ...

        $this->serviceEmail->envoyer($email, "Bienvenue", "Merci de votre inscription !");
    }
}
```

> 📌 Ce sujet est directement lié à l'exercice 5 du [module 03.3](../03-tests-unitaires-phpunit/README.md) : `InscriptionService` qui dépend de `ServiceEmail` (**Dependency Inversion** en germe) est plus facile à tester **et** plus facile à faire évoluer (changer de fournisseur d'email sans toucher à la logique d'inscription).

### Reconnaître les "code smells" courants

| Code smell | Symptôme | Remède |
|---|---|---|
| **Fonction trop longue** | Une méthode de 100+ lignes, difficile à comprendre d'un coup d'œil | Extraire des sous-méthodes bien nommées |
| **Nommage flou** | `$d`, `$data`, `traiter()` | Des noms qui décrivent précisément l'intention (`$dateExpiration`, `calculerRemiseFidelite()`) |
| **Duplication de code** | Le même bloc copié-collé à plusieurs endroits | Extraire une fonction/méthode partagée (voir le Repository, module 02.9) |
| **Nombres/chaînes magiques** | `if ($statut === 3)` sans explication | Utiliser une constante ou un enum nommé (`StatutCommande::Livree`, module 02.3) |
| **Commentaire qui explique du code confus** | `// vérifie si l'utilisateur peut...` au-dessus d'une condition à 5 opérateurs | Extraire la condition dans une méthode bien nommée (`$utilisateur->peutModifierCetArticle()`) |

### Automatiser avec PHP-CS-Fixer

```bash
composer require --dev friendsofphp/php-cs-fixer
```

```bash
./vendor/bin/php-cs-fixer fix src/ --rules=@PSR12
```

> 📌 Approfondi avec sa configuration complète au [module 05.5 — Qualité de code : PHPStan et PHP-CS-Fixer](../../05-outils-professionnels/05-qualite-code-phpstan-php-cs-fixer/README.md), où l'on verra aussi comment l'intégrer à un pipeline CI/CD.

## ✅ Points clés à retenir

- PSR-12 standardise la mise en forme ; un outil (PHP-CS-Fixer) l'applique automatiquement, pas besoin de la mémoriser.
- SOLID, et surtout le principe de responsabilité unique, guide vers des classes petites et faciles à tester.
- Le nommage explicite est souvent plus efficace qu'un commentaire pour rendre le code compréhensible.
- Un code smell n'est pas une erreur bloquante, mais un signal qu'un refactoring améliorerait la maintenabilité.

## ➡️ Pour aller plus loin

- [php-fig.org/psr/psr-12/](https://www.php-fig.org/psr/psr-12/)
- [Module 05.5 — Qualité de code : PHPStan et PHP-CS-Fixer](../../05-outils-professionnels/05-qualite-code-phpstan-php-cs-fixer/README.md)
- [Module 14.2 — Code review et refactoring](../../14-preparation-professionnelle/02-code-review-et-refactoring/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [03.4 — Construction d'une API REST en PHP natif](../04-construction-api-rest-php-natif/README.md) · **Suite :** [03.6 — Performance et optimisation PHP](../06-performance-et-optimisation/README.md)
