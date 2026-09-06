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

    <form method="POST" action="/taches">
        <input type="text" name="titre" placeholder="Titre" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Créer</button>
    </form>

    <p><a href="/taches">← Retour à la liste</a></p>
</body>
</html>
