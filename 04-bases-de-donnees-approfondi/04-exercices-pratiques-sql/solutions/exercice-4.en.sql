SELECT
    produits.nom,
    SUM(lignes_commande.quantite) AS quantite_totale_vendue
FROM produits
INNER JOIN lignes_commande ON lignes_commande.produit_id = produits.id
GROUP BY produits.id, produits.nom
ORDER BY quantite_totale_vendue DESC;

-- INNER JOIN naturally excludes products never sold (see exercise 2),
-- which matches the "at least once" requirement.
