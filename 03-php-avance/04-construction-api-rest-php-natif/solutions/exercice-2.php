<?php

declare(strict_types=1);

require_once __DIR__ . "/helpers.php";

$taches = []; // "base de données" en mémoire, pour l'exercice
$prochainId = 1;

function creerTache(array $donnees, array &$taches, int &$prochainId): array {
    if (empty($donnees['titre'])) {
        repondreJson(['erreur' => 'Le champ "titre" est requis.'], 400);
    }

    $tache = [
        'id' => $prochainId,
        'titre' => $donnees['titre'],
        'terminee' => false,
    ];

    $taches[$prochainId] = $tache;
    $prochainId++;

    return $tache;
}

// --- Test direct (sans vraie requête HTTP), pour vérifier la logique ---
$nouvelleTache = creerTache(['titre' => 'Faire les courses'], $taches, $prochainId);
repondreJson($nouvelleTache, 201);

/*
 * Câblage réel pour un vrai endpoint HTTP (POST /api/taches) :
 *
 * $donnees = lireCorpsJson();
 * $tache = creerTache($donnees, $taches, $prochainId);
 * repondreJson($tache, 201);
 *
 * Testable avec curl :
 * curl -X POST http://localhost:8000/api/taches -H "Content-Type: application/json" -d '{"titre":"Faire les courses"}'
 */
