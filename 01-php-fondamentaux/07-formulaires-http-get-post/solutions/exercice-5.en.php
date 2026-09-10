<?php
// name="langages[]" (with brackets) tells PHP to group every checked box
// into an ARRAY rather than overwriting a single value.
$langages = $_POST['langages'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php if (!empty($langages)): ?>
        <h3>Selected languages:</h3>
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
        <button type="submit">Submit</button>
    </form>
</body>
</html>
