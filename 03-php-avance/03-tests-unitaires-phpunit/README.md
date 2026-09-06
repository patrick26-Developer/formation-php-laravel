# 03.3 — Tests unitaires avec PHPUnit

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre l'intérêt des tests automatisés.
- Installer et configurer PHPUnit dans un projet.
- Écrire des tests unitaires avec des assertions.
- Utiliser des doubles de test (mocks) pour isoler une unité de code.

## 📋 Prérequis

[03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md) et [02.7 — Composer, autoload, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Pourquoi tester automatiquement ?

Jusqu'ici, vous avez vérifié votre code "à la main" : exécuter un script, regarder le résultat, comparer avec ce qui était attendu. Cette approche ne s'accumule pas : chaque modification future du code impose de tout re-vérifier manuellement. Un **test automatisé** encode cette vérification une fois pour toutes, et peut être rejoué en une seconde, à chaque modification — c'est ce qui rendra possible le **CI/CD** ([niveau 05](../../05-outils-professionnels/README.md) et [11](../../11-devops-docker-cicd-avance/README.md)) : faire vérifier automatiquement votre code à chaque envoi sur GitHub.

### Installer PHPUnit

```bash
composer require --dev phpunit/phpunit
```

> 📌 `--dev` indique que PHPUnit n'est nécessaire qu'en développement, jamais en production — Composer sépare les deux catégories de dépendances.

Structure typique :
```
mon-projet/
├── composer.json
├── src/
│   └── Calculatrice.php
└── tests/
    └── CalculatriceTest.php
```

### Écrire un premier test

```php
<?php
declare(strict_types=1);

namespace App;

class Calculatrice {
    public function additionner(int $a, int $b): int {
        return $a + $b;
    }

    public function diviser(float $a, float $b): float {
        if ($b === 0.0) {
            throw new \InvalidArgumentException("Division par zéro impossible.");
        }

        return $a / $b;
    }
}
```

```php
<?php
declare(strict_types=1);

namespace App\Tests;

use App\Calculatrice;
use PHPUnit\Framework\TestCase;

class CalculatriceTest extends TestCase {
    public function testAdditionnerDeuxNombresPositifs(): void {
        $calculatrice = new Calculatrice();

        $resultat = $calculatrice->additionner(2, 3);

        $this->assertSame(5, $resultat);
    }

    public function testDiviserParZeroLeveUneException(): void {
        $calculatrice = new Calculatrice();

        $this->expectException(\InvalidArgumentException::class);

        $calculatrice->diviser(10, 0);
    }
}
```

Lancer les tests :
```bash
./vendor/bin/phpunit tests
```

### Les assertions les plus courantes

| Assertion | Vérifie que... |
|---|---|
| `assertSame($attendu, $reel)` | Les deux valeurs sont identiques (type ET valeur, équivalent à `===`) |
| `assertEquals($attendu, $reel)` | Les deux valeurs sont égales (équivalent à `==`, plus souple) |
| `assertTrue($valeur)` / `assertFalse($valeur)` | La valeur est bien `true`/`false` |
| `assertNull($valeur)` | La valeur est `null` |
| `assertCount($nombre, $tableau)` | Un tableau contient exactement ce nombre d'éléments |
| `assertInstanceOf($classe, $objet)` | L'objet est bien une instance de cette classe |

> 📌 Préférez `assertSame()` à `assertEquals()` par défaut : la comparaison stricte évite les faux positifs (par exemple, `assertEquals(1, "1")` passe, alors que ce sont deux types différents).

### La structure AAA (Arrange, Act, Assert)

Une bonne pratique pour structurer chaque test, même sans commentaires explicites :

```php
<?php
public function testCreerUneTache(): void {
    // Arrange : préparer le contexte du test
    $repository = new TacheRepositoryEnMemoire();

    // Act : exécuter l'action à tester
    $id = $repository->creer("Faire les courses");

    // Assert : vérifier le résultat
    $this->assertNotNull($repository->trouver($id));
}
```

### Isoler une unité de code avec des mocks

Un **test unitaire** doit tester une seule unité de code, **isolée** de ses dépendances (base de données, appels réseau...). PHPUnit fournit des objets "doublons" (mocks) pour simuler ces dépendances.

```php
<?php
declare(strict_types=1);

namespace App\Tests;

use App\ServiceNotification;
use App\EnvoyeurEmail;
use PHPUnit\Framework\TestCase;

class ServiceNotificationTest extends TestCase {
    public function testEnvoieUneNotificationParEmail(): void {
        // On crée un "faux" EnvoyeurEmail, sans jamais envoyer un VRAI email
        $envoyeurSimule = $this->createMock(EnvoyeurEmail::class);

        // On définit ce qu'on ATTEND de cette dépendance : qu'elle soit
        // appelée exactement une fois, avec ces arguments précis.
        $envoyeurSimule->expects($this->once())
            ->method('envoyer')
            ->with('alice@example.com', 'Bienvenue !');

        $service = new ServiceNotification($envoyeurSimule);
        $service->notifierBienvenue('alice@example.com');
    }
}
```

> 💡 L'intérêt : ce test vérifie le **comportement** de `ServiceNotification` (appelle-t-il correctement l'envoyeur ?) sans jamais envoyer de vrai email — rapide, fiable, reproductible, sans effet de bord.

## ✅ Points clés à retenir

- Un test automatisé encode une vérification une fois pour toutes, rejouable à volonté.
- Structure AAA : Arrange (préparer), Act (agir), Assert (vérifier).
- `assertSame()` par défaut, plus strict et plus sûr que `assertEquals()`.
- Un mock isole une unité de code de ses dépendances externes pour un vrai test **unitaire**.

## ➡️ Pour aller plus loin

- [phpunit.de/documentation.html](https://phpunit.de/documentation.html)
- [Module 08.3 — Tests avec Pest et PHPUnit dans Laravel](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md)
- [Module 05.4 — GitHub Actions : fondamentaux CI/CD](../../05-outils-professionnels/04-github-actions-ci-cd-fondamentaux/README.md) (lancer ces tests automatiquement à chaque push)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [03.2 — Architecture MVC from scratch](../02-architecture-mvc-from-scratch/README.md) · **Suite :** [03.4 — Construction d'une API REST en PHP natif](../04-construction-api-rest-php-natif/README.md)
