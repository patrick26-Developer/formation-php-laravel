-- Original :
-- CREATE TABLE produits (
--     id BIGINT AUTO_INCREMENT PRIMARY KEY,
--     nom TEXT NOT NULL,
--     prix FLOAT NOT NULL,
--     en_stock VARCHAR(10) NOT NULL
-- );

CREATE TABLE produits (
    -- INT au lieu de BIGINT : un catalogue de produits dépasse rarement
    -- 2 milliards de lignes (plage couverte par INT) ; BIGINT double
    -- inutilement l'espace utilisé par la clé sur chaque ligne ET chaque index.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- VARCHAR(150) au lieu de TEXT : un nom de produit a une longueur
    -- raisonnable et bornée ; VARCHAR est plus efficace à indexer et trier
    -- que TEXT, pensé pour du contenu long et non borné.
    nom VARCHAR(150) NOT NULL,

    -- DECIMAL(10,2) au lieu de FLOAT : FLOAT introduit des erreurs
    -- d'arrondi binaire (0.1 + 0.2 ne fait pas exactement 0.3 en flottant),
    -- inacceptable pour des montants d'argent. DECIMAL est exact.
    prix DECIMAL(10, 2) NOT NULL,

    -- BOOLEAN (TINYINT(1) sous MySQL) au lieu de VARCHAR(10) : "oui"/"non"
    -- en texte est plus lent à comparer/indexer et laisse la porte ouverte
    -- à des valeurs incohérentes ("Oui", "OUI", "yes"...).
    en_stock BOOLEAN NOT NULL DEFAULT TRUE
);
