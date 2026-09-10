CREATE TABLE journal_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    cree_le DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Generates 10,000 test rows with a procedure (a practical approach to
-- avoid writing 10,000 INSERTs by hand)
DELIMITER $$
CREATE PROCEDURE generer_donnees_test()
BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < 10000 DO
        INSERT INTO journal_activite (utilisateur_id, action)
        VALUES (FLOOR(1 + RAND() * 500), 'connexion');
        SET i = i + 1;
    END WHILE;
END$$
DELIMITER ;

CALL generer_donnees_test();

-- Before the index: MySQL has to examine a large number of rows (often
-- close to the table's total) because no structure lets it jump
-- directly to the rows where utilisateur_id = 42.
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Expected "rows" column: close to 10000 (full or near-full scan)

CREATE INDEX idx_journal_utilisateur ON journal_activite(utilisateur_id);

-- After the index: MySQL uses the index to read ONLY the rows
-- matching utilisateur_id = 42.
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Expected "rows" column: close to the actual number of rows for this
-- user (about 10000/500 = 20), and the "key" column now shows
-- "idx_journal_utilisateur" instead of NULL.
