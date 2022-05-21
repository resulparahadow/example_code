<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\PYGG\MPIPaymentFailed::class => [
            \App\Listeners\Notifications\PYGG\MPIPaymentFailedNotificationSend::class,
        ],

        \App\Events\PYGG\MPIPaymentSucceed::class => [
            \App\Listeners\Notifications\PYGG\MPIPaymentSucceedNotificationSend::class,
        ],

        \App\Events\PYGG\PYGGPaymentSucceed::class => [
            \App\Listeners\Notifications\PYGG\PYGGFinePayedNotificationSend::class,
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
