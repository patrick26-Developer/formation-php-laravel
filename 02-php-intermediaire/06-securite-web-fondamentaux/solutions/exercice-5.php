<?php

declare(strict_types=1);

/*
 * Failles identifiées dans le code original :
 *
 * 1. INJECTION SQL : $recherche est concaténé directement dans $requete
 *    ("... LIKE '%$recherche%'"), sans requête préparée.
 *
 * 2. XSS : $recherche est réaffiché avec "echo ... $recherche" sans
 *    htmlspecialchars().
 *
 * 3. CSRF : l'action "supprimer_compte" (une action SENSIBLE et destructrice)
 *    est exécutée sans aucune vérification de jeton CSRF, ce qui permettrait
 *    à un site malveillant de déclencher cette suppression à l'insu de
 *    l'utilisateur connecté.
 *
 * Bug additionnel remarqué au passage : le code lit $_GET['recherche'] alors
 * que le formulaire semble être soumis en POST (incohérence de méthode HTTP).
 */

session_start();

function verifierJetonCsrf(string $jetonRecu): bool {
    return hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifierJetonCsrf($_POST['jeton_csrf'] ?? '')) {
        http_response_code(403);
        exit("Requête refusée : jeton CSRF invalide.");
    }

    $recherche = $_POST['recherche'] ?? ''; // cohérent avec la méthode POST

    $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE :motif");
    $stmt->execute(['motif' => '%' . $recherche . '%']);
    $resultats = $stmt->fetchAll();

    echo "Résultats pour : " . htmlspecialchars($recherche);

    if (($_POST['action'] ?? '') === 'supprimer_compte') {
        // Le jeton CSRF a déjà été vérifié plus haut pour TOUTE requête POST
        // de cette page, donc cette action sensible est maintenant protégée.
        // ... suppression du compte ...
    }
}
