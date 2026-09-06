<?php
$erreurs = [];
$nom = '';
$email = '';
$age = '';
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = trim($_POST['age'] ?? '');

    if ($nom === '') {
        $erreurs[] = "Le nom est requis.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    if (!is_numeric($age) || (int) $age < 18 || (int) $age > 120) {
        $erreurs[] = "L'âge doit être un nombre entre 18 et 120.";
    }

    if (empty($erreurs)) {
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if ($succes): ?>
        <p style="color:green;">Inscription réussie pour <?= htmlspecialchars($nom) ?> !</p>
    <?php else: ?>
        <?php foreach ($erreurs as $erreur): ?>
            <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>

        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($nom) ?>">
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
            <input type="number" name="age" placeholder="Âge" value="<?= htmlspecialchars($age) ?>">
            <button type="submit">S'inscrire</button>
        </form>
    <?php endif; ?>
</body>
</html>
