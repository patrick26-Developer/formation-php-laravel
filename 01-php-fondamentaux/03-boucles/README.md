# 01.3 — Les boucles

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Répéter un bloc d'instructions avec `for`, `while`, `do-while` et `foreach`.
- Savoir quand utiliser chaque type de boucle.
- Maîtriser `break` et `continue`.

## 📋 Prérequis

[01.2 — Opérateurs et structures de contrôle](../02-operateurs-structures-controle/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### `for` — quand on connaît le nombre d'itérations

```php
<?php
for ($i = 0; $i < 5; $i++) {
    echo "Itération $i\n";
}
```

Structure : `for (initialisation; condition; incrémentation) { ... }`.

### `while` — tant qu'une condition est vraie

```php
<?php
$i = 0;
while ($i < 5) {
    echo "Itération $i\n";
    $i++;
}
```

> ⚠️ Piège classique : oublier `$i++` dans le corps de la boucle crée une **boucle infinie**.

### `do-while` — exécute au moins une fois

```php
<?php
$i = 0;
do {
    echo "Itération $i\n";
    $i++;
} while ($i < 5);
```

La différence avec `while` : la condition est vérifiée **après** le premier passage, donc le bloc s'exécute toujours au moins une fois, même si la condition est fausse dès le départ.

### `foreach` — pour parcourir un tableau (la boucle la plus utilisée en PHP)

```php
<?php
$fruits = ["pomme", "banane", "cerise"];

foreach ($fruits as $fruit) {
    echo "$fruit\n";
}

// Avec la clé (index) en plus de la valeur
foreach ($fruits as $index => $fruit) {
    echo "$index : $fruit\n";
}

// Sur un tableau associatif
$ages = ["Alice" => 28, "Bob" => 35];
foreach ($ages as $prenom => $age) {
    echo "$prenom a $age ans\n";
}
```

> 📌 `foreach` sera votre boucle par défaut dès que vous manipulez des tableaux (module suivant) ou des résultats de base de données (niveau 02). Les boucles `for`/`while` restent utiles pour des logiques basées sur des compteurs ou des conditions qui ne dépendent pas directement d'un tableau.

### `break` et `continue`

```php
<?php
for ($i = 0; $i < 10; $i++) {
    if ($i === 3) {
        continue; // passe à l'itération suivante sans exécuter la suite du bloc
    }
    if ($i === 7) {
        break; // arrête complètement la boucle
    }
    echo "$i ";
}
// Affiche : 0 1 2 4 5 6
```

### Boucles imbriquées

```php
<?php
for ($ligne = 1; $ligne <= 3; $ligne++) {
    for ($colonne = 1; $colonne <= 3; $colonne++) {
        echo "($ligne,$colonne) ";
    }
    echo "\n";
}
```

## ✅ Points clés à retenir

- `for` : nombre d'itérations connu à l'avance.
- `while` : répète tant qu'une condition est vraie (0 à n fois).
- `do-while` : comme `while`, mais garantit au moins un passage.
- `foreach` : la boucle idiomatique pour parcourir un tableau en PHP.
- `continue` saute à l'itération suivante, `break` arrête la boucle.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/control-structures.foreach.php](https://www.php.net/manual/fr/control-structures.foreach.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.2 — Opérateurs et structures de contrôle](../02-operateurs-structures-controle/README.md) · **Suite :** [01.4 — Fonctions et portée des variables](../04-fonctions/README.md)
