<?php

namespace App\Thrust;

use BadChoice\Thrust\Resource;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Link;
use App\ThrustHelpers\Fields\Rating;
use BadChoice\Thrust\Fields\Gravatar;
use App\Repositories\TicketsIndexQuery;
use App\ThrustHelpers\Actions\NewTicket;
use App\ThrustHelpers\Actions\ChangeStatus;
use App\ThrustHelpers\Actions\MergeTickets;
use App\ThrustHelpers\Filters\StatusFilter;
use App\ThrustHelpers\Actions\ChangePriority;
use App\ThrustHelpers\Filters\PriorityFilter;
use App\ThrustHelpers\Filters\EscalatedFilter;
use App\ThrustHelpers\Fields\TicketStatusField;
use App\ThrustHelpers\Filters\TicketTypeFilter;

class Ticket extends Resource
{
    public static $model        = \App\Ticket::class;
    public static $search       = ['title', 'body'];
    public static $defaultSort  = 'updated_at';
    public static $defaultOrder = 'desc';

    public function fields()
    {
        return [
            //Gravatar::make('requester.email')->withDefault('https://raw.githubusercontent.com/BadChoice/handesk/master/public/images/default-avatar.png'),
            TicketStatusField::make('id', ''),
            Link::make('title', __('ticket.subject'))->displayCallback(function ($ticket) {
                return "#{$ticket->id} · ".str_limit($ticket->title, 25);
            })->route('tickets.show')->sortable(),
            Link::make('requester.id', trans_choice('ticket.requester', 1))->displayCallback(function ($ticket) {
                return $ticket->requester->name ?? '--';
            })->link('tickets?requester_id={field}'),
            Link::make('team.id', __('ticket.team'))->displayCallback(function ($ticket) {
                return $ticket->team->name ?? '--';
            })->link('tickets?team_id={field}'),
            Link::make('user.id', trans_choice('ticket.user', 1))->displayCallback(function ($ticket) {
                return $ticket->user->name ?? '--';
            })->link('tickets?user_id={field}'),
            Rating::make('rating', ''),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
        ];
    }

    protected function getBaseQuery()
    {
        return TicketsIndexQuery::get()->with($this->getWithFields());
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
            new TicketTypeFilter,
        ];
    }

    public function canDelete($object)
    {
        return false;
    }

    public function canEdit($object)
    {
        return false;
    }
}
