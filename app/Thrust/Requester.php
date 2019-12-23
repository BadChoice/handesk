<?php

namespace App\Thrust;

use BadChoice\Thrust\Fields\Email;
use BadChoice\Thrust\Fields\Gravatar;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Resource;

class Requester extends Resource
{
    public static $model        = \App\Requester::class;
    public static $search       = ['name', 'email'];
    public static $defaultSort  = 'tickets_count';
    public static $defaultOrder = 'DESC';

    public function fields()
    {
        return [
            Gravatar::make('email')->sortable(),
            Text::make('name')->sortable(),
            Email::make('email')->sortable(),
            Text::make('tickets_count')->sortable(),
            Link::make('id')->icon('inbox')->link(url('tickets?requester_id={field}'))->onlyInIndex(),
        ];
    }

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->withCount('tickets');
    }

    public function canDelete($object)
    {
        return false;
    }
}
