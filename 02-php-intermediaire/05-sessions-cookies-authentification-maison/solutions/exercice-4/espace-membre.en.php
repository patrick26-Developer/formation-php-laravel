<?php
session_start();

if (!isset($_SESSION['utilisateur_email'])) {
    header('Location: connexion.en.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Member area</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['utilisateur_email']) ?>!</p>
    <p><a href="deconnexion.en.php">Log out</a></p>
</body>
</html>
