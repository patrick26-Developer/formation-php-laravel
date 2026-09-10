<?php

declare(strict_types=1);

require_once __DIR__ . "/../Routeur.en.php";
require_once __DIR__ . "/../AccueilController.en.php";

$routeur = new Routeur();
$controller = new AccueilController();

$routeur->get('/', [$controller, 'index']);

$routeur->distribuer($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

/*
 * Run it: from the "exercice-4" folder, execute:
 *   php -S localhost:8000 public/index.php
 *
 * The filename after the port tells PHP to redirect ALL requests to this
 * script, even for paths that don't match any real file on disk (for
 * example /taches/42) — exactly the behavior of a front controller in
 * production (handled there by the web server configuration,
 * Apache/Nginx, rather than this testing flag).
 */
