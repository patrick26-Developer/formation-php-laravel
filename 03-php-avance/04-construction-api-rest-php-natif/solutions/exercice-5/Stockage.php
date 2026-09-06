<?php

declare(strict_types=1);

/**
 * Stockage très simple sur fichier JSON, UNIQUEMENT pour permettre à cet
 * exercice de persister des données entre deux requêtes HTTP différentes
 * (le serveur PHP intégré démarre un nouveau processus à chaque requête,
 * donc un simple tableau PHP en mémoire ne survivrait pas d'une requête à
 * l'autre). En situation réelle, ce serait bien sûr une vraie base de
 * données (PDO, modules 02.8/02.9).
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
