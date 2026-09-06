<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo $inexistante;
// Avec error_reporting(E_ALL) : affiche un Warning "Undefined variable $inexistante"
// (le script continue quand même, la variable est traitée comme null).

// En commentant error_reporting(E_ALL) et ini_set(...), PHP utilise sa
// configuration par défaut (php.ini), qui peut masquer ce warning selon
// l'environnement — d'où l'importance de forcer E_ALL en développement pour
// ne jamais passer à côté d'un bug silencieux.
