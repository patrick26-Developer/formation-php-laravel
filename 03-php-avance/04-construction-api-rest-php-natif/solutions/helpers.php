<?php

declare(strict_types=1);

function repondreJson(mixed $donnees, int $codeStatut = 200): never {
    http_response_code($codeStatut);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($donnees, JSON_UNESCAPED_UNICODE);
    exit;
}

function lireCorpsJson(): array {
    $corpsBrut = file_get_contents('php://input');
    $donnees = json_decode($corpsBrut, true);

    if (!is_array($donnees)) {
        repondreJson(['erreur' => 'Corps de requête JSON invalide.'], 400);
    }

    return $donnees;
}
