<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\RapportGenerator;

// Usage : php bin/generer-rapport.php donnees/ventes.csv "Rapport des ventes" sortie/rapport.pdf

[, $cheminCsv, $titre, $cheminSortie] = $argv + [null, null, null, null];

if ($cheminCsv === null || $titre === null || $cheminSortie === null) {
    fwrite(STDERR, "Usage : php bin/generer-rapport.php <fichier.csv> <titre> <sortie.pdf>\n");
    exit(1);
}

try {
    $generateur = new RapportGenerator();
    $pdf = $generateur->genererDepuisCsv($cheminCsv, $titre);

    $dossierSortie = dirname($cheminSortie);
    if (!is_dir($dossierSortie)) {
        mkdir($dossierSortie, 0755, true);
    }

    file_put_contents($cheminSortie, $pdf);

    echo "Rapport généré avec succès : $cheminSortie\n";
} catch (\RuntimeException $e) {
    fwrite(STDERR, 'Erreur : ' . $e->getMessage() . "\n");
    exit(1);
}
