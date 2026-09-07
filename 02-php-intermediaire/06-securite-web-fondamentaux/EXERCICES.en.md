# Exercises — 02.6 Web Security Fundamentals

## Exercise 1 — Identify the flaws (easy)

For each of these code snippets, identify the flaw (SQL injection, XSS, or none) and explain why in a comment:

```php
// A
echo "Hello " . $_GET['nom'];

// B
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);

// C
$requete = "SELECT * FROM produits WHERE nom = '" . $_GET['nom'] . "'";
$pdo->query($requete);

// D
echo "Hello " . htmlspecialchars($_GET['nom']);
```

## Exercise 2 — Reusable CSRF token generator (easy)

Write a function `genererJetonCsrf(): string` that creates (or reuses if it already exists) a token in `$_SESSION['jeton_csrf']`, and a function `verifierJetonCsrf(string $jetonRecu): bool` that compares it using `hash_equals()`. Test both functions.

## Exercise 3 — CSRF-protected form (medium)

Build a complete form with a hidden field containing the CSRF token (use your functions from exercise 2). When processing the form, verify the token and reject the request (HTTP 403) if the token is missing or incorrect. Test by submitting the form normally, then by simulating a request without the correct token (manually remove the hidden field in the HTML before submitting, via the browser's developer tools).

## Exercise 4 — Secure search (medium)

You have this dangerous code:

```php
<?php
$terme = $_GET['q'] ?? '';
$requete = "SELECT * FROM articles WHERE titre LIKE '%$terme%'";
```

Rewrite it using a prepared statement with PDO (you can simulate `$pdo` with a comment if you don't have a database set up yet — the goal is the correct syntax for a prepared statement with a `LIKE`).

## Exercise 5 — Mini-application audit (hard)

This mini-script contains **three distinct flaws** (one of each type seen in this module, assuming it also handles a login). List them all in a comment, then rewrite a complete corrected version.

```php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recherche = $_GET['recherche'];
    $requete = "SELECT * FROM produits WHERE nom LIKE '%$recherche%'";
    // ... execute $requete with $pdo->query() ...

    echo "Results for: " . $recherche;

    if ($_POST['action'] === 'supprimer_compte') {
        // account deletion, with no token verification at all
    }
}
```

---

Compare with [solutions/](solutions/) once done.
