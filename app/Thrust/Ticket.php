<?php

namespace App\Thrust;

use App\Repositories\TicketsIndexQuery;
use App\ThrustHelpers\Actions\ChangePriority;
use App\ThrustHelpers\Actions\ChangeStatus;
use App\ThrustHelpers\Actions\MergeTickets;
use App\ThrustHelpers\Fields\TicketStatusField;
use App\ThrustHelpers\Filters\EscalatedFilter;
use App\ThrustHelpers\Filters\PriorityFilter;
use App\ThrustHelpers\Filters\StatusFilter;
use BadChoice\Thrust\Fields\BelongsTo;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Resource;

class Ticket extends Resource
{
    public static $model = \App\Ticket::class;
    public static $search = ['title', 'body'];

    public function fields()
    {
        return [
            TicketStatusField::make('id' ,''),
            Link::make('title')->displayCallback(function($ticket){
                return "#{$ticket->id} · ". str_limit($ticket->title, 25);
            })->route('tickets.show')->sortable(),
            BelongsTo::make('requester'),
            BelongsTo::make('team')->allowNull(),
            BelongsTo::make('user')->allowNull(),
            Date::make('created_at')->showInTimeAgo()->sortable(),
            Date::make('updated_at')->showInTimeAgo()->sortable(),
        ];
    }

    protected function getBaseQuery()
    {
        return TicketsIndexQuery::get()->with($this->getWithFields())->latest('updated_at');
    }


    public function actions()
    {
        return [
            new MergeTickets,
            new ChangeStatus,
            new ChangePriority,
        ];
    }

    public function filters()
    {
        return [
            new StatusFilter,
            new PriorityFilter,
            new EscalatedFilter,
        ];
    }


}