<?php

$plat = "entree";

// --- Version AVEC le bug volontaire (break manquant sur "entree") ---
// switch ($plat) {
//     case "entree":
//         echo "5€";
//         // pas de break ici : l'exécution "tombe" dans le case suivant
//     case "plat":
//         echo "12€";
//         break;
//     case "dessert":
//         echo "4€";
//         break;
//     default:
//         echo "plat inconnu";
// }
// Résultat observé avec $plat = "entree" : affiche "5€12€" au lieu de "5€" seul,
// car sans break, PHP continue d'exécuter le case suivant.

// --- Version corrigée ---
switch ($plat) {
    case "entree":
        echo "5€";
        break;
    case "plat":
        echo "12€";
        break;
    case "dessert":
        echo "4€";
        break;
    default:
        echo "plat inconnu";
        break;
}
