<?php

declare(strict_types=1);

/*
 * Vulnerabilities identified in the original code:
 *
 * 1. SQL INJECTION: $recherche is concatenated directly into $requete
 *    ("... LIKE '%$recherche%'"), without a prepared statement.
 *
 * 2. XSS: $recherche is echoed back with "echo ... $recherche" without
 *    htmlspecialchars().
 *
 * 3. CSRF: the "supprimer_compte" action (a SENSITIVE, destructive action)
 *    is executed without any CSRF token check, which would let a
 *    malicious site trigger this deletion without the logged-in user's
 *    knowledge.
 *
 * Additional bug noticed along the way: the code reads $_GET['recherche']
 * even though the form appears to be submitted via POST (HTTP method
 * mismatch).
 */

session_start();

function verifierJetonCsrf(string $jetonRecu): bool {
    return hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifierJetonCsrf($_POST['jeton_csrf'] ?? '')) {
        http_response_code(403);
        exit("Request rejected: invalid CSRF token.");
    }

    $recherche = $_POST['recherche'] ?? ''; // consistent with the POST method

    $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE :motif");
    $stmt->execute(['motif' => '%' . $recherche . '%']);
    $resultats = $stmt->fetchAll();

    echo "Results for: " . htmlspecialchars($recherche);

    if (($_POST['action'] ?? '') === 'supprimer_compte') {
        // The CSRF token has already been checked above for ANY POST
        // request on this page, so this sensitive action is now protected.
        // ... account deletion ...
    }
}
