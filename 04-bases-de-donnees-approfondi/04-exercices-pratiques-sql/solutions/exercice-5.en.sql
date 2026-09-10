SELECT DISTINCT clients.nom
FROM clients
LEFT JOIN commandes
    ON commandes.client_id = clients.id
    AND commandes.passee_le >= DATE_SUB(NOW(), INTERVAL 90 DAY)
WHERE commandes.id IS NULL;

-- The date condition is placed in the ON clause, not in a separate WHERE:
-- if it were in the WHERE, the LEFT JOIN would behave like an implicit
-- INNER JOIN for clients who HAD older orders (they'd be filtered out
-- after the join, eliminating the whole row).
-- By putting it in the ON clause, we only "join" recent orders,
-- and a client with NO recent order at all correctly shows up with
-- commandes.id as NULL, whether or not they have older orders.
