SELECT
    produits.nom,
    SUM(lignes_commande.quantite) AS quantite_totale_vendue
FROM produits
INNER JOIN lignes_commande ON lignes_commande.produit_id = produits.id
GROUP BY produits.id, produits.nom
ORDER BY quantite_totale_vendue DESC;

-- INNER JOIN exclut naturellement les produits jamais vendus (voir exercice 2),
-- ce qui correspond à la consigne "au moins une fois".
