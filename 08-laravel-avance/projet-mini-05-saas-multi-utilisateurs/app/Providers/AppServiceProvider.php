<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\RapportGenerator;
use App\Services\RapportHebdomadaireGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RapportGenerator::class, RapportHebdomadaireGenerator::class);
    }

    public function boot(): void
    {
        //
    }
}
