<?php

declare(strict_types=1);

function estPair(int $nombre): bool {
    return $nombre % 2 === 0;
}

var_dump(estPair(4));  // true
var_dump(estPair(7));  // false
var_dump(estPair(0));  // true
