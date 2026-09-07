<?php

use Illuminate\Support\Facades\Schedule;

// Planifie l'analyse automatique des logs chaque nuit à 2h — nécessite
// que le scheduler Laravel soit lui-même déclenché (cron système appelant
// "php artisan schedule:run" chaque minute, ou un conteneur dédié).
Schedule::command('logs:analyser')->dailyAt('02:00');
