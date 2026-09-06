# Exercices — 04.4 Exercices pratiques SQL

> Utilisez le schéma `exercices_sql_04` décrit dans [README.md](README.md).

## Exercice 1 — Chiffre d'affaires total par commande (facile)

Pour chaque commande, calculez son montant total (somme de `quantite * prix_unitaire` sur ses lignes), avec le nom du client.

## Exercice 2 — Produits jamais commandés (facile)

Listez tous les produits qui n'apparaissent dans **aucune** ligne de commande (indice : `LEFT JOIN` + `WHERE ... IS NULL`).

## Exercice 3 — Top 3 des clients par montant dépensé (moyen)

Écrivez une requête donnant les 3 clients ayant le plus dépensé au total (tous produits confondus), avec leur montant total, triés décroissant, en utilisant `LIMIT`.

## Exercice 4 — Produits les plus vendus (moyen)

Listez les produits avec la quantité totale vendue (somme sur toutes les commandes), triés par quantité décroissante. N'affichez que les produits vendus au moins une fois.

## Exercice 5 — Clients sans commande récente (moyen)

Listez les clients n'ayant passé aucune commande dans les 90 derniers jours (y compris ceux n'ayant jamais commandé). Utilisez `DATE_SUB(NOW(), INTERVAL 90 DAY)`.

## Exercice 6 — Passer une commande dans une transaction (difficile)

Écrivez un script PHP `passerCommande(PDO $pdo, int $clientId, array $lignes): int` (où `$lignes` est un tableau de `['produit_id' => ..., 'quantite' => ...]`) qui, dans une transaction : crée la commande, insère chaque ligne avec le prix actuel du produit, décrémente le stock de chaque produit, et échoue proprement (rollback) si un produit n'a pas assez de stock.

## Exercice 7 — Vérifier l'intégrité référentielle (difficile)

Tentez de supprimer un client ayant des commandes existantes sans `ON DELETE CASCADE` ni suppression préalable des commandes liées. Observez et notez l'erreur MySQL obtenue. Expliquez en commentaire pourquoi ce comportement par défaut (`RESTRICT`) est une protection utile plutôt qu'une gêne.

## Exercice 8 — Optimiser une requête de recherche (difficile)

Cette requête de recherche de produits par nom est utilisée très fréquemment sur un catalogue de 100 000 produits :
```sql
SELECT * FROM produits WHERE nom LIKE '%casque%';
```
Expliquez pourquoi un index classique sur `nom` n'aiderait pas significativement cette requête, et proposez une alternative (indice : `FULLTEXT`, voir module 04.3).

---

Comparez avec [solutions/](solutions/) une fois terminé.
