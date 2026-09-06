<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.php";
require_once __DIR__ . "/LivreRepository.php";

$repository = new LivreRepository(obtenirConnexion());

echo "--- Recherche 'orwell' (titre ou auteur) ---\n";
foreach ($repository->lister(recherche: 'orwell') as $livre) {
    echo "{$livre['titre']} - {$livre['auteur']}\n";
}

echo "\n--- Filtre disponible = true ---\n";
foreach ($repository->lister(disponible: true) as $livre) {
    echo "{$livre['titre']}\n";
}

echo "\n--- Recherche ET filtre combinés ---\n";
foreach ($repository->lister(recherche: 'a', disponible: true) as $livre) {
    echo "{$livre['titre']} - {$livre['auteur']}\n";
}
