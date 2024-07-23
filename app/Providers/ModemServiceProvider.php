<?php

namespace App\Providers;

use App\Http\Services\Message\GSMConnection;
use Illuminate\Support\ServiceProvider;

class ModemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GSMConnection::class, function ($app) {
            return GSMConnection::getGSMConnectionInstance();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
