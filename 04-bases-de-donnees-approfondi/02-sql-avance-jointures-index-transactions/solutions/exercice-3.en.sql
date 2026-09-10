SELECT
    utilisateurs.nom,
    COUNT(commandes.id) AS nombre_commandes,
    SUM(commandes.montant) AS total_depense
FROM utilisateurs
INNER JOIN commandes ON commandes.utilisateur_id = utilisateurs.id
GROUP BY utilisateurs.id, utilisateurs.nom
HAVING SUM(commandes.montant) > 50;

-- INNER JOIN here is deliberate: a user with no order has no spent
-- total to show, so they could never exceed 50€ anyway
-- (SUM over NULL would be NULL, excluded by the HAVING).
