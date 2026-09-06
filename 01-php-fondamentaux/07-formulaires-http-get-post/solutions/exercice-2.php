<?php
$resultat = null;
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre1 = (float) ($_POST['nombre1'] ?? 0);
    $nombre2 = (float) ($_POST['nombre2'] ?? 0);
    $operation = $_POST['operation'] ?? '+';

    $resultat = match ($operation) {
        '+' => $nombre1 + $nombre2,
        '-' => $nombre1 - $nombre2,
        '*' => $nombre1 * $nombre2,
        '/' => $nombre2 !== 0.0 ? $nombre1 / $nombre2 : null,
        default => null,
    };

    if ($operation === '/' && $nombre2 === 0.0) {
        $erreur = "Division par zéro impossible.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php elseif ($resultat !== null): ?>
        <p>Résultat : <?= htmlspecialchars((string) $resultat) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="number" step="any" name="nombre1" required>
        <select name="operation">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" step="any" name="nombre2" required>
        <button type="submit">Calculer</button>
    </form>
</body>
</html>
