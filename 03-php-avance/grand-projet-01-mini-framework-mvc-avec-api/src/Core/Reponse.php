<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Helpers de réponse JSON (module 03.4), centralisés ici pour être
 * partagés par tous les contrôleurs d'API.
 */
class Reponse
{
    public static function json(mixed $donnees, int $codeStatut = 200): never
    {
        http_response_code($codeStatut);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($donnees, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function corpsJson(): array
    {
        $donnees = json_decode(file_get_contents('php://input'), true);

        if (!is_array($donnees)) {
            self::json(['succes' => false, 'erreur' => 'Corps de requête JSON invalide.'], 400);
        }

        return $donnees;
    }
}
