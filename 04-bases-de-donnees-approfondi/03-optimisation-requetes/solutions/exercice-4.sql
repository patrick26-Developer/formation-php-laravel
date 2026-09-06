-- Plutôt que SELECT * (qui rapatrierait "contenu", potentiellement volumineux,
-- alors que la page de liste ne l'affiche jamais) :
SELECT articles.titre, auteurs.nom AS auteur
FROM articles
INNER JOIN auteurs ON auteurs.id = articles.auteur_id;
