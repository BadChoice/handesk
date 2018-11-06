<?php

namespace App\Thrust;

use App\Repositories\TicketsIndexQuery;
use App\ThrustHelpers\Actions\ChangePriority;
use App\ThrustHelpers\Actions\ChangeStatus;
use App\ThrustHelpers\Actions\MergeTickets;
use App\ThrustHelpers\Actions\NewTicket;
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
            Link::make('title' , __('ticket.subject'))->displayCallback(function($ticket){
                return "#{$ticket->id} · ". str_limit($ticket->title, 25);
            })->route('tickets.show')->sortable(),
            Link::make('requester.id', trans_choice('ticket.requester', 1))->displayCallback(function($ticket){
                return $ticket->requester->name ?? "--";
            })->link('tickets?requester_id={field}'),
            Link::make('team.id', __('ticket.team'))->displayCallback(function($ticket){
                return $ticket->team->name ?? "--";
            })->link('tickets?team_id={field}'),
            BelongsTo::make('user', __('ticket.assigned'))->allowNull(),
            Link::make('user.id', trans_choice('ticket.user', 1))->displayCallback(function($ticket){
                return $ticket->user->name ?? "--";
            })->link('tickets?user_id={field}'),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
        ];
    }

    protected function getBaseQuery()
    {
        return TicketsIndexQuery::get()->with($this->getWithFields())->latest('updated_at');
    }

    public function update($id, $newData)
    {
        return parent::update($id, array_except($newData, ['created_at', 'updated_at']));
    }

    public function mainActions()
    {
        return [
            new NewTicket,
        ];
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