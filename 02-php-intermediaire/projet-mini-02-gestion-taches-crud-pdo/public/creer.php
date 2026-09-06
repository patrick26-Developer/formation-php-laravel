<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/TacheRepository.php';
require_once __DIR__ . '/../src/CsrfHelper.php';

Auth::exigerConnexion();

$repository = new TacheRepository(Database::getInstance());
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CsrfHelper::exigerJetonValide();

    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($titre === '') {
        $erreur = "Le titre est requis.";
    } else {
        $repository->creer(Auth::idUtilisateurConnecte(), $titre, $description);
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
    <title>Nouvelle tâche</title>
</head>
<body>
    <h1>Nouvelle tâche</h1>

    <?php if ($erreur !== null): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="text" name="titre" placeholder="Titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" required>
        <textarea name="description" placeholder="Description (optionnelle)"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <button type="submit">Créer</button>
    </form>

    <p><a href="index.php">← Retour à la liste</a></p>
</body>
</html>
