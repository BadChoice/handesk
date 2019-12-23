<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->admin && $ability != 'delete') {
            return true;
        }
    }

    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     *
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        return  $ticket->user_id == $user->id ||
                $user->teamsTickets()->pluck('id')->contains($ticket->id) ||
                ($user->assistant && $ticket->isEscalated());
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
     * @param  \App\Ticket  $ticket
     *
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        return $ticket->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     *
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        return false;
    }

    public function assignToTeam(User $user, Ticket $ticket)
    {
    }

    public function createIssue(User $user, Ticket $ticket)
    {
        return false;
    }

    public function createIdea(User $user, Ticket $ticket)
    {
        return true;
    }
}
