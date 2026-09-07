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
        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
    }

    public function boot(): void
    {
        //
    }
}
