<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\RegisteredEvent' => [
            'App\Listeners\RegisteredListener',
        ],
        'App\Events\Admin\IdAcceptedEvent' => [
            'App\Listeners\Admin\Warnings\CheckAcceptedIdListener',
        ],
        'App\Events\TicketAddedEvent' => [
            'App\Listeners\Admin\Warnings\CheckManyTicketsAddedListener',
            'App\Listeners\Admin\Checks\CheckPriceTicketAddedListener',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
