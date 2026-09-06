<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Limite générale pour les routes authentifiées (module 09.6)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Limite stricte dédiée à la connexion, contre le brute-force
        RateLimiter::for('connexion', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Limite plus permissive pour la lecture publique (pas d'authentification requise)
        RateLimiter::for('lecture-publique', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });
    }
}
