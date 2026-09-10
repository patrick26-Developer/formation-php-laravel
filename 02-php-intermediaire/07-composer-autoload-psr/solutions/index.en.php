<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php'; // the only require needed for the whole project

use App\Saluer;
use App\Services\Calculatrice;

$saluer = new Saluer();
echo $saluer->bonjour("Alice") . "\n"; // Hello, Alice!

$calculatrice = new Calculatrice();
echo $calculatrice->additionner(4, 5) . "\n"; // 9

// --- Exercise 4 (requires: composer require nesbot/carbon) ---
// use Carbon\Carbon;
// Carbon::setLocale('en');
// echo Carbon::now()->isoFormat('dddd D MMMM YYYY') . "\n"; // e.g.: Tuesday 6 January 2026

/*
 * Exercise 5 — why composer.lock matters:
 * composer.json expresses LOOSE version constraints (e.g. "^2.0" = any
 * 2.x version). Without composer.lock, two developers running
 * "composer install" on different dates could get different versions of
 * the same dependency (a 2.1, then a 2.3 released in between), with a risk
 * of different behavior or even a bug.
 * composer.lock freezes the EXACT versions installed the first time:
 * "composer install" reinstalls them identically for everyone,
 * guaranteeing a reproducible environment across the whole team.
 * Only "composer update" recalculates new versions and updates the lock file.
 */
