<?php
session_start();

// Simulated directory: email => hash of the password "secret123"
$utilisateursSimules = [
    'alice@example.com' => password_hash('secret123', PASSWORD_DEFAULT),
];

$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    if (isset($utilisateursSimules[$email]) && password_verify($motDePasse, $utilisateursSimules[$email])) {
        $_SESSION['utilisateur_email'] = $email;
        header('Location: espace-membre.en.php');
        exit;
    }

    $erreur = "Incorrect email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Login</h1>
    <p><em>Test account: alice@example.com / secret123</em></p>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Password" required>
        <button type="submit">Log in</button>
    </form>
</body>
</html>
