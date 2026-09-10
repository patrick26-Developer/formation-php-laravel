<?php

declare(strict_types=1);

// --- Original unsafe version ---
// $terme = $_GET['q'] ?? '';
// $requete = "SELECT * FROM articles WHERE titre LIKE '%$terme%'";

// --- Safe version with a prepared statement ---
$terme = $_GET['q'] ?? '';

// $pdo is assumed to be an already-connected PDO instance (see module 02.8)
// We build the LIKE pattern ('%...%') BEFORE passing it as a parameter,
// never by concatenating it into the SQL text itself.
$motifRecherche = '%' . $terme . '%';

$stmt = $pdo->prepare("SELECT * FROM articles WHERE titre LIKE :motif");
$stmt->execute(['motif' => $motifRecherche]);

$resultats = $stmt->fetchAll();

// No matter what $terme contains (even quotes or SQL keywords), it is
// always treated as a plain search string, never as SQL code.
