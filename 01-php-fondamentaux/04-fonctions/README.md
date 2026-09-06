# 01.4 — Fonctions et portée des variables

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Déclarer et appeler des fonctions.
- Utiliser paramètres, valeurs par défaut et types.
- Comprendre le retour de valeur et la portée (scope) des variables.
- Utiliser les fonctions fléchées (arrow functions).

## 📋 Prérequis

[01.3 — Les boucles](../03-boucles/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Déclarer une fonction

```php
<?php
function saluer($prenom) {
    echo "Bonjour $prenom !";
}

saluer("Alice"); // Bonjour Alice !
```

### Paramètres avec valeur par défaut

```php
<?php
function saluer($prenom, $politesse = "Bonjour") {
    echo "$politesse $prenom !";
}

saluer("Bob");                 // Bonjour Bob !
saluer("Claire", "Bonsoir");   // Bonsoir Claire !
```

### Le typage des paramètres et du retour (PHP moderne)

Depuis PHP 7+, on peut (et on **devrait**) déclarer les types des paramètres et de la valeur retournée. C'est une pratique fortement recommandée dans cette formation, y compris en dehors de Laravel.

```php
<?php
function additionner(int $a, int $b): int {
    return $a + $b;
}

echo additionner(2, 3); // 5
```

Si vous passez un type incompatible (`additionner("abc", 3)`), PHP lève une `TypeError` — ce qui est **voulu** : mieux vaut une erreur explicite immédiate qu'un bug silencieux plus tard.

### `declare(strict_types=1)`

Par défaut, PHP tente de convertir automatiquement les types passés à une fonction typée (mode "coercitif"). Pour forcer une vérification stricte, on ajoute cette ligne **en tout début de fichier** :

```php
<?php
declare(strict_types=1);

function additionner(int $a, int $b): int {
    return $a + $b;
}

additionner("2", 3); // TypeError : sans strict_types, "2" aurait été converti en 2 silencieusement
```

> 📌 Convention de cette formation : `declare(strict_types=1)` sera utilisé systématiquement à partir du niveau 02, dès qu'on écrit du code orienté objet.

### `return` et sortie anticipée

```php
<?php
function estMajeur(int $age): bool {
    if ($age < 0) {
        return false; // sortie anticipée pour un cas invalide
    }

    return $age >= 18;
}
```

Une fonction s'arrête **immédiatement** dès qu'elle rencontre un `return`.

### La portée des variables (scope)

Une variable déclarée à l'intérieur d'une fonction n'existe **que** dans cette fonction :

```php
<?php
function calculerCarre(int $nombre): int {
    $resultat = $nombre * $nombre; // $resultat n'existe que dans cette fonction
    return $resultat;
}

calculerCarre(4);
echo $resultat; // Erreur : $resultat n'est pas définie ici (hors de portée)
```

Inversement, une fonction n'a **pas accès** aux variables déclarées en dehors d'elle, sauf via ses paramètres :

```php
<?php
$multiplicateur = 10;

function multiplier(int $nombre): int {
    // $multiplicateur n'est PAS accessible ici, même si elle existe "au-dessus"
    return $nombre * 2; // on doit passer les valeurs nécessaires en paramètre
}
```

### Fonctions fléchées (arrow functions, PHP 7.4+)

Utiles pour des fonctions courtes, souvent passées en argument à d'autres fonctions (voir `array_map` au module suivant) :

```php
<?php
$doubler = fn(int $n): int => $n * 2;

echo $doubler(5); // 10
```

## ✅ Points clés à retenir

- Typer les paramètres et le retour d'une fonction est une bonne pratique à adopter dès maintenant.
- `declare(strict_types=1)` évite les conversions de type silencieuses.
- Une variable locale à une fonction n'existe pas en dehors, et vice-versa.
- Les fonctions fléchées (`fn() => ...`) sont pratiques pour du code court et fonctionnel.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/functions.arguments.php](https://www.php.net/manual/fr/functions.arguments.php)
- [php.net/manual/fr/language.types.declarations.php](https://www.php.net/manual/fr/language.types.declarations.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [01.3 — Les boucles](../03-boucles/README.md) · **Suite :** [01.5 — Tableaux](../05-tableaux/README.md)
