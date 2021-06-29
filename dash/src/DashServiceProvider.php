<?php

namespace Bryanjack\Dash;

use Bryanjack\Dash\App\Commands\DashAdmin;
use Bryanjack\Dash\App\Commands\DashInstall;
use Bryanjack\Dash\App\Events\UserRegisteredEvent;
use Bryanjack\Dash\App\Mail\EmailVerification;
use Bryanjack\Dash\App\Providers\DashEventServiceProvider;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class DashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'dash');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/bryanjack/dash'),
        ], 'dash');
        // $this->publishes([
        //     __DIR__ . '/views/auth' => resource_path('views/auth'),
        // ], 'dash');
        // $this->publishes([
        //     __DIR__ . '/views/auth-layouts' => resource_path('views/layouts'),
        // ], 'dash');

        // Replace following files
        $this->publishes([
            __DIR__ . '/replacor/.gitignore' => base_path('.gitignore'),
        ], 'dash');
        $this->publishes([
            __DIR__ . '/replacor/AuthServiceProvider.php' => base_path('app/Providers/AuthServiceProvider.php'),
        ], 'dash');
        $this->publishes([
            __DIR__ . '/replacor/User.php' => base_path('app/Models/User.php'),
        ], 'dash');
        $this->publishes([
            __DIR__ . '/replacor/web.php' => base_path('routes/web.php'),
        ], 'dash');

        // Override the email notification for verifying email
        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
            event(new UserRegisteredEvent($notifiable, $verifyUrl));
            return new EmailVerification($verifyUrl, $notifiable);
        });

        // Registering commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                DashInstall::class,
                DashAdmin::class,
            ]);
        }
    }

    public function register()
    {
        //include helper
        $helper = __DIR__ . '/App/helper.php';
        if (file_exists($helper)) {
            require_once($helper);
        }
        // Register Event Provider
        $this->app->register(DashEventServiceProvider::class);
    }
}
