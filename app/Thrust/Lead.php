<?php

namespace App\Thrust;

use BadChoice\Thrust\Resource;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Email;
use App\ThrustHelpers\Fields\Tasks;
use App\ThrustHelpers\Fields\Status;
use BadChoice\Thrust\Fields\HasMany;
use App\Repositories\LeadsIndexQuery;
use BadChoice\Thrust\Fields\Gravatar;
use App\ThrustHelpers\Actions\NewLead;
use BadChoice\Thrust\Fields\BelongsTo;
use App\ThrustHelpers\Filters\LeadStatusFilter;

class Lead extends Resource
{
    public static $model        = \App\Lead::class;
    public static $search       = ['name', 'company', 'email', 'body', 'address', 'city', 'country', 'phone', 'tags.name'];
    public static $defaultSort  = 'updated_at';
    public static $defaultOrder = 'desc';

    public function fields()
    {
        return [
            Gravatar::make('email', '')->withDefault('https://raw.githubusercontent.com/BadChoice/handesk/master/public/images/default-avatar.png'),
            Link::make('id', __('lead.company'))->link('/leads/{field}')->displayCallback(function ($lead) {
                return $lead->company;
            }),
            Link::make('id', __('lead.name'))->link('/leads/{field}')->displayCallback(function ($lead) {
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

    protected function getBaseQuery()
    {
        return LeadsIndexQuery::get()->with($this->getWithFields());
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
