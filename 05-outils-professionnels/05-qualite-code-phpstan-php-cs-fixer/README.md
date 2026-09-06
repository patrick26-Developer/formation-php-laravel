# 05.5 — Qualité de code : PHPStan et PHP-CS-Fixer

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Installer et configurer PHP-CS-Fixer pour appliquer PSR-12 automatiquement.
- Installer et configurer PHPStan pour détecter des bugs sans exécuter le code.
- Comprendre les niveaux d'analyse de PHPStan.
- Intégrer ces deux outils dans le pipeline CI/CD.

## 📋 Prérequis

[05.4 — GitHub Actions : fondamentaux CI/CD](../04-github-actions-ci-cd-fondamentaux/README.md) et [03.5 — Bonnes pratiques, PSR-12, Clean Code](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### PHP-CS-Fixer : formater automatiquement

Introduit au [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md), voyons maintenant sa configuration complète.

```bash
composer require --dev friendsofphp/php-cs-fixer
```

Fichier de configuration `.php-cs-fixer.php` à la racine du projet :

```php
<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'], // impose [] plutôt que array()
        'no_unused_imports' => true,               // retire les "use" inutilisés
        'ordered_imports' => true,                   // trie les "use" alphabétiquement
        'trailing_comma_in_multiline' => true,         // virgule finale sur les tableaux multi-lignes
    ])
    ->setFinder($finder);
```

```bash
./vendor/bin/php-cs-fixer fix           # corrige automatiquement les fichiers
./vendor/bin/php-cs-fixer fix --dry-run --diff  # affiche ce qui serait corrigé, sans modifier (pour la CI)
```

### PHPStan : détecter des bugs sans exécuter le code

**PHPStan** est un outil d'**analyse statique** : il lit votre code sans l'exécuter et détecte des incohérences de types, des appels de méthodes inexistantes, des variables potentiellement `null` non vérifiées, etc.

```bash
composer require --dev phpstan/phpstan
```

```php
<?php
declare(strict_types=1);

function trouverUtilisateur(int $id): ?array {
    // ... peut retourner null si non trouvé ...
    return null;
}

$utilisateur = trouverUtilisateur(5);
echo $utilisateur['nom']; // PHPStan signale : "Cannot access offset 'nom' on array|null"
```

Sans PHPStan, ce bug ne serait découvert qu'à l'exécution (si `trouverUtilisateur` retourne effectivement `null` un jour). PHPStan le détecte **avant même de lancer le code**.

### Les niveaux d'analyse

PHPStan propose des niveaux de rigueur croissants, de `0` (vérifications basiques) à `9` (le plus strict) :

```neon
# phpstan.neon
parameters:
    level: 5
    paths:
        - src
```

```bash
./vendor/bin/phpstan analyse
```

> 📌 Conseil pratique : démarrer un **nouveau** projet directement au niveau 6-8. Sur un projet **existant** sans analyse statique préalable, démarrer au niveau 0-2 et augmenter progressivement évite d'être submergé par des centaines d'erreurs d'un coup.

### Exemple d'erreurs typiques détectées

```php
<?php
declare(strict_types=1);

class TacheRepository {
    public function trouver(int $id): ?array {
        // ...
    }
}

$repository = new TacheRepository();
$tache = $repository->trouver(1);

echo $tache['titre'];
// PHPStan (niveau 5+) : "Cannot access offset 'titre' on array|null."
// -> force à vérifier explicitement : if ($tache !== null) { ... }

$repository->modifer(1); // faute de frappe : "modifer" au lieu de "modifier"
// PHPStan : "Call to an undefined method TacheRepository::modifer()."
// -> détecté SANS exécuter le code, alors qu'une faute de frappe dans un
// chemin de code peu testé pourrait rester invisible pendant longtemps.
```

### Intégrer les deux outils au pipeline CI (module 05.4)

```yaml
      - name: Vérifier le style PSR-12
        run: ./vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: Analyse statique PHPStan
        run: ./vendor/bin/phpstan analyse
```

> 📌 Avec ces deux étapes dans le pipeline, aucun code non conforme au style ou contenant une incohérence de type détectable ne peut être fusionné dans `main` sans que la CI échoue — une garantie de qualité automatisée, indépendante de la vigilance individuelle en revue de code.

## ✅ Points clés à retenir

- PHP-CS-Fixer corrige automatiquement le **style** (espacement, PSR-12) — jamais la logique.
- PHPStan détecte des **incohérences de types et de logique** sans exécuter le code, à des niveaux de rigueur croissants (0 à 9).
- Démarrer un projet neuf à un niveau PHPStan élevé ; augmenter progressivement sur un projet existant.
- Ces deux outils, intégrés en CI (`--dry-run` pour l'un, `analyse` pour l'autre), automatisent une part importante de la relecture de code.

## ➡️ Pour aller plus loin

- [phpstan.org](https://phpstan.org/)
- [cs.symfony.com](https://cs.symfony.com/) (documentation PHP-CS-Fixer)
- [Module 14.2 — Code review et refactoring](../../14-preparation-professionnelle/02-code-review-et-refactoring/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [05.4 — GitHub Actions : fondamentaux CI/CD](../04-github-actions-ci-cd-fondamentaux/README.md) · **Suite :** [Niveau 06 — Laravel Fondamentaux](../../06-laravel-fondamentaux/README.md)
