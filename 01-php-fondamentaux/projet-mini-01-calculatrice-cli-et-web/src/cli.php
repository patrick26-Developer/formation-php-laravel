<?php

declare(strict_types=1);

require_once __DIR__ . "/Calculatrice.php";

/**
 * Usage : php src/cli.php <nombre1> <operation> <nombre2>
 * Exemple : php src/cli.php 10 + 5
 */

// $argv[0] est toujours le nom du script ; les vrais arguments commencent à $argv[1]
if (count($argv) !== 4) {
    fwrite(STDERR, "Usage : php cli.php <nombre1> <operation> <nombre2>\n");
    fwrite(STDERR, "Exemple : php cli.php 10 + 5\n");
    exit(1); // code de sortie non-zéro : signale une erreur au terminal/script appelant
}

[, $nombre1Brut, $operation, $nombre2Brut] = $argv;

if (!is_numeric($nombre1Brut) || !is_numeric($nombre2Brut)) {
    fwrite(STDERR, "Les deux nombres doivent être numériques.\n");
    exit(1);
}

try {
    $resultat = calculer((float) $nombre1Brut, $operation, (float) $nombre2Brut);
    echo "$nombre1Brut $operation $nombre2Brut = $resultat\n";
} catch (InvalidArgumentException $e) {
    fwrite(STDERR, "Erreur : " . $e->getMessage() . "\n");
    exit(1);
}
