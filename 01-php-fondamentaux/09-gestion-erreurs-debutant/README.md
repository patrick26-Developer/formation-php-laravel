# 01.9 — Introduction à la gestion d'erreurs

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre les différents niveaux d'erreurs en PHP (notice, warning, fatal error).
- Utiliser `try`/`catch` pour gérer une exception simple.
- Adopter les premiers réflexes de débogage.

## 📋 Prérequis

[01.8 — Fichiers, includes et organisation](../08-fichiers-et-includes/README.md)

## ⏱️ Durée estimée

1h.

## 📖 Théorie

### Les niveaux d'erreurs PHP

| Niveau | Gravité | Le script continue-t-il ? | Exemple |
|---|---|---|---|
| **Notice / Deprecated** | Faible | Oui | Utiliser une fonction obsolète |
| **Warning** | Moyenne | Oui | `include` d'un fichier absent, division par zéro (PHP 8+) |
| **Fatal error** | Élevée | Non, le script s'arrête | Appeler une fonction inexistante, erreur de type stricte |

En développement, il faut **toujours voir toutes les erreurs**, y compris les moins graves — elles révèlent souvent un bug qui deviendra critique en production.

```php
<?php
// À placer en haut de vos scripts pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', '1');
```

> ⚠️ Ces réglages sont pour le **développement uniquement**. En production, on n'affiche jamais les erreurs à l'utilisateur (elles peuvent révéler des informations sensibles) — on les enregistre plutôt dans un fichier de log. Ce sujet est repris en détail dans le [module 11.5 — Monitoring et logs](../../11-devops-docker-cicd-avance/05-monitoring-logs/README.md).

### Exceptions : `try` / `catch`

Une **exception** est un objet représentant une erreur, que l'on peut "attraper" pour réagir proprement au lieu de laisser le script planter.

```php
<?php
function diviser(float $a, float $b): float {
    if ($b === 0.0) {
        throw new Exception("Division par zéro impossible.");
    }

    return $a / $b;
}

try {
    echo diviser(10, 0);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

echo "Le script continue normalement après le catch.";
```

Décomposition :

- `throw new Exception(...)` : on "lance" une exception quand une situation anormale est détectée.
- `try { ... }` : le bloc de code "à risque" que l'on surveille.
- `catch (Exception $e) { ... }` : le bloc exécuté si une exception a été lancée dans le `try`. `$e->getMessage()` récupère le message d'erreur.

### `finally` : toujours exécuté

```php
<?php
try {
    echo "Tentative...\n";
    throw new Exception("Erreur !");
} catch (Exception $e) {
    echo "Erreur attrapée : " . $e->getMessage() . "\n";
} finally {
    echo "Ce bloc s'exécute toujours, erreur ou non.\n";
}
```

> 📌 Ce module ne fait qu'introduire les exceptions. Elles sont approfondies en détail (hiérarchie d'exceptions, exceptions personnalisées) au [module 02.4](../../02-php-intermediaire/04-gestion-exceptions/README.md), une fois la programmation orientée objet acquise.

### Premiers réflexes de débogage

- **`var_dump()`** à un endroit précis du code pour inspecter une variable.
- **`die()`** ou **`exit()`** juste après un `var_dump()` pour arrêter l'exécution et éviter d'être noyé sous d'autres sorties.
- Lire le message d'erreur **en entier** : PHP indique le fichier et la ligne exacte du problème.
- Isoler : commenter des blocs de code pour identifier lequel provoque l'erreur.

```php
<?php
var_dump($variableSuspecte);
die("Arrêt pour débogage");
```

## ✅ Points clés à retenir

- En développement, activez toujours l'affichage de toutes les erreurs (`error_reporting(E_ALL)`).
- Une exception se lance avec `throw`, se capture avec `try`/`catch`.
- `finally` s'exécute toujours, que l'exception ait été lancée ou non.
- `var_dump()` + `die()` est le duo de débogage le plus simple et le plus utilisé au quotidien.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.exceptions.php](https://www.php.net/manual/fr/language.exceptions.php)
- [Module 02.4 — Gestion des exceptions (approfondi)](../../02-php-intermediaire/04-gestion-exceptions/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.8 — Fichiers, includes et organisation](../08-fichiers-et-includes/README.md) · **Suite :** [Mini-projet : Calculatrice CLI et Web](../projet-mini-01-calculatrice-cli-et-web/README.md)
