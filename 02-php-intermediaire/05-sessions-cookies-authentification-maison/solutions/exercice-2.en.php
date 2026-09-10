<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'clair';
    setcookie('theme', $theme, time() + (86400 * 7), '/');
    // The cookie will only be readable via $_COOKIE on the NEXT request,
    // not within this same script execution.
    header('Location: exercice-2.en.php');
    exit;
}

$themeActif = $_COOKIE['theme'] ?? 'clair';
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <p>Active theme: <strong><?= htmlspecialchars($themeActif) ?></strong></p>

    <form method="POST">
        <select name="theme">
            <option value="clair" <?= $themeActif === 'clair' ? 'selected' : '' ?>>Light</option>
            <option value="sombre" <?= $themeActif === 'sombre' ? 'selected' : '' ?>>Dark</option>
        </select>
        <button type="submit">Save</button>
    </form>
</body>
</html>
