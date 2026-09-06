<?php

declare(strict_types=1);

session_start();

function genererJetonCsrf(): string {
    if (!isset($_SESSION['jeton_csrf'])) {
        $_SESSION['jeton_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['jeton_csrf'];
}

function verifierJetonCsrf(string $jetonRecu): bool {
    return hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu);
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifierJetonCsrf($_POST['jeton_csrf'] ?? '')) {
        http_response_code(403);
        exit("Requête refusée : jeton CSRF invalide ou manquant.");
    }

    $message = "Formulaire traité avec succès, jeton CSRF valide.";
}

$jeton = genererJetonCsrf();
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if ($message !== null): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="text" name="commentaire" placeholder="Un commentaire">
        <button type="submit">Envoyer</button>
    </form>

    <!--
      Pour tester le rejet : ouvrez les outils de développement du navigateur,
      supprimez le champ <input type="hidden" name="jeton_csrf" ...> dans le
      HTML affiché, puis soumettez le formulaire. Le serveur doit répondre
      403 "Requête refusée".
    -->
</body>
</html>
