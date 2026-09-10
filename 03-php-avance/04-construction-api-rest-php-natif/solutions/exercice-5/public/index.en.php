<?php

declare(strict_types=1);

require_once __DIR__ . '/../Routeur.en.php';
require_once __DIR__ . '/../helpers.en.php';
require_once __DIR__ . '/../Stockage.en.php';

$routeur = new Routeur();

$routeur->get('/api/taches', function () {
    repondreJson(array_values(Stockage::lireTaches()), 200);
});

$routeur->post('/api/taches', function () {
    $donnees = lireCorpsJson();

    if (empty($donnees['titre'])) {
        repondreJson(['erreur' => 'The "titre" field is required.'], 400);
    }

    $taches = Stockage::lireTaches();
    $id = count($taches) > 0 ? max(array_keys($taches)) + 1 : 1;

    $tache = ['id' => $id, 'titre' => $donnees['titre'], 'terminee' => false];
    $taches[$id] = $tache;
    Stockage::ecrireTaches($taches);

    repondreJson($tache, 201);
});

$routeur->get('/api/taches/{id}', function (string $id) {
    $taches = Stockage::lireTaches();
    $id = (int) $id;

    if (!isset($taches[$id])) {
        repondreJson(['erreur' => 'Task not found.'], 404);
    }

    repondreJson($taches[$id], 200);
});

$routeur->delete('/api/taches/{id}', function (string $id) {
    $taches = Stockage::lireTaches();
    $id = (int) $id;

    if (!isset($taches[$id])) {
        repondreJson(['erreur' => 'Task not found.'], 404);
    }

    unset($taches[$id]);
    Stockage::ecrireTaches($taches);

    repondreJson(null, 204);
});

$routeur->distribuer($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

/*
 * Run it: from "exercice-5", execute:
 *   php -S localhost:8000 public/index.php
 *
 * Tests with curl:
 *   curl http://localhost:8000/api/taches
 *   curl -X POST http://localhost:8000/api/taches -H "Content-Type: application/json" -d '{"titre":"Apprendre les API REST"}'
 *   curl http://localhost:8000/api/taches/1
 *   curl -X DELETE http://localhost:8000/api/taches/1
 *   curl http://localhost:8000/api/taches/999    # -> 404
 */
