<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'clair';
    setcookie('theme', $theme, time() + (86400 * 7), '/');
    // Le cookie ne sera lisible via $_COOKIE qu'à la PROCHAINE requête,
    // pas dans cette même exécution du script.
    header('Location: exercice-2.php');
    exit;
}

$themeActif = $_COOKIE['theme'] ?? 'clair';
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <p>Thème actif : <strong><?= htmlspecialchars($themeActif) ?></strong></p>

    <form method="POST">
        <select name="theme">
            <option value="clair" <?= $themeActif === 'clair' ? 'selected' : '' ?>>Clair</option>
            <option value="sombre" <?= $themeActif === 'sombre' ? 'selected' : '' ?>>Sombre</option>
        </select>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
