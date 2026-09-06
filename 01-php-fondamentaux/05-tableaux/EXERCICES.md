# Exercices — 01.5 Tableaux

## Exercice 1 — Manipulations de base (facile)

Créez un tableau `$courses` avec 5 articles. Ajoutez-en un sixième, affichez le nombre total d'articles, vérifiez si "lait" en fait partie, puis retirez le premier élément avec `array_shift()`.

## Exercice 2 — Carnet d'adresses (facile)

Créez un tableau associatif représentant une personne (`nom`, `email`, `telephone`). Affichez chaque information avec une boucle `foreach ($personne as $cle => $valeur)`.

## Exercice 3 — Le trio fonctionnel (moyen)

Avec `$prix = [19.99, 5.50, 120.00, 8.75, 45.00];` :

1. Utilisez `array_map` pour obtenir un tableau des prix TTC (+20%).
2. Utilisez `array_filter` pour garder seulement les prix TTC supérieurs à 10€.
3. Utilisez `array_reduce` pour calculer la somme totale des prix TTC filtrés.

Faites-le en une seule chaîne d'appels si possible.

## Exercice 4 — Tableau multidimensionnel (moyen)

Créez un tableau de 4 étudiants, chacun avec `nom` et `notes` (tableau de 3 notes). Pour chaque étudiant, calculez et affichez sa moyenne. Affichez enfin le nom de l'étudiant ayant la meilleure moyenne.

## Exercice 5 — Tri personnalisé (difficile)

Reprenez le tableau d'étudiants de l'exercice 4. Utilisez `usort()` avec une fonction de comparaison personnalisée pour trier le tableau par moyenne décroissante, puis affichez le classement.

---

Comparez avec [solutions/](solutions/) une fois terminé.
