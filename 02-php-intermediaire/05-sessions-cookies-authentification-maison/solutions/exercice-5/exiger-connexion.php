<?php

declare(strict_types=1);

function exigerConnexion(): void {
    if (!isset($_SESSION['utilisateur_email'])) {
        header('Location: connexion.php');
        exit;
    }
}
