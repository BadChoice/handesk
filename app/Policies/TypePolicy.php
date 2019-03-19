<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create types.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the type.
     *
     * @param  \App\User  $user
     * @param  \App\Type  $type
     *
     * @return mixed
     */
    public function update(User $user, Type $type)
    {
        return true;
    }
}
