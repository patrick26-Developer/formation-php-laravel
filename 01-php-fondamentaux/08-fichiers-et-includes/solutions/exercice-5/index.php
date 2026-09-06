<?php

$titre = "Ma page d'accueil";

require __DIR__ . "/partials/header.php";
?>

<main>
    <h1><?= htmlspecialchars($titre) ?></h1>
    <p>Contenu dynamique de la page.</p>
</main>

<?php require __DIR__ . "/partials/footer.php"; ?>
