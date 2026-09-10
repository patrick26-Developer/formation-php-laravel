<?php

$plat = "entree";

// --- Version WITH the deliberate bug (missing break on "entree") ---
// switch ($plat) {
//     case "entree":
//         echo "€5";
//         // no break here: execution "falls through" into the next case
//     case "plat":
//         echo "€12";
//         break;
//     case "dessert":
//         echo "€4";
//         break;
//     default:
//         echo "unknown dish";
// }
// Observed result with $plat = "entree": prints "€5€12" instead of just "€5",
// because without break, PHP keeps executing the next case.

// --- Corrected version ---
switch ($plat) {
    case "entree":
        echo "€5";
        break;
    case "plat":
        echo "€12";
        break;
    case "dessert":
        echo "€4";
        break;
    default:
        echo "unknown dish";
        break;
}
