<?php

declare(strict_types=1);

/**
 * Crée un utilisateur de démonstration : demo@example.com / demo1234
 * Usage : php src/seed.php
 */

require_once __DIR__ . '/Database.php';

$pdo = Database::getInstance();

$stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
$stmt->execute(['email' => 'demo@example.com']);

if ($stmt->fetch() !== false) {
    echo "L'utilisateur de démonstration existe déjà.\n";
    exit(0);
}

$stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)");
$stmt->execute([
    'email' => 'demo@example.com',
    'mot_de_passe' => password_hash('demo1234', PASSWORD_DEFAULT),
]);

echo "Utilisateur de démonstration créé : demo@example.com / demo1234\n";
