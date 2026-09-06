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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CsrfHelper::exigerJetonValide();

    $repository->supprimer($id, $utilisateurId);
    header('Location: index.php');
    exit;
}

$jeton = CsrfHelper::jeton();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer la tâche</title>
</head>
<body>
    <h1>Confirmer la suppression</h1>
    <p>Voulez-vous vraiment supprimer la tâche « <?= htmlspecialchars($tache['titre']) ?> » ?</p>

    <form method="POST">
        <input type="hidden" name="jeton_csrf" value="<?= $jeton ?>">
        <input type="hidden" name="id" value="<?= $tache['id'] ?>">
        <button type="submit">Oui, supprimer</button>
    </form>

    <p><a href="index.php">Annuler</a></p>
</body>
</html>
