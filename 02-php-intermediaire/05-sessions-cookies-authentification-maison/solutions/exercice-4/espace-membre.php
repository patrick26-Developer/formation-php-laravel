<?php
session_start();

if (!isset($_SESSION['utilisateur_email'])) {
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Espace membre</h1>
    <p>Bienvenue, <?= htmlspecialchars($_SESSION['utilisateur_email']) ?> !</p>
    <p><a href="deconnexion.php">Se déconnecter</a></p>
</body>
</html>
