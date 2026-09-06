# Exercices — 04.3 Optimisation des requêtes SQL

## Exercice 1 — Lire un EXPLAIN (facile)

Sur la table `journal_activite` du [module 04.2, exercice 5](../02-sql-avance-jointures-index-transactions/README.md), exécutez `EXPLAIN` sur trois requêtes différentes (avec et sans `WHERE` indexé, avec un `ORDER BY`). Notez pour chacune la valeur de `type`, `key` et `rows`.

## Exercice 2 — Corriger un WHERE non indexable (facile)

Cette requête n'utilise jamais l'index sur `email`, même s'il existe :
```sql
SELECT * FROM utilisateurs WHERE UPPER(email) = 'ALICE@EXAMPLE.COM';
```
Réécrivez-la pour qu'elle puisse utiliser l'index.

## Exercice 3 — Choisir les bons types (moyen)

Cette table a des choix de types discutables. Proposez une version corrigée avec justification pour chaque changement :
```sql
CREATE TABLE produits (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nom TEXT NOT NULL,
    prix FLOAT NOT NULL,
    en_stock VARCHAR(10) NOT NULL -- contient "oui" ou "non"
);
```

## Exercice 4 — SELECT * vs colonnes explicites (moyen)

Sur une table `articles` avec une colonne `contenu TEXT` (potentiellement volumineuse) en plus de `id`, `titre`, `auteur_id`, écrivez la requête pour une page de liste d'articles qui n'affiche QUE le titre et l'auteur — sans `SELECT *`.

## Exercice 5 — Diagnostic complet (difficile)

Cette requête est lente sur une table de 500 000 lignes :
```sql
SELECT * FROM commandes
WHERE YEAR(date_commande) = 2025
ORDER BY montant DESC;
```
Identifiez au moins deux problèmes de performance potentiels (indice : une fonction sur une colonne de date, l'absence d'index couvrant le tri) et proposez une requête et/ou un index corrigés.

---

Comparez avec [solutions/](solutions/) une fois terminé.
