CREATE TABLE auteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    auteur_id INT NOT NULL,
    FOREIGN KEY (auteur_id) REFERENCES auteurs(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Relation N-N entre livres et categories
CREATE TABLE livre_categorie (
    livre_id INT NOT NULL,
    categorie_id INT NOT NULL,
    PRIMARY KEY (livre_id, categorie_id),
    FOREIGN KEY (livre_id) REFERENCES livres(id),
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE
);

-- Emprunt : relation N-N "enrichie" entre membres et livres, portant
-- ses propres attributs (dates) — d'où une vraie table à part entière,
-- pas juste une table pivot minimale.
CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    membre_id INT NOT NULL,
    livre_id INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour_prevue DATE NOT NULL,
    date_retour_effective DATE NULL, -- NULL tant que le livre n'a pas été rendu
    FOREIGN KEY (membre_id) REFERENCES membres(id),
    FOREIGN KEY (livre_id) REFERENCES livres(id)
);
