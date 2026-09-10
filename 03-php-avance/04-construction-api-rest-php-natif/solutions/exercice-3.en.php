<?php

declare(strict_types=1);

require_once __DIR__ . "/helpers.en.php";

function listerTaches(array $taches): array {
    // array_values(): an empty list is a VALID result, we always
    // respond 200, never an error, even when $taches is empty.
    return array_values($taches);
}

$tachesVides = [];
repondreJson(listerTaches($tachesVides), 200); // {"..."} -> [] with code 200

// (To test with data: populate $tachesVides before the call.)
