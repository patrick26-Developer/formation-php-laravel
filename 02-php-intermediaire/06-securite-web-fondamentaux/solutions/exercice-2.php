<?php

declare(strict_types=1);

session_start();

function genererJetonCsrf(): string {
    if (!isset($_SESSION['jeton_csrf'])) {
        $_SESSION['jeton_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['jeton_csrf'];
}

function verifierJetonCsrf(string $jetonRecu): bool {
    return hash_equals($_SESSION['jeton_csrf'] ?? '', $jetonRecu);
}

$jeton = genererJetonCsrf();
echo "Jeton généré : $jeton\n";

var_dump(verifierJetonCsrf($jeton));         // true : le bon jeton
var_dump(verifierJetonCsrf("faux-jeton"));   // false : un jeton incorrect
