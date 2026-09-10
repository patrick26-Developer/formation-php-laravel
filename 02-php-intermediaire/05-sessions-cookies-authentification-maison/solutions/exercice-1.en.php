<?php
session_start();

$_SESSION['visites'] = ($_SESSION['visites'] ?? 0) + 1;
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <p>You have visited this page <?= $_SESSION['visites'] ?> times.</p>
    <p><a href="">Reload the page</a></p>
</body>
</html>
