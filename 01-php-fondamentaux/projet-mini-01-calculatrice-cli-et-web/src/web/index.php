<?php

declare(strict_types=1);

require_once __DIR__ . "/../Calculatrice.php";

$resultat = null;
$erreur = null;
$nombre1 = '';
$nombre2 = '';
$operation = '+';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre1 = trim($_POST['nombre1'] ?? '');
    $nombre2 = trim($_POST['nombre2'] ?? '');
    $operation = $_POST['operation'] ?? '+';

    if (!is_numeric($nombre1) || !is_numeric($nombre2)) {
        $erreur = "Les deux valeurs doivent être des nombres.";
    } else {
        try {
            $resultat = calculer((float) $nombre1, $operation, (float) $nombre2);
        } catch (InvalidArgumentException $e) {
            $erreur = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calculatrice</title>
</head>
<body>
    <h1>Calculatrice</h1>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php elseif ($resultat !== null): ?>
        <p>Résultat : <strong><?= htmlspecialchars((string) $resultat) ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nombre1" value="<?= htmlspecialchars($nombre1) ?>" placeholder="Nombre 1" required>

        <select name="operation">
            <?php foreach (operationsDisponibles() as $op): ?>
                <option value="<?= $op ?>" <?= $operation === $op ? 'selected' : '' ?>><?= $op ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="nombre2" value="<?= htmlspecialchars($nombre2) ?>" placeholder="Nombre 2" required>

        <button type="submit">Calculer</button>
    </form>
</body>
</html>
