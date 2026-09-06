CREATE TABLE journal_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    cree_le DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Génère 10 000 lignes de test avec une procédure (approche pratique pour
-- ne pas écrire 10 000 INSERT à la main)
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

-- Avant index : MySQL doit examiner un grand nombre de lignes (souvent
-- proche du total de la table) car aucune structure ne permet de sauter
-- directement aux lignes utilisateur_id = 42.
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Colonne "rows" attendue : proche de 10000 (parcours complet ou presque)

CREATE INDEX idx_journal_utilisateur ON journal_activite(utilisateur_id);

-- Après index : MySQL utilise l'index pour ne lire QUE les lignes
-- correspondant à utilisateur_id = 42.
EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;
-- Colonne "rows" attendue : proche du nombre réel de lignes pour cet
-- utilisateur (environ 10000/500 = 20), et la colonne "key" indique
-- maintenant "idx_journal_utilisateur" au lieu de NULL.
