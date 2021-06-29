<?php

namespace Bryanjack\Ums;

use Bryanjack\Ums\App\Commands\UmsInstall;
use Illuminate\Support\ServiceProvider;

class UmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'ums');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/bryanjack/ums'),
        ], 'ums');

        $this->commands([
            UmsInstall::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
