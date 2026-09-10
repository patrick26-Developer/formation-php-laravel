<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";

function marquerIndisponible(PDO $pdo, int $id): int {
    $stmt = $pdo->prepare("UPDATE livres SET disponible = 0 WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->rowCount();
}

function supprimerLivre(PDO $pdo, int $id): int {
    $stmt = $pdo->prepare("DELETE FROM livres WHERE id = :id");
    $stmt->execute(['id' => $id]);

    return $stmt->rowCount();
}

$pdo = obtenirConnexion();

$lignesModifiees = marquerIndisponible($pdo, 1);
echo "$lignesModifiees row(s) marked unavailable\n";

$lignesSupprimees = supprimerLivre($pdo, 2);
echo "$lignesSupprimees row(s) deleted\n";
