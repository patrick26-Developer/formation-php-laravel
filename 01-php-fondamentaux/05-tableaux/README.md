# 01.5 — Tableaux (arrays)

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Créer et manipuler des tableaux indexés et associatifs.
- Utiliser les fonctions natives essentielles (`array_map`, `array_filter`, `array_reduce`, tri).
- Comprendre les tableaux multidimensionnels.

## 📋 Prérequis

[01.4 — Fonctions et portée des variables](../04-fonctions/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Tableaux indexés

```php
<?php
$fruits = ["pomme", "banane", "cerise"];

echo $fruits[0]; // pomme
$fruits[] = "kiwi"; // ajoute à la fin
echo count($fruits); // 4
```

### Tableaux associatifs

```php
<?php
$personne = [
    "prenom" => "Alice",
    "age" => 28,
    "ville" => "Lyon",
];

echo $personne["prenom"]; // Alice
$personne["email"] = "alice@example.com"; // ajout d'une clé
```

### Tableaux multidimensionnels

```php
<?php
$utilisateurs = [
    ["prenom" => "Alice", "age" => 28],
    ["prenom" => "Bob", "age" => 35],
];

foreach ($utilisateurs as $utilisateur) {
    echo $utilisateur["prenom"] . " a " . $utilisateur["age"] . " ans\n";
}
```

### Fonctions de recherche et modification

```php
<?php
$nombres = [4, 8, 15, 16, 23, 42];

in_array(15, $nombres);       // true : la valeur 15 existe-t-elle ?
array_search(15, $nombres);   // 2   : à quel index ?
array_key_exists(0, $nombres); // true : la clé 0 existe-t-elle ?
count($nombres);              // 6
array_push($nombres, 100);    // ajoute à la fin (équivalent à $nombres[] = 100)
array_pop($nombres);          // retire et retourne le dernier élément
```

### Le trio fonctionnel : `array_map`, `array_filter`, `array_reduce`

Ces trois fonctions permettent de transformer des tableaux **sans boucle explicite** — un style très utilisé en PHP moderne et dans Laravel (Collections, vu au niveau 06).

```php
<?php
$nombres = [1, 2, 3, 4, 5];

// array_map : applique une fonction à CHAQUE élément, retourne un nouveau tableau de même taille
$doubles = array_map(fn(int $n): int => $n * 2, $nombres);
// [2, 4, 6, 8, 10]

// array_filter : garde seulement les éléments qui respectent une condition
$pairs = array_filter($nombres, fn(int $n): bool => $n % 2 === 0);
// [1 => 2, 3 => 4]  -- attention, les clés d'origine sont conservées !

// array_reduce : réduit le tableau à UNE seule valeur, en accumulant
$somme = array_reduce($nombres, fn(int $accumulateur, int $n): int => $accumulateur + $n, 0);
// 15
```

> ⚠️ `array_filter` conserve les clés d'origine, ce qui crée des "trous" dans l'indexation. Utilisez `array_values()` pour réindexer proprement si besoin : `array_values($pairs)`.

### Trier un tableau

```php
<?php
$notes = [12, 5, 18, 9];

sort($notes);        // tri croissant, réindexe : [5, 9, 12, 18]
rsort($notes);        // tri décroissant

$personne = ["b" => 2, "a" => 1];
ksort($personne);      // tri par clé : ["a" => 1, "b" => 2]
asort($personne);      // tri par valeur, conserve les clés
```

### Décomposer un tableau : `list()` / déstructuration

```php
<?php
$coordonnees = [45.75, 4.85];
[$latitude, $longitude] = $coordonnees;

echo "$latitude, $longitude"; // 45.75, 4.85
```

## ✅ Points clés à retenir

- Un tableau PHP peut être indexé (0, 1, 2...), associatif (clés nommées), ou les deux mélangés.
- `array_map`/`array_filter`/`array_reduce` remplacent avantageusement beaucoup de boucles `foreach`.
- `array_filter` ne réindexe pas automatiquement : pensez à `array_values()` si besoin.
- `sort()`/`rsort()` réindexent, `asort()`/`ksort()` conservent les clés.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/ref.array.php](https://www.php.net/manual/fr/ref.array.php) — liste complète des fonctions de tableaux
- [ressources/cheatsheets/](../../ressources/cheatsheets/) — aide-mémoire des fonctions de tableaux les plus utiles

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.4 — Fonctions et portée des variables](../04-fonctions/README.md) · **Suite :** [01.6 — Chaînes de caractères et regex](../06-chaines-de-caracteres/README.md)
