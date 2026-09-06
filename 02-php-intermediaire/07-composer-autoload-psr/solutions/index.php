<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php'; // seul require nécessaire pour tout le projet

use App\Saluer;
use App\Services\Calculatrice;

$saluer = new Saluer();
echo $saluer->bonjour("Alice") . "\n"; // Bonjour, Alice !

$calculatrice = new Calculatrice();
echo $calculatrice->additionner(4, 5) . "\n"; // 9

// --- Exercice 4 (nécessite : composer require nesbot/carbon) ---
// use Carbon\Carbon;
// Carbon::setLocale('fr');
// echo Carbon::now()->isoFormat('dddd D MMMM YYYY') . "\n"; // ex : mardi 6 janvier 2026

/*
 * Exercice 5 — pourquoi composer.lock est important :
 * composer.json exprime des contraintes de version SOUPLES (ex: "^2.0" =
 * n'importe quelle version 2.x). Sans composer.lock, deux développeurs qui
 * lancent "composer install" à des dates différentes pourraient obtenir des
 * versions différentes d'une même dépendance (une 2.1 puis une 2.3 sortie
 * entre-temps), avec un risque de comportement différent voire de bug.
 * composer.lock fige les versions EXACTES installées la première fois :
 * "composer install" les réinstalle à l'identique pour tout le monde,
 * garantissant un environnement reproductible dans toute l'équipe.
 * Seul "composer update" recalcule de nouvelles versions et met à jour le lock.
 */
