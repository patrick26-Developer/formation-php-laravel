-- Requête originale problématique :
-- SELECT * FROM commandes
-- WHERE YEAR(date_commande) = 2025
-- ORDER BY montant DESC;

-- Problème 1 : YEAR(date_commande) applique une fonction à la colonne
-- filtrée, empêchant MySQL d'utiliser un éventuel index sur date_commande
-- (même chose que le piège LOWER()/UPPER() de l'exercice 2).
--
-- Problème 2 : ORDER BY montant DESC sur 500 000 lignes, sans index sur
-- "montant", oblige MySQL à trier la totalité du résultat filtré en mémoire
-- ou sur disque (visible dans EXPLAIN via "Using filesort").
--
-- Problème 3 (implicite) : SELECT * rapatrie toutes les colonnes alors
-- que l'affichage n'en a probablement pas besoin de la totalité.

-- Requête corrigée : on remplace YEAR(date_commande) = 2025 par un
-- intervalle explicite sur la colonne brute, ce qui permet d'utiliser
-- un index sur date_commande.
SELECT id, utilisateur_id, montant, date_commande
FROM commandes
WHERE date_commande >= '2025-01-01' AND date_commande < '2026-01-01'
ORDER BY montant DESC;

-- Et on ajoute un index composite couvrant à la fois le filtre ET le tri,
-- pour que MySQL puisse potentiellement éviter le filesort :
CREATE INDEX idx_commandes_date_montant ON commandes(date_commande, montant);
