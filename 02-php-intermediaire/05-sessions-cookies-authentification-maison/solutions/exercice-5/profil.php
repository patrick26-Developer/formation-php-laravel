<?php
session_start();
require_once __DIR__ . "/exiger-connexion.php";

exigerConnexion(); // même garde réutilisée sur chaque page protégée
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Mon profil</h1>
    <p>Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_email']) ?></p>
    <p><a href="parametres.php">Voir mes paramètres</a></p>
</body>
</html>
