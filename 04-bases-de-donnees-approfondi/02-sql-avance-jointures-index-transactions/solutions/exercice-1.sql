SELECT utilisateurs.nom, commandes.montant
FROM commandes
INNER JOIN utilisateurs ON utilisateurs.id = commandes.utilisateur_id;

-- Seuls les utilisateurs ayant AU MOINS une commande apparaissent.
