<?php

use Illuminate\Support\Facades\Schedule;

// Automatise la facturation périodique — rappel du module 11.4/11.5 :
// nécessite que "php artisan schedule:run" tourne en continu (cron/Supervisor).
Schedule::command('facturation:executer')->dailyAt('03:00');
