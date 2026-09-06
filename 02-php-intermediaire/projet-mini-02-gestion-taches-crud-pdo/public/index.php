<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/TacheRepository.php';

Auth::exigerConnexion();

$repository = new TacheRepository(Database::getInstance());
$utilisateurId = Auth::idUtilisateurConnecte();

$tri = $_GET['tri'] ?? 'creee_le';
$ordre = $_GET['ordre'] ?? 'DESC';
$recherche = $_GET['recherche'] ?? null;
$filtreStatut = $_GET['statut'] ?? 'toutes'; // toutes | terminees | en_cours
$page = max(1, (int) ($_GET['page'] ?? 1));
$parPage = 5;

$terminee = match ($filtreStatut) {
    'terminees' => true,
    'en_cours' => false,
    default => null,
};

$taches = $repository->lister(
    utilisateurId: $utilisateurId,
    tri: $tri,
    ordre: $ordre,
    recherche: $recherche,
    terminee: $terminee,
    page: $page,
    parPage: $parPage,
);

$total = $repository->compter($utilisateurId, $recherche, $terminee);
$totalPages = max(1, (int) ceil($total / $parPage));

function lienTri(string $colonne, string $triActuel, string $ordreActuel): string {
    $nouvelOrdre = ($triActuel === $colonne && $ordreActuel === 'ASC') ? 'DESC' : 'ASC';
    return "?tri=$colonne&ordre=$nouvelOrdre";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes tâches</title>
</head>
<body>
    <h1>Mes tâches</h1>
    <p>Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_email']) ?> — <a href="deconnexion.php">Se déconnecter</a></p>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Rechercher un titre..." value="<?= htmlspecialchars($recherche ?? '') ?>">
        <select name="statut">
            <option value="toutes" <?= $filtreStatut === 'toutes' ? 'selected' : '' ?>>Toutes</option>
            <option value="en_cours" <?= $filtreStatut === 'en_cours' ? 'selected' : '' ?>>En cours</option>
            <option value="terminees" <?= $filtreStatut === 'terminees' ? 'selected' : '' ?>>Terminées</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <p><a href="creer.php">+ Nouvelle tâche</a></p>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th><a href="<?= lienTri('titre', $tri, $ordre) ?>">Titre</a></th>
                <th>Description</th>
                <th><a href="<?= lienTri('terminee', $tri, $ordre) ?>">Statut</a></th>
                <th><a href="<?= lienTri('creee_le', $tri, $ordre) ?>">Créée le</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($taches)): ?>
                <tr><td colspan="5">Aucune tâche trouvée.</td></tr>
            <?php endif; ?>
            <?php foreach ($taches as $tache): ?>
                <tr>
                    <td><?= htmlspecialchars($tache['titre']) ?></td>
                    <td><?= htmlspecialchars($tache['description'] ?? '') ?></td>
                    <td><?= $tache['terminee'] ? '✅ Terminée' : '🕓 En cours' ?></td>
                    <td><?= htmlspecialchars($tache['creee_le']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $tache['id'] ?>">Modifier</a>
                        |
                        <a href="supprimer.php?id=<?= $tache['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p === $page): ?>
                <strong><?= $p ?></strong>
            <?php else: ?>
                <a href="?page=<?= $p ?>&tri=<?= $tri ?>&ordre=<?= $ordre ?>&recherche=<?= urlencode($recherche ?? '') ?>&statut=<?= $filtreStatut ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </p>
</body>
</html>
