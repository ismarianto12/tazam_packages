<?php

namespace Bryanjack\Parameter;

use Bryanjack\Parameter\App\Commands\ParameterInstall;
use Illuminate\Support\ServiceProvider;

class ParameterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'Parameter');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/bryanjack/Parameter'),
        ]);

        $this->commands([
            ParameterInstall::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
