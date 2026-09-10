<?php

$saisieUtilisateur = "42.5abc";

echo "Original type: " . gettype($saisieUtilisateur) . "\n"; // string

$versEntier = (int) $saisieUtilisateur;
echo "Converted to int: $versEntier\n"; // 42

$versFlottant = (float) $saisieUtilisateur;
echo "Converted to float: $versFlottant\n"; // 42.5

/*
 * Explanation:
 * PHP converts a string to a number by reading its characters from the
 * start until it hits a character that can no longer be part of the number.
 *
 * - (int) "42.5abc": PHP reads "42" as an integer, stops at the first
 *   character invalid for an int (the decimal point), so the result is 42.
 * - (float) "42.5abc": PHP reads "42.5" as a valid float, stops at "abc"
 *   which is neither a digit nor a dot, so the result is 42.5.
 *
 * In both cases, the non-numeric part "abc" is simply ignored, with no
 * error thrown — a classic trap if you don't validate user input before
 * converting it (see module 01.9 on error handling).
 */
