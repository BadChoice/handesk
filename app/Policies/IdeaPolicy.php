<?php

namespace App\Policies;

use App\Idea;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Idea  $idea
     *
     * @return mixed
     */
    public function view(User $user, Idea $idea)
    {
    }

    /**
     * Determine whether the user can create tickets.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Idea  $idea
     *
     * @return mixed
     */
    public function update(User $user, Idea $idea)
    {
        return false;
    }

    public function createIssue(User $user, Idea $idea)
    {
        return false;
    }
}
