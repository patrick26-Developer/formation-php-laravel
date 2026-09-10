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
        exit("Request rejected: invalid or missing CSRF token.");
    }

    $message = "Form processed successfully, valid CSRF token.";
}

$jeton = genererJetonCsrf();
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php if ($message !== null): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="text" name="commentaire" placeholder="A comment">
        <button type="submit">Send</button>
    </form>

    <!--
      To test the rejection: open the browser's developer tools, remove the
      <input type="hidden" name="jeton_csrf" ...> field from the displayed
      HTML, then submit the form. The server should respond with a
      403 "Request rejected".
    -->
</body>
</html>
