<?php

namespace App\Providers;

use App\Events\SendTempPassword;
use App\Listeners\SendNotificationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendTempPassword::class => [
            SendNotificationEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
