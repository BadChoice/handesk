<?php

namespace App\Thrust;

use BadChoice\Thrust\Resource;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Email;
use App\ThrustHelpers\Actions\NewUser;

class Agent extends Resource
{
    public static $model        = \App\Users::class;
    public static $search       = ['name', 'email'];
    public static $defaultSort  = 'updated_at';
    public static $defaultOrder = 'desc';

    public function fields()
    {
        return [
            Link::make('name', __('user.name'))->displayCallback(function ($user) {
                return $user->name ?? '--';
            }),
            Email::make('email', __('user.email'))->sortable(),
            Date::make('created_at', __('ticket.requested'))->showInTimeAgo()->sortable(),
            Date::make('updated_at', __('ticket.updated'))->showInTimeAgo()->sortable(),
            
        ];
    }

    protected function getBaseQuery()
    {   
        return \App\User::with($this->getWithFields());
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
