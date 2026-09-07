<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Services\FakePaymentGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Un seul endroit à modifier pour brancher une vraie passerelle
        // (Stripe, PayPal...) en production (module 08.4).
        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('acceder-admin', fn ($user) => $user->est_admin);
    }
}
