<?php

namespace Bryanjack\Dash\App\Providers;

use Bryanjack\Dash\App\Events\UserRegisteredEvent;
use Bryanjack\Dash\App\Listeners\MailVerifyListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DashEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegisteredEvent::class => [
            MailVerifyListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
