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

-- La clé étrangère (auteur_id) est placée du côté "N" (livres),
-- puisqu'un auteur peut avoir plusieurs livres mais chaque livre
-- n'a qu'un seul auteur principal.
