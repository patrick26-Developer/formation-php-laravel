<?php

declare(strict_types=1);

require_once __DIR__ . "/../Routeur.php";
require_once __DIR__ . "/../AccueilController.php";

$routeur = new Routeur();
$controller = new AccueilController();

$routeur->get('/', [$controller, 'index']);

$routeur->distribuer($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

/*
 * Lancement : depuis le dossier "exercice-4", exécutez :
 *   php -S localhost:8000 public/index.php
 *
 * Le nom de fichier après le port indique à PHP de rediriger TOUTES les
 * requêtes vers ce script, même pour des chemins qui ne correspondent à
 * aucun fichier réel sur le disque (par exemple /taches/42) — exactement
 * le comportement d'un front controller en production (géré alors par la
 * configuration du serveur web, Apache/Nginx, plutôt que ce flag de test).
 */
