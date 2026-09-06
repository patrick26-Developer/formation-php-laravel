<?php

$hash = null;
$resultatVerification = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mot_de_passe_a_hacher'])) {
        $hash = password_hash($_POST['mot_de_passe_a_hacher'], PASSWORD_DEFAULT);
    }

    if (isset($_POST['mot_de_passe_a_verifier'], $_POST['hash_a_verifier'])) {
        $resultatVerification = password_verify(
            $_POST['mot_de_passe_a_verifier'],
            $_POST['hash_a_verifier']
        );
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h3>Hacher un mot de passe</h3>
    <form method="POST">
        <input type="text" name="mot_de_passe_a_hacher" placeholder="Mot de passe">
        <button type="submit">Hacher</button>
    </form>
    <?php if ($hash !== null): ?>
        <p>Hash obtenu : <code><?= htmlspecialchars($hash) ?></code></p>
    <?php endif; ?>

    <h3>Vérifier un mot de passe</h3>
    <form method="POST">
        <input type="text" name="mot_de_passe_a_verifier" placeholder="Mot de passe à tester">
        <input type="text" name="hash_a_verifier" placeholder="Hash obtenu ci-dessus" size="60">
        <button type="submit">Vérifier</button>
    </form>
    <?php if ($resultatVerification !== null): ?>
        <p><?= $resultatVerification ? "Mot de passe correct ✅" : "Mot de passe incorrect ❌" ?></p>
    <?php endif; ?>
</body>
</html>
