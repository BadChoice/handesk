<?php

namespace App\ThrustHelpers\Actions;

use BadChoice\Thrust\Actions\MainAction;

class NewLead extends MainAction
{
    public function display($resourceName, $parent_id = null)
    {
        return "<a class='button' href=".route('leads.create').'> '.icon('plus').' '.__('lead.newLead').'</a>';
    }
}
