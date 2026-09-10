<?php

declare(strict_types=1);

require_once __DIR__ . "/helpers.en.php";

$taches = []; // in-memory "database", for the exercise
$prochainId = 1;

function creerTache(array $donnees, array &$taches, int &$prochainId): array {
    if (empty($donnees['titre'])) {
        repondreJson(['erreur' => 'The "titre" field is required.'], 400);
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

// --- Direct test (without a real HTTP request), to check the logic ---
$nouvelleTache = creerTache(['titre' => 'Faire les courses'], $taches, $prochainId);
repondreJson($nouvelleTache, 201);

/*
 * Real wiring for an actual HTTP endpoint (POST /api/taches):
 *
 * $donnees = lireCorpsJson();
 * $tache = creerTache($donnees, $taches, $prochainId);
 * repondreJson($tache, 201);
 *
 * Testable with curl:
 * curl -X POST http://localhost:8000/api/taches -H "Content-Type: application/json" -d '{"titre":"Faire les courses"}'
 */
