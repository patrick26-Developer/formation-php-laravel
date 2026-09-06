<?php

declare(strict_types=1);

/**
 * Protection CSRF (module 02.6) réutilisée sur tous les formulaires
 * qui modifient des données (créer, modifier, supprimer une tâche).
 */
class CsrfHelper {
    public static function jeton(): string {
        if (!isset($_SESSION['jeton_csrf'])) {
            $_SESSION['jeton_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['jeton_csrf'];
    }

    public static function verifier(string $jetonRecu): bool {
        return hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu);
    }

    public static function exigerJetonValide(): void {
        if (!self::verifier($_POST['jeton_csrf'] ?? '')) {
            http_response_code(403);
            exit("Requête refusée : jeton de sécurité invalide.");
        }
    }
}
