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

-- The foreign key (auteur_id) is placed on the "N" side (livres),
-- since an author can have several books but each book
-- has only one main author.
