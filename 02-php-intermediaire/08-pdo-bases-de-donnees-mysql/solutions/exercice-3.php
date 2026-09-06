<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.php";

$pdo = obtenirConnexion();

// Liste des livres disponibles, triés par année décroissante
$stmt = $pdo->query("SELECT * FROM livres WHERE disponible = 1 ORDER BY annee DESC");
$livresDisponibles = $stmt->fetchAll();

echo "--- Livres disponibles ---\n";
foreach ($livresDisponibles as $livre) {
    echo "{$livre['titre']} ({$livre['annee']}) - {$livre['auteur']}\n";
}

// Recherche par auteur (ex: index.php?auteur=Orwell)
$auteurRecherche = $_GET['auteur'] ?? null;

if ($auteurRecherche !== null) {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE auteur LIKE :auteur");
    $stmt->execute(['auteur' => '%' . $auteurRecherche . '%']);
    $resultats = $stmt->fetchAll();

    echo "\n--- Résultats pour l'auteur '$auteurRecherche' ---\n";
    foreach ($resultats as $livre) {
        echo "{$livre['titre']} ({$livre['annee']})\n";
    }
}
