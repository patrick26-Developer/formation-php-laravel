-- SELECT * FROM produits WHERE nom LIKE '%casque%';
--
-- Un index B-Tree classique (celui créé par CREATE INDEX) est organisé
-- comme un dictionnaire trié par PRÉFIXE. Il permet de sauter rapidement
-- à "tout ce qui commence par casque", mais est incapable d'accélérer une
-- recherche qui commence par '%' : MySQL ne peut pas savoir à l'avance
-- OÙ "casque" pourrait apparaître au milieu d'un nom, donc il doit examiner
-- chaque ligne une par une (type = ALL dans EXPLAIN), index ou non.

-- Alternative recommandée : un index FULLTEXT, conçu spécifiquement pour
-- la recherche de mots à l'intérieur d'un texte.
CREATE FULLTEXT INDEX idx_produits_nom ON produits(nom);

SELECT * FROM produits
WHERE MATCH(nom) AGAINST('casque' IN NATURAL LANGUAGE MODE);

-- MATCH...AGAINST utilise l'index FULLTEXT pour retrouver rapidement les
-- lignes contenant le mot recherché, même au milieu du texte — la bonne
-- réponse pour une vraie fonctionnalité de recherche sur un grand catalogue,
-- là où LIKE '%...%' devient inutilisable en performance.
