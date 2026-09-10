<?php

// --- Original (buggy) code, for reference ---
// $Prix = 15.50
// $quantite = "3"
//
// $total = $prix * $quantite
// echo 'Le total est : $total euros'

// --- Corrected version ---

// Bug 1: missing semicolon at the end of every statement.
$prix = 15.50; // Bug 2: "$Prix" (capital) then "$prix" (lowercase) used
               // as if they were the same variable — PHP is case-sensitive,
               // these are two different variables. We standardize on "$prix".
$quantite = 3;  // Bug 3: the quantity was a string "3" rather than an integer 3.
                // This wouldn't have caused an error here (PHP would have
                // converted it automatically for the multiplication), but
                // it's not the correct semantic type for a quantity.

$total = $prix * $quantite;

// Bug 4: single quotes ('...') don't interpolate variables.
// The displayed text would have been literally "Le total est : $total euros".
// You need either double quotes, or concatenation with the dot operator.
echo "The total is: $total euros";
