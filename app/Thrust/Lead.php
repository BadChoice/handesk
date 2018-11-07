<?php

namespace App\Thrust;

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
            Text::make('status')->sortable(),
            HasMany::make('tasks', trans_choice('lead.task', 2)),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
        ];
    }

    public function filters()
    {
        return [];
    }

    public function mainActions()
    {
        return [

        ];
    }

    public function actions()
    {
        return [];
    }


}