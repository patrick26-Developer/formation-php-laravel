-- Original problematic query:
-- SELECT * FROM commandes
-- WHERE YEAR(date_commande) = 2025
-- ORDER BY montant DESC;

-- Problem 1: YEAR(date_commande) applies a function to the filtered
-- column, preventing MySQL from using any index on date_commande
-- (the same trap as the LOWER()/UPPER() case in exercise 2).
--
-- Problem 2: ORDER BY montant DESC on 500,000 rows, with no index on
-- "montant", forces MySQL to sort the entire filtered result in
-- memory or on disk (visible in EXPLAIN via "Using filesort").
--
-- Problem 3 (implicit): SELECT * fetches every column even though
-- the display probably doesn't need all of them.

-- Fixed query: we replace YEAR(date_commande) = 2025 with an explicit
-- range on the raw column, which allows an index on date_commande
-- to be used.
SELECT id, utilisateur_id, montant, date_commande
FROM commandes
WHERE date_commande >= '2025-01-01' AND date_commande < '2026-01-01'
ORDER BY montant DESC;

-- And we add a composite index covering both the filter AND the sort,
-- so MySQL can potentially avoid the filesort:
CREATE INDEX idx_commandes_date_montant ON commandes(date_commande, montant);
