SELECT
    clients.nom,
    SUM(lignes_commande.quantite * lignes_commande.prix_unitaire) AS total_depense
FROM clients
INNER JOIN commandes ON commandes.client_id = clients.id
INNER JOIN lignes_commande ON lignes_commande.commande_id = commandes.id
GROUP BY clients.id, clients.nom
ORDER BY total_depense DESC
LIMIT 3;
