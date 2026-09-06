SELECT DISTINCT clients.nom
FROM clients
LEFT JOIN commandes
    ON commandes.client_id = clients.id
    AND commandes.passee_le >= DATE_SUB(NOW(), INTERVAL 90 DAY)
WHERE commandes.id IS NULL;

-- La condition sur la date est placée dans le ON, pas dans un WHERE séparé :
-- si elle était dans le WHERE, le LEFT JOIN se comporterait comme un
-- INNER JOIN implicite pour les clients ayant EU des commandes anciennes
-- (elles seraient filtrées après la jointure, éliminant la ligne entière).
-- En la mettant dans le ON, on ne "joint" que les commandes récentes,
-- et un client sans AUCUNE commande récente ressort bien avec commandes.id
-- à NULL, qu'il ait ou non des commandes plus anciennes.
