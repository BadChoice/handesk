<?php

namespace App\ThrustHelpers\Actions;

use BadChoice\Thrust\Actions\MainAction;

class NewUser extends MainAction
{
    public function display($resourceName, $parent_id = null)
    {
        return "<a class='button' href=".route('users.create').'> '.icon('plus').' '.__('user.newUser').'</a>';
    }
}
