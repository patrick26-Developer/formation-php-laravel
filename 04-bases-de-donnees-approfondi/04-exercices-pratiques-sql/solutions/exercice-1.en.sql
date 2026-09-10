SELECT
    commandes.id AS commande_id,
    clients.nom AS client,
    SUM(lignes_commande.quantite * lignes_commande.prix_unitaire) AS montant_total
FROM commandes
INNER JOIN clients ON clients.id = commandes.client_id
INNER JOIN lignes_commande ON lignes_commande.commande_id = commandes.id
GROUP BY commandes.id, clients.nom;
