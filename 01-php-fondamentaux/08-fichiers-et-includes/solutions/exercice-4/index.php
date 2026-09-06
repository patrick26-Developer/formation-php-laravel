<?php

// --- Version fautive (à tester d'abord pour observer l'erreur) ---
// require __DIR__ . "/outils.php";
// require __DIR__ . "/outils.php";
// Erreur obtenue : "Fatal error: Cannot redeclare direBonjour()..."
// Car require inclut littéralement le fichier une seconde fois, qui tente
// de redéfinir une fonction déjà existante — PHP ne l'autorise pas.

// --- Version corrigée ---
require_once __DIR__ . "/outils.php";
require_once __DIR__ . "/outils.php"; // ignoré silencieusement, déjà inclus

echo direBonjour();
