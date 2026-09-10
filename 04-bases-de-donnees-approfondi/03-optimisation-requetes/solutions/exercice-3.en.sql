-- Original:
-- CREATE TABLE produits (
--     id BIGINT AUTO_INCREMENT PRIMARY KEY,
--     nom TEXT NOT NULL,
--     prix FLOAT NOT NULL,
--     en_stock VARCHAR(10) NOT NULL
-- );

CREATE TABLE produits (
    -- INT instead of BIGINT: a product catalog rarely exceeds
    -- 2 billion rows (INT's range); BIGINT needlessly doubles
    -- the space used by the key on every row AND every index.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- VARCHAR(150) instead of TEXT: a product name has a reasonable,
    -- bounded length; VARCHAR is more efficient to index and sort
    -- than TEXT, which is designed for long, unbounded content.
    nom VARCHAR(150) NOT NULL,

    -- DECIMAL(10,2) instead of FLOAT: FLOAT introduces binary
    -- rounding errors (0.1 + 0.2 isn't exactly 0.3 in floating point),
    -- unacceptable for monetary amounts. DECIMAL is exact.
    prix DECIMAL(10, 2) NOT NULL,

    -- BOOLEAN (TINYINT(1) under MySQL) instead of VARCHAR(10): "oui"/"non"
    -- as text is slower to compare/index and leaves the door open
    -- to inconsistent values ("Oui", "OUI", "yes"...).
    en_stock BOOLEAN NOT NULL DEFAULT TRUE
);
