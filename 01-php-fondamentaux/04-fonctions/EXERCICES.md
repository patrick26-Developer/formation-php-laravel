# Exercices — 01.4 Fonctions et portée des variables

## Exercice 1 — Fonctions de base (facile)

Écrivez une fonction typée `estPair(int $nombre): bool` qui retourne `true` si le nombre est pair. Testez-la avec plusieurs valeurs.

## Exercice 2 — Valeurs par défaut (facile)

Écrivez une fonction `formaterPrix(float $prix, string $devise = "€"): string` qui retourne une chaîne du type `"19.99 €"`. Testez avec et sans le second argument.

## Exercice 3 — Portée des variables (moyen)

Sans exécuter le code, prédisez ce qu'il affiche, puis vérifiez :

```php
<?php
$compteur = 0;

function incrementer() {
    $compteur = $compteur + 1;
    return $compteur;
}

echo incrementer();
echo incrementer();
echo $compteur;
```

Expliquez en commentaire pourquoi le résultat est celui-ci, puis proposez une version corrigée qui incrémente réellement un compteur partagé (indice : la fonction doit recevoir et retourner la valeur).

## Exercice 4 — `strict_types` en action (moyen)

Créez un fichier avec `declare(strict_types=1);`, une fonction `diviser(int $a, int $b): float`, et appelez-la une fois avec des entiers valides, puis une fois avec une chaîne (`diviser("10", 2)`). Observez et notez l'erreur obtenue.

## Exercice 5 — Fonctions fléchées (difficile)

Réécrivez ces trois fonctions classiques en fonctions fléchées (`fn`) :

```php
<?php
function estMajeur($age) { return $age >= 18; }
function carre($n) { return $n * $n; }
function concatener($a, $b) { return $a . $b; }
```

Puis expliquez en commentaire dans quel cas une fonction fléchée n'est **pas** adaptée (indice : plusieurs instructions, besoin d'une boucle à l'intérieur).

---

Comparez avec [solutions/](solutions/) une fois terminé.
