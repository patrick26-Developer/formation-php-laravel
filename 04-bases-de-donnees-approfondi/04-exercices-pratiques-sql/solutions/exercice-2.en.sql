SELECT produits.*
FROM produits
LEFT JOIN lignes_commande ON lignes_commande.produit_id = produits.id
WHERE lignes_commande.produit_id IS NULL;

-- LEFT JOIN keeps all products, with NULL on the lignes_commande side if
-- they were never ordered. The WHERE ... IS NULL isolates precisely these cases.
