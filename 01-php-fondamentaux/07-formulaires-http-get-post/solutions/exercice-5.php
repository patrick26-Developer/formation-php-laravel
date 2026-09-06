<?php
// name="langages[]" (avec les crochets) indique à PHP de regrouper toutes
// les cases cochées dans un TABLEAU plutôt que d'écraser une seule valeur.
$langages = $_POST['langages'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if (!empty($langages)): ?>
        <h3>Langages sélectionnés :</h3>
        <ul>
            <?php foreach ($langages as $langage): ?>
                <li><?= htmlspecialchars($langage) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label><input type="checkbox" name="langages[]" value="PHP"> PHP</label>
        <label><input type="checkbox" name="langages[]" value="JavaScript"> JavaScript</label>
        <label><input type="checkbox" name="langages[]" value="Python"> Python</label>
        <label><input type="checkbox" name="langages[]" value="Go"> Go</label>
        <button type="submit">Valider</button>
    </form>
</body>
</html>
