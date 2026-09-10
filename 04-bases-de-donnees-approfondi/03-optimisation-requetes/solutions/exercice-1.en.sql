-- 1. Without an index on the filtered column
EXPLAIN SELECT * FROM journal_activite WHERE action = 'connexion';
-- Expected: type = ALL, key = NULL, rows close to the table's total
-- (no index on "action" in this example)

-- 2. With the index created in module 04.2 on utilisateur_id
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Expected: type = ref, key = idx_journal_utilisateur, rows significantly lower

-- 3. With an ORDER BY on a non-indexed column
EXPLAIN SELECT * FROM journal_activite ORDER BY cree_le DESC LIMIT 10;
-- Expected: Extra may show "Using filesort" if cree_le isn't indexed:
-- MySQL has to sort the results "by hand" instead of reading an already-sorted index.
