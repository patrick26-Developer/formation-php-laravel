<?php

declare(strict_types=1);

/**
 * Connexion PDO centralisée (pattern Singleton, voir module 02.3 et 02.8).
 * getInstance() garantit qu'une seule connexion est ouverte pour toute
 * la durée de vie d'une requête HTTP.
 */
class Database {
    private static ?PDO $instance = null;

    private function __construct() {
    }

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config.php';

            self::$instance = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$instance;
    }
}
