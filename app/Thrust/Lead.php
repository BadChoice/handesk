<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\NewLead;
use App\ThrustHelpers\Fields\Status;
use App\ThrustHelpers\Fields\Tasks;
use App\ThrustHelpers\Filters\LeadStatusFilter;
use BadChoice\Thrust\Fields\BelongsTo;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Email;
use BadChoice\Thrust\Fields\HasMany;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Resource;

class Lead extends Resource
{
    public static $model = \App\Lead::class;
    public static $search = ['name', 'company', 'email', 'body', 'address', 'city', 'country', 'phone'];

    public function fields()
    {
        return [
            Link::make('id', __('lead.company'))->link('/leads/{field}')->displayCallback(function($lead){
                return $lead->company;
            }),
            Link::make('id', __('lead.name'))->link('/leads/{field}')->displayCallback(function($lead){
                return $lead->name;
            }),
            Email::make('email')->sortable(),
            HasMany::make('tags'),
            BelongsTo::make('team'),
            BelongsTo::make('user'),
            Status::make('status')->sortable(),
            Tasks::make('tasks', trans_choice('lead.task', 2)),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
        ];
    }

    public function filters()
    {
        return [
            new LeadStatusFilter,
        ];
    }

    public function mainActions()
    {
        return [
            new NewLead,
        ];
    }

    public function actions()
    {
        return [];
    }


}