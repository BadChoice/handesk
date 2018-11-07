<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Team extends BaseModel
{
    use Notifiable;

    public static function findByToken($token)
    {
        return self::where('token', $token)->firstOrFail();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'memberships')->withPivot('admin');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function openTickets()
    {
        return $this->tickets()->where('status', '<', Ticket::STATUS_SOLVED);
    }

    public function solvedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_SOLVED);
    }

    public function closedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_CLOSED);
    }

    public function routeNotificationForSlack($full = false)
    {
        if ($full) {
            return $this->slack_webhook_url;
        }
        if ($this->slack_webhook_url) {
            return explode('?', $this->slack_webhook_url)[0];
        }

        return null;
    }

    public static function membersByTeam()
    {
        $usersWithoutTeam = User::has('teams', '<', 1)->pluck('name', 'id')->toArray();

        return [__('team.none') => [null => '--'] + $usersWithoutTeam] + self::all()->mapWithKeys(function ($team) {
            return [$team->name => $team->members->pluck('name', 'id')->toArray()];
        })->toArray();
    }
}
