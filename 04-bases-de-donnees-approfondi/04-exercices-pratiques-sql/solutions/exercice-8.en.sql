-- SELECT * FROM produits WHERE nom LIKE '%casque%';
--
-- A classic B-Tree index (the kind created by CREATE INDEX) is organized
-- like a dictionary sorted by PREFIX. It can quickly jump to "everything
-- that starts with casque", but it cannot speed up a search that starts
-- with '%': MySQL has no way of knowing in advance WHERE "casque" might
-- appear in the middle of a name, so it has to examine every row one by
-- one (type = ALL in EXPLAIN), index or not.

-- Recommended alternative: a FULLTEXT index, designed specifically for
-- searching for words inside a piece of text.
CREATE FULLTEXT INDEX idx_produits_nom ON produits(nom);

SELECT * FROM produits
WHERE MATCH(nom) AGAINST('casque' IN NATURAL LANGUAGE MODE);

-- MATCH...AGAINST uses the FULLTEXT index to quickly find rows
-- containing the searched word, even in the middle of the text — the
-- right answer for a real search feature on a large catalog, where
-- LIKE '%...%' becomes unusable performance-wise.
