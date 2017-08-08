<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function administrate($user, $team){
        return $user->admin || $team->pivot->admin;
    }
}
