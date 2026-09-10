<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";
require_once __DIR__ . "/LivreRepository.en.php";

$repository = new LivreRepository(obtenirConnexion());

echo "--- Sorted by title, ascending ---\n";
foreach ($repository->lister(tri: 'titre', ordre: 'ASC') as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}

echo "\n--- Sorted by year, descending ---\n";
foreach ($repository->lister(tri: 'annee', ordre: 'DESC') as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}

echo "\n--- Attempt with a disallowed column (falls back to 'annee') ---\n";
foreach ($repository->lister(tri: 'mot_de_passe_admin') as $livre) {
    echo "{$livre['titre']}\n";
}
