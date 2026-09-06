<?php

declare(strict_types=1);

// --- Version dangereuse d'origine ---
// $terme = $_GET['q'] ?? '';
// $requete = "SELECT * FROM articles WHERE titre LIKE '%$terme%'";

// --- Version sécurisée avec requête préparée ---
$terme = $_GET['q'] ?? '';

// $pdo est supposé être une instance PDO déjà connectée (voir module 02.8)
// On construit le motif LIKE ('%...%') AVANT de le passer en paramètre,
// jamais en le concaténant dans le texte SQL lui-même.
$motifRecherche = '%' . $terme . '%';

$stmt = $pdo->prepare("SELECT * FROM articles WHERE titre LIKE :motif");
$stmt->execute(['motif' => $motifRecherche]);

$resultats = $stmt->fetchAll();

// Peu importe ce que contient $terme (même des apostrophes ou des mots-clés
// SQL), il est toujours traité comme une simple chaîne de recherche,
// jamais comme du code SQL.
