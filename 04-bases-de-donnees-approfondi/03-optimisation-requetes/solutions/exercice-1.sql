-- 1. Sans index sur la colonne filtrée
EXPLAIN SELECT * FROM journal_activite WHERE action = 'connexion';
-- Attendu : type = ALL, key = NULL, rows proche du total de la table
-- (aucun index sur "action" dans cet exemple)

-- 2. Avec l'index créé au module 04.2 sur utilisateur_id
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Attendu : type = ref, key = idx_journal_utilisateur, rows nettement plus bas

-- 3. Avec un ORDER BY sur une colonne non indexée
EXPLAIN SELECT * FROM journal_activite ORDER BY cree_le DESC LIMIT 10;
-- Attendu : Extra peut afficher "Using filesort" si cree_le n'est pas indexée :
-- MySQL doit trier les résultats "à la main" plutôt que de lire un index déjà trié.
