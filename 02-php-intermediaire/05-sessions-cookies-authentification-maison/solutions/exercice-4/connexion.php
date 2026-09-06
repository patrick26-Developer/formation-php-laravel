<?php
session_start();

// Annuaire simulé : email => hash du mot de passe "secret123"
$utilisateursSimules = [
    'alice@example.com' => password_hash('secret123', PASSWORD_DEFAULT),
];

$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    if (isset($utilisateursSimules[$email]) && password_verify($motDePasse, $utilisateursSimules[$email])) {
        $_SESSION['utilisateur_email'] = $email;
        header('Location: espace-membre.php');
        exit;
    }

    $erreur = "Email ou mot de passe incorrect.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Connexion</h1>
    <p><em>Compte de test : alice@example.com / secret123</em></p>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
