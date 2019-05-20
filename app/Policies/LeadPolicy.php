<?php

namespace App\Policies;

use App\Lead;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->admin) {
            return true;
        }
    }

    public function index()
    {
        return true;
    }

    public function view(User $user, Lead $lead)
    {
        return  $lead->user_id == $user->id ||
            $user->teamsLeads()->pluck('id')->contains($lead->id);
    }

    public function assignToTeam(User $user, Lead $lead)
    {
        return false;
    }
}
