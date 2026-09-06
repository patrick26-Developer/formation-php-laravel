CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Table pivot : chaque ligne dit "ce livre appartient à cette catégorie"
CREATE TABLE livre_categorie (
    livre_id INT NOT NULL,
    categorie_id INT NOT NULL,
    PRIMARY KEY (livre_id, categorie_id), -- empêche d'associer deux fois le même couple
    FOREIGN KEY (livre_id) REFERENCES livres(id),
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);
