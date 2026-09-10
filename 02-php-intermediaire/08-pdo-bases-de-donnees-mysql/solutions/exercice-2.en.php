<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";

$pdo = obtenirConnexion();

$livres = [
    ['titre' => '1984', 'auteur' => 'George Orwell', 'annee' => 1949],
    ['titre' => 'Le Petit Prince', 'auteur' => 'Antoine de Saint-Exupéry', 'annee' => 1943],
    ['titre' => 'Fahrenheit 451', 'auteur' => 'Ray Bradbury', 'annee' => 1953],
    ['titre' => 'Dune', 'auteur' => 'Frank Herbert', 'annee' => 1965],
];

$stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, annee) VALUES (:titre, :auteur, :annee)");

foreach ($livres as $livre) {
    $stmt->execute($livre);
    echo "Book '{$livre['titre']}' created with ID " . $pdo->lastInsertId() . "\n";
}
