<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->admin) {
            return true;
        }
    }

    public function administrate($user, $team)
    {
        return $team->pivot->admin ?? false;
    }

    public function create(User $user)
    {
        return false;
    }
}
