SELECT produits.*
FROM produits
LEFT JOIN lignes_commande ON lignes_commande.produit_id = produits.id
WHERE lignes_commande.produit_id IS NULL;

-- LEFT JOIN garde tous les produits, avec NULL côté lignes_commande s'ils
-- n'ont jamais été commandés. Le WHERE ... IS NULL isole précisément ces cas.
