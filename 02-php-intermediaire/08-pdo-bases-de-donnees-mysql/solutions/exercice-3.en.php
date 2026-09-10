<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";

$pdo = obtenirConnexion();

// List of available books, sorted by descending year
$stmt = $pdo->query("SELECT * FROM livres WHERE disponible = 1 ORDER BY annee DESC");
$livresDisponibles = $stmt->fetchAll();

echo "--- Available books ---\n";
foreach ($livresDisponibles as $livre) {
    echo "{$livre['titre']} ({$livre['annee']}) - {$livre['auteur']}\n";
}

// Search by author (e.g.: index.php?auteur=Orwell)
$auteurRecherche = $_GET['auteur'] ?? null;

if ($auteurRecherche !== null) {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE auteur LIKE :auteur");
    $stmt->execute(['auteur' => '%' . $auteurRecherche . '%']);
    $resultats = $stmt->fetchAll();

    echo "\n--- Results for author '$auteurRecherche' ---\n";
    foreach ($resultats as $livre) {
        echo "{$livre['titre']} ({$livre['annee']})\n";
    }
}
