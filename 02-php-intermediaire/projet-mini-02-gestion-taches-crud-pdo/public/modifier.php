<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/TacheRepository.php';
require_once __DIR__ . '/../src/CsrfHelper.php';

Auth::exigerConnexion();

$repository = new TacheRepository(Database::getInstance());
$utilisateurId = Auth::idUtilisateurConnecte();

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$tache = $repository->trouver($id, $utilisateurId);

if ($tache === null) {
    http_response_code(404);
    exit("Tâche introuvable.");
}

$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CsrfHelper::exigerJetonValide();

    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $terminee = isset($_POST['terminee']);

    if ($titre === '') {
        $erreur = "Le titre est requis.";
    } else {
        $repository->modifier($id, $utilisateurId, $titre, $description, $terminee);
        header('Location: index.php');
        exit;
    }
}

$jeton = CsrfHelper::jeton();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la tâche</title>
</head>
<body>
    <h1>Modifier la tâche</h1>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="hidden" name="id" value="<?= $tache['id'] ?>">
        <input type="text" name="titre" value="<?= htmlspecialchars($_POST['titre'] ?? $tache['titre']) ?>" required>
        <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $tache['description'] ?? '') ?></textarea>
        <label>
            <input type="checkbox" name="terminee" <?= $tache['terminee'] ? 'checked' : '' ?>>
            Tâche terminée
        </label>
        <button type="submit">Enregistrer</button>
    </form>

    <p><a href="index.php">← Retour à la liste</a></p>
</body>
</html>
