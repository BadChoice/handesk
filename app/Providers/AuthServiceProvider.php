<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Ticket::class => \App\Policies\TicketPolicy::class,
        \App\Team::class   => \App\Policies\TeamPolicy::class,
        \App\Lead::class   => \App\Policies\LeadPolicy::class,
        \App\Idea::class   => \App\Policies\IdeaPolicy::class,
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
