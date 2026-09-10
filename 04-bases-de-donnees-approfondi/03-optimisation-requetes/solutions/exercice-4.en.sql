-- Rather than SELECT * (which would fetch "contenu", potentially large,
-- even though the listing page never displays it):
SELECT articles.titre, auteurs.nom AS auteur
FROM articles
INNER JOIN auteurs ON auteurs.id = articles.auteur_id;
