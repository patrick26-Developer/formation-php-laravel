<?php

// --- Buggy version (test this first to observe the error) ---
// require __DIR__ . "/outils.en.php";
// require __DIR__ . "/outils.en.php";
// Error obtained: "Fatal error: Cannot redeclare direBonjour()..."
// Because require literally includes the file a second time, which tries
// to redefine a function that already exists — PHP doesn't allow this.

// --- Corrected version ---
require_once __DIR__ . "/outils.en.php";
require_once __DIR__ . "/outils.en.php"; // silently ignored, already included

echo direBonjour();
