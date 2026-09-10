<?php
session_start();
require_once __DIR__ . "/exiger-connexion.en.php";

exigerConnexion(); // the same function protects a second page, no duplicated logic
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Settings</h1>
    <p>Page accessible only when logged in, just like /profil.php.</p>
    <p><a href="profil.en.php">Back to profile</a></p>
</body>
</html>
