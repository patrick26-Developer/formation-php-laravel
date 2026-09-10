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
        $erreurs[] = "The name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "The email is not valid.";
    }

    if (!is_numeric($age) || (int) $age < 18 || (int) $age > 120) {
        $erreurs[] = "The age must be a number between 18 and 120.";
    }

    if (empty($erreurs)) {
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php if ($succes): ?>
        <p style="color:green;">Registration successful for <?= htmlspecialchars($nom) ?>!</p>
    <?php else: ?>
        <?php foreach ($erreurs as $erreur): ?>
            <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>

        <form method="POST">
            <input type="text" name="nom" placeholder="Name" value="<?= htmlspecialchars($nom) ?>">
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
            <input type="number" name="age" placeholder="Age" value="<?= htmlspecialchars($age) ?>">
            <button type="submit">Sign up</button>
        </form>
    <?php endif; ?>
</body>
</html>
