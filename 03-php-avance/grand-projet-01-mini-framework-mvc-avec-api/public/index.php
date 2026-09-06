<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Routeur;
use App\Controllers\TacheWebController;
use App\Controllers\TacheApiController;
use App\Database;
use App\Models\TacheRepository;

$repository = new TacheRepository(Database::getInstance());
$web = new TacheWebController($repository);
$api = new TacheApiController($repository);

$routeur = new Routeur();

// --- Routes web (HTML) ---
$routeur->get('/taches', [$web, 'liste']);
$routeur->get('/taches/creer', [$web, 'formulaireCreation']);
$routeur->post('/taches', [$web, 'creer']);

// --- Routes API (JSON), même Repository, même règles métier ---
$routeur->get('/api/taches', [$api, 'liste']);
$routeur->post('/api/taches', [$api, 'creer']);
$routeur->get('/api/taches/{id}', [$api, 'afficher']);
$routeur->put('/api/taches/{id}', [$api, 'modifier']);
$routeur->delete('/api/taches/{id}', [$api, 'supprimer']);

$routeur->distribuer($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
