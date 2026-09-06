SELECT
    utilisateurs.nom,
    COUNT(commandes.id) AS nombre_commandes,
    SUM(commandes.montant) AS total_depense
FROM utilisateurs
INNER JOIN commandes ON commandes.utilisateur_id = utilisateurs.id
GROUP BY utilisateurs.id, utilisateurs.nom
HAVING SUM(commandes.montant) > 50;

-- INNER JOIN ici est volontaire : un utilisateur sans commande n'a pas de
-- somme dépensée à afficher, donc il ne peut de toute façon jamais dépasser
-- 50€ (SUM sur NULL vaudrait NULL, exclu par le HAVING).
