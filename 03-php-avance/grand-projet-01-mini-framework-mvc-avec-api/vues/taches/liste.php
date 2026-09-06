<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes tâches</title>
</head>
<body>
    <h1>Mes tâches</h1>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Rechercher..." value="<?= htmlspecialchars($recherche ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>

    <p><a href="/taches/creer">+ Nouvelle tâche</a></p>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th><a href="?tri=titre&ordre=<?= $ordre === 'ASC' ? 'DESC' : 'ASC' ?>">Titre</a></th>
                <th>Statut</th>
                <th><a href="?tri=creee_le&ordre=<?= $ordre === 'ASC' ? 'DESC' : 'ASC' ?>">Créée le</a></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($taches)): ?>
                <tr><td colspan="3">Aucune tâche.</td></tr>
            <?php endif; ?>
            <?php foreach ($taches as $tache): ?>
                <tr>
                    <td><?= htmlspecialchars($tache['titre']) ?></td>
                    <td><?= $tache['terminee'] ? '✅' : '🕓' ?></td>
                    <td><?= htmlspecialchars($tache['creee_le']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <a href="?page=<?= $p ?>&tri=<?= $tri ?>&ordre=<?= $ordre ?>"><?= $p === $page ? "[$p]" : $p ?></a>
        <?php endfor; ?>
    </p>

    <p><em>Cette même liste est disponible en JSON via <code>GET /api/taches</code>.</em></p>
</body>
</html>
