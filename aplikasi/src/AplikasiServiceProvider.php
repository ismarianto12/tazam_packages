<?php

namespace Bryanjack\Aplikasi;

use Bryanjack\Aplikasi\App\Commands\AplikasiInstall;
use Illuminate\Support\ServiceProvider;

class AplikasiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'aplikasi');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/bryanjack/aplikasi'),
        ]);

        $this->commands([
            AplikasiInstall::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
