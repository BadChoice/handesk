<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\NewUser;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Email;
use BadChoice\Thrust\Fields\HasMany;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Resource;

class Agent extends Resource
{
    public static $model        = \App\User::class;
    public static $search       = ['name', 'email'];
    public static $defaultSort  = 'updated_at';
    public static $defaultOrder = 'desc';

    public function fields()
    {
        return [
            Text::make('name', __('user.name'))->sortable(),
            Email::make('email', __('user.email'))->sortable(),
            HasMany::make('teams'),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
        ];
    }

    public function mainActions()
    {
        return [
            new NewUser,
        ];
    }

    public function actions()
    {
        return [];
    }
}
