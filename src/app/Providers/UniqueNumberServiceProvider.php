<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UniqueNumberServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path() . '/Helpers/UniqueNumber.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
