# Exercices — 04.1 Modélisation relationnelle

## Exercice 1 — Identifier les entités (facile)

Pour un système de bibliothèque (livres, membres, emprunts), listez les entités et leurs attributs principaux (au moins 3 attributs par entité).

## Exercice 2 — Identifier les cardinalités (facile)

Pour chaque relation ci-dessous, indiquez la cardinalité (1-1, 1-N, ou N-N) et justifiez en une phrase :
- Un `Auteur` écrit des `Livre`
- Un `Livre` est emprunté par des `Membre` (au fil du temps, plusieurs emprunts possibles)
- Un `Membre` a une `CarteBibliotheque`

## Exercice 3 — MCD vers MLD : relation 1-N (moyen)

Un `Livre` a un `Auteur` (un livre = un seul auteur principal, un auteur peut avoir écrit plusieurs livres). Écrivez le SQL `CREATE TABLE` pour les deux tables avec la clé étrangère correctement placée.

## Exercice 4 — MCD vers MLD : relation N-N (moyen)

Traduisez la relation N-N `Livre` ↔ `Categorie` (un livre peut avoir plusieurs catégories, une catégorie contient plusieurs livres) en SQL, avec une table pivot nommée `livre_categorie`.

## Exercice 5 — Modéliser un système complet (difficile)

Modélisez un système de gestion de bibliothèque complet avec : `auteurs`, `livres` (1 auteur par livre), `categories` (N-N avec livres), `membres`, `emprunts` (un emprunt lie un membre à un livre à une date donnée, avec une date de retour prévue et une date de retour effective nullable). Écrivez le SQL complet des `CREATE TABLE` avec toutes les clés primaires et étrangères.

---

Comparez avec [solutions/](solutions/) une fois terminé.
