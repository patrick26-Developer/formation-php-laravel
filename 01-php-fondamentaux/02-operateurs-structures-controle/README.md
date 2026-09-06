# 01.2 — Opérateurs et structures de contrôle

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Connaître les principaux opérateurs PHP (arithmétiques, comparaison, logiques).
- Comprendre la différence entre `==` et `===`.
- Écrire des conditions avec `if`/`elseif`/`else`, `switch` et `match`.

## 📋 Prérequis

[01.1 — Syntaxe, variables et types](../01-syntaxe-variables-types/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Opérateurs arithmétiques

```php
<?php
$a = 10;
$b = 3;

echo $a + $b;  // 13
echo $a - $b;  // 7
echo $a * $b;  // 30
echo $a / $b;  // 3.333...
echo $a % $b;  // 1  (modulo : reste de la division)
echo $a ** $b; // 1000 (puissance)
```

### Opérateurs de comparaison : `==` vs `===`

C'est l'un des pièges les plus classiques de PHP.

```php
<?php
var_dump(0 == "abc");   // false en PHP 8+ (avant PHP 8, c'était true !)
var_dump("10" == 10);   // true  : compare les VALEURS après conversion de type
var_dump("10" === 10);  // false : compare aussi le TYPE, string !== int
```

> ⚠️ **Règle de cette formation : toujours préférer `===` et `!==`** sauf raison précise de vouloir la conversion implicite. Cela évite des bugs silencieux difficiles à détecter.

| Opérateur | Nom | Exemple | Résultat |
|---|---|---|---|
| `==` | Égalité "souple" | `"5" == 5` | `true` |
| `===` | Égalité stricte | `"5" === 5` | `false` |
| `!=` / `<>` | Différence souple | `5 != "5"` | `false` |
| `!==` | Différence stricte | `5 !== "5"` | `true` |
| `<`, `>`, `<=`, `>=` | Comparaisons numériques | `5 > 3` | `true` |
| `<=>` | Opérateur "vaisseau spatial" | `5 <=> 3` | `1` (-1, 0 ou 1) |

### Opérateurs logiques

```php
<?php
$estMajeur = true;
$aPermis = false;

var_dump($estMajeur && $aPermis); // ET logique : false
var_dump($estMajeur || $aPermis); // OU logique : true
var_dump(!$aPermis);              // NON logique : true
```

### Structure conditionnelle `if` / `elseif` / `else`

```php
<?php
$note = 14;

if ($note >= 16) {
    echo "Très bien";
} elseif ($note >= 12) {
    echo "Bien";
} elseif ($note >= 10) {
    echo "Passable";
} else {
    echo "Insuffisant";
}
```

### L'opérateur ternaire et l'opérateur de coalescence nulle

```php
<?php
// Ternaire : condition ? valeurSiVrai : valeurSiFaux
$statut = $estMajeur ? "majeur" : "mineur";

// Coalescence nulle (??) : utile pour des valeurs potentiellement absentes
$pseudo = $_GET['pseudo'] ?? "Invité"; // si $_GET['pseudo'] n'existe pas, utilise "Invité"
```

### `switch`

```php
<?php
$jour = "mercredi";

switch ($jour) {
    case "samedi":
    case "dimanche":
        echo "Week-end";
        break;
    default:
        echo "Jour de semaine";
        break;
}
```

> ⚠️ Ne jamais oublier `break;` : sans lui, l'exécution "tombe" dans le `case` suivant (comportement volontaire de PHP appelé *fallthrough*, source de bugs si non maîtrisé).

### `match` (PHP 8+, syntaxe moderne recommandée)

`match` remplace avantageusement `switch` dans la plupart des cas : comparaison **stricte** (`===`), pas de `break` nécessaire, et retourne directement une valeur.

```php
<?php
$jour = "mercredi";

$type = match ($jour) {
    "samedi", "dimanche" => "Week-end",
    default => "Jour de semaine",
};

echo $type;
```

## ✅ Points clés à retenir

- Préférez toujours `===`/`!==` à `==`/`!=`.
- `&&`, `||`, `!` pour combiner des conditions.
- `match` (PHP 8+) est souvent préférable à `switch` : plus concis, plus sûr (comparaison stricte), retourne une valeur.
- L'opérateur `??` évite bien des `isset()` verbeux pour les valeurs par défaut.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.operators.php](https://www.php.net/manual/fr/language.operators.php)
- [php.net/manual/fr/control-structures.match.php](https://www.php.net/manual/fr/control-structures.match.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.1 — Syntaxe, variables et types](../01-syntaxe-variables-types/README.md) · **Suite :** [01.3 — Les boucles](../03-boucles/README.md)
