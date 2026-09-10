<?php
$commentaire = $_POST['commentaire'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php if ($commentaire !== null): ?>
        <h3>Without protection (dangerous):</h3>
        <div><?= $commentaire ?></div>
        <!--
          By entering <script>alert('hacked')</script>, this script ACTUALLY
          runs in the browser: this is an XSS (Cross-Site Scripting) flaw.
          Any visitor seeing this comment would run code injected by
          another user.
        -->

        <h3>With protection (htmlspecialchars):</h3>
        <div><?= htmlspecialchars($commentaire) ?></div>
        <!--
          Here, the characters <, >, ", ' are converted to HTML entities
          (&lt;, &gt;, etc.). The browser therefore displays the raw text
          "<script>alert('hacked')</script>" instead of running it: it's
          text, not code.
        -->
    <?php endif; ?>

    <form method="POST">
        <textarea name="commentaire" placeholder="Try: <script>alert('hacked')</script>"></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
