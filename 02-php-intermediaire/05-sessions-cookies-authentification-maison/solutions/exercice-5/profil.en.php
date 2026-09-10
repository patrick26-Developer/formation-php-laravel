<?php
session_start();
require_once __DIR__ . "/exiger-connexion.en.php";

exigerConnexion(); // same guard reused on every protected page
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1>My profile</h1>
    <p>Logged in as <?= htmlspecialchars($_SESSION['utilisateur_email']) ?></p>
    <p><a href="parametres.en.php">View my settings</a></p>
</body>
</html>
