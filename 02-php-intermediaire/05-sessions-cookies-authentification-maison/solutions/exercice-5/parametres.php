<?php
session_start();
require_once __DIR__ . "/exiger-connexion.php";

exigerConnexion(); // la même fonction protège une seconde page, sans duplication de logique
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Paramètres</h1>
    <p>Page accessible uniquement si connecté, comme /profil.php.</p>
    <p><a href="profil.php">Retour au profil</a></p>
</body>
</html>
