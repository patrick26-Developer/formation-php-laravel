<?php
$commentaire = $_POST['commentaire'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <?php if ($commentaire !== null): ?>
        <h3>Sans protection (dangereux) :</h3>
        <div><?= $commentaire ?></div>
        <!--
          En saisissant <script>alert('piraté')</script>, ce script s'exécute
          RÉELLEMENT dans le navigateur : c'est une faille XSS (Cross-Site
          Scripting). N'importe quel visiteur voyant ce commentaire exécuterait
          du code injecté par un autre utilisateur.
        -->

        <h3>Avec protection (htmlspecialchars) :</h3>
        <div><?= htmlspecialchars($commentaire) ?></div>
        <!--
          Ici, les caractères <, >, ", ' sont convertis en entités HTML
          (&lt;, &gt;, etc.). Le navigateur affiche donc le texte brut
          "<script>alert('piraté')</script>" au lieu de l'exécuter :
          c'est du texte, plus du code.
        -->
    <?php endif; ?>

    <form method="POST">
        <textarea name="commentaire" placeholder="Essayez : <script>alert('piraté')</script>"></textarea>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
