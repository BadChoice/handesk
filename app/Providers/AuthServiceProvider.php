<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Ticket' => 'App\Policies\TicketPolicy',
        'App\Team'   => 'App\Policies\TeamPolicy',
        'App\Lead'   => 'App\Policies\LeadPolicy',
        'App\Idea'   => 'App\Policies\IdeaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see-admin', function ($user) {
            return $user->admin;
        });
    }
}
