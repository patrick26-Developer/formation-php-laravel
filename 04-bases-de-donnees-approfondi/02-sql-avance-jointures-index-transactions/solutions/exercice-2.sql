SELECT utilisateurs.nom, commandes.montant
FROM utilisateurs
LEFT JOIN commandes ON commandes.utilisateur_id = utilisateurs.id;

-- Tous les utilisateurs apparaissent, y compris ceux sans commande
-- (montant à NULL pour eux) : le nombre de lignes est donc >= à celui
-- de l'exercice 1, et inclut au moins une ligne avec montant NULL.
