-- Schéma de la base de données du mini-projet "Gestionnaire de tâches"
-- À exécuter une fois, avant la première utilisation du projet.

CREATE DATABASE IF NOT EXISTS gestion_taches CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_taches;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    cree_le DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    titre VARCHAR(150) NOT NULL,
    description TEXT NULL,
    terminee BOOLEAN NOT NULL DEFAULT FALSE,
    creee_le DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- Ce script ne crée volontairement AUCUN utilisateur : un mot de passe haché
-- doit toujours être généré par PHP (password_hash), jamais écrit à la main
-- dans un script SQL. Lancez php src/seed.php après ce script pour créer
-- un utilisateur de démonstration (voir INSTALLATION.md).
