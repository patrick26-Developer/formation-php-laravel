<?php

$titre = "My home page";

require __DIR__ . "/partials/header.en.php";
?>

<main>
    <h1><?= htmlspecialchars($titre) ?></h1>
    <p>Dynamic page content.</p>
</main>

<?php require __DIR__ . "/partials/footer.en.php"; ?>
