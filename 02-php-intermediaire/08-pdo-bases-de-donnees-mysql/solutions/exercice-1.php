<?php

declare(strict_types=1);

try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;dbname=formation_php_exercices;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    echo "Connexion réussie.";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
