<?php

namespace App\Providers;

use Dotenv\Dotenv;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env('APP_ENV') === 'production') {
             Dotenv::createImmutable(base_path(), '.env.prod')->load();
            }
        else {
             Dotenv::createImmutable(base_path(), '.env.dev')->load();
            }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
