<?php
$recherche = $_GET['recherche'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if ($recherche !== null): ?>
        <p>Vous cherchez : <?= htmlspecialchars($recherche) ?></p>
    <?php endif; ?>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Rechercher..." value="<?= htmlspecialchars($recherche ?? '') ?>">
        <button type="submit">Chercher</button>
    </form>

    <!--
      Après soumission, l'URL devient : ?recherche=votre+terme
      C'est la caractéristique de GET : les données sont visibles et
      partageables directement dans l'URL, contrairement à POST.
    -->
</body>
</html>
