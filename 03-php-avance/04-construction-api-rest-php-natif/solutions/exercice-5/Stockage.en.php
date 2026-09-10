<?php

declare(strict_types=1);

/**
 * Very simple JSON-file storage, ONLY to let this exercise persist data
 * between two different HTTP requests (the built-in PHP server starts a
 * new process for each request, so a plain in-memory PHP array wouldn't
 * survive from one request to the next). In a real situation, this
 * would of course be a real database (PDO, modules 02.8/02.9).
 */
class Stockage {
    private const FICHIER = __DIR__ . '/data.json';

    public static function lireTaches(): array {
        if (!file_exists(self::FICHIER)) {
            return [];
        }

        return json_decode(file_get_contents(self::FICHIER), true) ?? [];
    }

    public static function ecrireTaches(array $taches): void {
        file_put_contents(self::FICHIER, json_encode($taches, JSON_PRETTY_PRINT));
    }
}
