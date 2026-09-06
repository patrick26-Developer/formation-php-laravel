<?php

$saisieUtilisateur = "42.5abc";

echo "Type d'origine : " . gettype($saisieUtilisateur) . "\n"; // string

$versEntier = (int) $saisieUtilisateur;
echo "Conversion en int : $versEntier\n"; // 42

$versFlottant = (float) $saisieUtilisateur;
echo "Conversion en float : $versFlottant\n"; // 42.5

/*
 * Explication :
 * PHP convertit une chaîne en nombre en lisant les caractères depuis le début
 * jusqu'à ce qu'il rencontre un caractère qui ne peut plus faire partie du nombre.
 *
 * - (int) "42.5abc" : PHP lit "42" comme entier, s'arrête au premier caractère
 *   invalide pour un int (le point décimal), donc le résultat est 42.
 * - (float) "42.5abc" : PHP lit "42.5" comme flottant valide, s'arrête à "abc"
 *   qui n'est pas un chiffre ni un point, donc le résultat est 42.5.
 *
 * Dans les deux cas, la partie non numérique "abc" est simplement ignorée,
 * sans erreur levée — un piège classique si on ne valide pas les entrées
 * utilisateur avant de les convertir (voir module 01.9 sur la gestion d'erreurs).
 */
