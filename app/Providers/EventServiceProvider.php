<?php

namespace App\Providers;

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
        'App\Events\TicketCreated' => [
            'App\Listeners\UpdateTicketCreationKpis',
        ],
        'App\Events\TicketCommented' => [
            'App\Listeners\UpdateReplyKpis',
        ],
        'App\Events\TicketStatusUpdated' => [
            'App\Listeners\UpdateStatusKpis',
        ],
        'App\Events\TicketRated' => [
            'App\Listeners\UpdateRatedKpi',
        ],
        'App\Events\ApiNotificationEvent' => [
            'App\Listeners\SendApiNotificaton',
        ],
        'App\Events\TicketNotificationEvent' => [
            'App\Listeners\SendNotificationTicket',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
                // add your listeners (aka providers) here
                'SocialiteProviders\\Azure\\AzureExtendSocialite@handle',
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
