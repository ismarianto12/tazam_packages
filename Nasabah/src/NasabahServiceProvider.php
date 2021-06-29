<?php

namespace Bryanjack\Nasabah;

use Bryanjack\Nasabah\App\Commands\NasabahInstall;
use Illuminate\Support\ServiceProvider;

class NasabahServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'nasabah');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/bryanjack/nasabah'),
        ]);

        $this->commands([
            NasabahInstall::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
