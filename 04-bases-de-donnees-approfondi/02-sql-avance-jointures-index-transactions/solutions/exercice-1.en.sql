SELECT utilisateurs.nom, commandes.montant
FROM commandes
INNER JOIN utilisateurs ON utilisateurs.id = commandes.utilisateur_id;

-- Only users with AT LEAST one order appear.
