<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";
require_once __DIR__ . "/LivreRepository.en.php";

/**
 * Usage: php exercice-5.php --tri=titre --ordre=asc --recherche=Orwell
 */

// Parses --key=value style arguments into an associative array
$options = [];
foreach (array_slice($argv, 1) as $argument) {
    if (str_starts_with($argument, '--') && str_contains($argument, '=')) {
        [$cle, $valeur] = explode('=', substr($argument, 2), 2);
        $options[$cle] = $valeur;
    }
}

$repository = new LivreRepository(obtenirConnexion());

$livres = $repository->lister(
    tri: $options['tri'] ?? 'annee',
    ordre: $options['ordre'] ?? 'DESC',
    recherche: $options['recherche'] ?? null,
);

if (empty($livres)) {
    echo "No results.\n";
    exit(0);
}

// Displayed as an aligned text table
$largeurTitre = max(array_map(fn(array $l): int => strlen($l['titre']), $livres));

printf("%-{$largeurTitre}s | %-20s | %s\n", "TITLE", "AUTHOR", "YEAR");
echo str_repeat("-", $largeurTitre + 32) . "\n";

foreach ($livres as $livre) {
    printf("%-{$largeurTitre}s | %-20s | %d\n", $livre['titre'], $livre['auteur'], $livre['annee']);
}
