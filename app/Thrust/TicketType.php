<?php

namespace App\Thrust;

use BadChoice\Thrust\Fields\Color;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Resource;

class TicketType extends Resource
{
    public static $model  = \App\TicketType::class;
    public static $search = ['name'];

    public function fields()
    {
        return [
            Text::make('name'),
            Color::make('color'),
            Text::make('tickets_count')->onlyInIndex(),
        ];
    }

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->withCount('tickets');
    }
}
