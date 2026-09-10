SELECT utilisateurs.nom, commandes.montant
FROM utilisateurs
LEFT JOIN commandes ON commandes.utilisateur_id = utilisateurs.id;

-- All users appear, including those without an order
-- (montant is NULL for them): the row count is therefore >= that of
-- exercise 1, and includes at least one row with montant NULL.
