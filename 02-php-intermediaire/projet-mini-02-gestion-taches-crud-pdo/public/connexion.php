<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/CsrfHelper.php';

if (Auth::estConnecte()) {
    header('Location: index.php');
    exit;
}

$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CsrfHelper::exigerJetonValide();

    $email = trim($_POST['email'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    $auth = new Auth(Database::getInstance());

    if ($auth->connecter($email, $motDePasse)) {
        header('Location: index.php');
        exit;
    }

    $erreur = "Email ou mot de passe incorrect.";
}

$jeton = CsrfHelper::jeton();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion — Gestionnaire de tâches</title>
</head>
<body>
    <h1>Connexion</h1>
    <p><em>Compte de démonstration : demo@example.com / demo1234 (voir INSTALLATION.md)</em></p>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
