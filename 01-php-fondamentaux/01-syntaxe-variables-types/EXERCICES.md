# Exercices — 01.1 Syntaxe, variables et types

> Créez un fichier `.php` par exercice dans un dossier de travail personnel (par exemple `mon-parcours/01-1/`), exécutez-le avec `php -S localhost:8000` ou `php nom-du-fichier.php`, puis comparez avec `solutions/` seulement après avoir essayé.

## Exercice 1 — Ma carte d'identité (facile)

Déclarez des variables pour votre prénom, votre âge, votre ville, et un booléen `estEtudiant`. Affichez une phrase complète les utilisant toutes, avec `echo` et l'interpolation de variables.

**Résultat attendu (exemple) :**
```
Je m'appelle Alice, j'ai 28 ans, je vis à Lyon, et je suis étudiante : non
```

## Exercice 2 — Inspecteur de types (facile)

Créez 5 variables, une de chaque type scalaire différent (`int`, `float`, `string`, `bool`) plus un tableau. Pour chacune, affichez son type avec `gettype()` puis son contenu avec `var_dump()`.

## Exercice 3 — Conversions de types (moyen)

Partez de cette variable :

```php
<?php
$saisieUtilisateur = "42.5abc";
```

1. Affichez son type d'origine.
2. Convertissez-la en `int` et affichez le résultat — que se passe-t-il ?
3. Convertissez-la en `float` et affichez le résultat.
4. Expliquez en commentaire la différence de comportement entre les deux conversions.

## Exercice 4 — Calcul de panier (moyen)

Un client achète 3 articles à des prix différents. Déclarez trois variables de prix (`float`), une variable `quantite` par article (`int`), une constante `TVA_TAUX` à 0.20. Calculez et affichez :

- Le total HT (somme de chaque prix × sa quantité)
- Le montant de la TVA
- Le total TTC, arrondi à 2 décimales avec `round()`

## Exercice 5 — Détective de bug (difficile)

Ce code contient plusieurs erreurs de syntaxe et de logique liées aux notions de ce module. Corrigez-les toutes et expliquez chaque correction en commentaire.

```php
<?php

$Prix = 15.50
$quantite = "3"

$total = $prix * $quantite
echo 'Le total est : $total euros'
```

*(Indice : il y a au moins 4 problèmes distincts à corriger.)*

---

Une fois terminé, comparez vos réponses avec [solutions/](solutions/).
