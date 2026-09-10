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
<html lang="en">
<body>
    <h3>Hash a password</h3>
    <form method="POST">
        <input type="text" name="mot_de_passe_a_hacher" placeholder="Password">
        <button type="submit">Hash</button>
    </form>
    <?php if ($hash !== null): ?>
        <p>Resulting hash: <code><?= htmlspecialchars($hash) ?></code></p>
    <?php endif; ?>

    <h3>Verify a password</h3>
    <form method="POST">
        <input type="text" name="mot_de_passe_a_verifier" placeholder="Password to test">
        <input type="text" name="hash_a_verifier" placeholder="Hash obtained above" size="60">
        <button type="submit">Verify</button>
    </form>
    <?php if ($resultatVerification !== null): ?>
        <p><?= $resultatVerification ? "Correct password ✅" : "Incorrect password ❌" ?></p>
    <?php endif; ?>
</body>
</html>
