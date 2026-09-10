<?php

declare(strict_types=1);

require_once __DIR__ . "/helpers.en.php";

$taches = [
    1 => ['id' => 1, 'titre' => 'Faire les courses', 'terminee' => false],
    2 => ['id' => 2, 'titre' => 'Réviser PHP', 'terminee' => true],
];

function trouverTache(int $id, array $taches): array {
    if (!isset($taches[$id])) {
        repondreJson(['erreur' => 'Task not found.'], 404);
    }

    return $taches[$id];
}

function supprimerTache(int $id, array &$taches): void {
    if (!isset($taches[$id])) {
        repondreJson(['erreur' => 'Task not found.'], 404);
    }

    unset($taches[$id]);
    repondreJson(null, 204); // 204 No Content: success, nothing to return
}

// --- Simulating GET /taches/1 ---
$id = (int) ($_GET['id'] ?? 1);
$methode = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($methode === 'DELETE') {
    supprimerTache($id, $taches);
} else {
    repondreJson(trouverTache($id, $taches), 200);
}
