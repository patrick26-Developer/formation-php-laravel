<?php
session_start();

$_SESSION['visites'] = ($_SESSION['visites'] ?? 0) + 1;
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <p>Vous avez visité cette page <?= $_SESSION['visites'] ?> fois.</p>
    <p><a href="">Recharger la page</a></p>
</body>
</html>
