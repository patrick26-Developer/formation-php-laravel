<?php
$recherche = $_GET['recherche'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php if ($recherche !== null): ?>
        <p>You're searching for: <?= htmlspecialchars($recherche) ?></p>
    <?php endif; ?>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Search..." value="<?= htmlspecialchars($recherche ?? '') ?>">
        <button type="submit">Search</button>
    </form>

    <!--
      After submission, the URL becomes: ?recherche=your+term
      That's GET's defining trait: the data is visible and shareable
      directly in the URL, unlike POST.
    -->
</body>
</html>
