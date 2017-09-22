<?php

namespace App;

trait Assignable
{
    public function assignTo($user)
    {
        if (! $user instanceof User) {
            $user = User::findOrFail($user);
        }
        if ($this->user && $this->user->id == $user->id) {
            return;
        }
        $this->user()->associate($user)->save();
        $user->notify($this->getAssignedNotification());
        TicketEvent::make($this, "Assigned to agent: {$user->name}");
    }

    public function assignToTeam($team)
    {
        if (! $team instanceof Team) {
            $team = Team::findOrFail($team);
        }
        if ($this->team && $this->team->id == $team->id) {
            return;
        }
        $this->team()->associate($team)->save();
        $team->notify($this->getAssignedNotification());
        TicketEvent::make($this, "Assigned to team: {$team->name}");
    }
}
