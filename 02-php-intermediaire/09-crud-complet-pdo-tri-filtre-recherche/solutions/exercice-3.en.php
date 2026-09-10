<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";
require_once __DIR__ . "/LivreRepository.en.php";

$repository = new LivreRepository(obtenirConnexion());

echo "--- Search 'orwell' (title or author) ---\n";
foreach ($repository->lister(recherche: 'orwell') as $livre) {
    echo "{$livre['titre']} - {$livre['auteur']}\n";
}

echo "\n--- Filter disponible = true ---\n";
foreach ($repository->lister(disponible: true) as $livre) {
    echo "{$livre['titre']}\n";
}

echo "\n--- Search AND filter combined ---\n";
foreach ($repository->lister(recherche: 'a', disponible: true) as $livre) {
    echo "{$livre['titre']} - {$livre['auteur']}\n";
}
