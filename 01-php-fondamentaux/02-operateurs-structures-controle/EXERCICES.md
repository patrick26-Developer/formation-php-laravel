# Exercices — 01.2 Opérateurs et structures de contrôle

## Exercice 1 — Comparaisons piégeuses (facile)

Prédisez le résultat de chaque `var_dump` ci-dessous **avant** de l'exécuter, notez vos prédictions en commentaire, puis vérifiez :

```php
<?php
var_dump("0" == false);
var_dump("" == null);
var_dump("abc" == 0);
var_dump(1 === 1.0);
var_dump(null == false);
```

## Exercice 2 — Catégorie d'âge (facile)

Écrivez un script qui déclare `$age`, puis affiche "Enfant" (< 13), "Adolescent" (13-17), "Adulte" (18-64) ou "Senior" (65+) selon la valeur. Utilisez `if`/`elseif`/`else`.

## Exercice 3 — Le même exercice avec `match` (moyen)

Réécrivez l'exercice 2 en utilisant `match` avec des conditions booléennes (`match(true)`). Comparez la lisibilité avec la version `if`/`elseif`.

## Exercice 4 — Validateur de mot de passe simple (moyen)

Un mot de passe est valide s'il fait au moins 8 caractères **ET** contient au moins un chiffre. Utilisez `strlen()` et une expression régulière simple (`preg_match('/[0-9]/', $motDePasse)`) combinées avec l'opérateur `&&`. Affichez "valide" ou "invalide".

## Exercice 5 — Menu de restaurant avec `switch` (difficile)

Simulez un menu où `$plat` peut valoir `"entree"`, `"plat"`, `"dessert"`, ou autre chose. Utilisez `switch` pour afficher le prix correspondant (entrée : 5€, plat : 12€, dessert : 4€, sinon : "plat inconnu"). Ajoutez volontairement un oubli de `break` sur un cas, observez le comportement de *fallthrough*, puis corrigez.

---

Comparez avec [solutions/](solutions/) une fois terminé.
