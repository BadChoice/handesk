<?php

namespace App\ThrustHelpers\Actions;

use BadChoice\Thrust\Actions\MainAction;

class NewTicket extends MainAction
{
    public function display($resourceName, $parent_id = null)
    {
        return "<a class='button' href=".route('tickets.create').'> '.icon('plus').' '.__('ticket.newTicket').'</a>';
    }
}
