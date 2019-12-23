<?php

namespace App;

use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string name
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $guarded = ['admin', 'assistant'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->with('requester', 'user', 'team');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class)->with('user', 'team');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'memberships')->withPivot('admin');
    }

    public function settings()
    {
        //return UserSettings::firstOrCreate(["user_id" => $this->id]);
        return $this->hasOne(UserSettings::class)->withDefault();
    }

    public function teamsTickets()
    {
        return Ticket::join('memberships', 'tickets.team_id', '=', 'memberships.team_id')
                       ->where('memberships.user_id', $this->id)->select('tickets.*');
        //return $this->belongsToMany(Ticket::class, "memberships", "team_id", "team_id");
        //return $this->hasManyThrough(Ticket::class, Membership::class,"user_id","team_id")->with('requester','user','team');
    }

    public function teamsLeads()
    {
        return Lead::join('memberships', 'leads.team_id', '=', 'memberships.team_id')
                ->where('memberships.user_id', $this->id)->select('leads.*');
    }

    public function teamsMembers()
    {
        return User::join('memberships', 'users.id', '=', 'memberships.user_id')
                     ->whereIn('memberships.team_id', $this->teams->pluck('id'))->select('users.*');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function uncompletedTasks()
    {
        return $this->hasMany(Task::class)->where('completed', false);
    }

    public function todayTasks()
    {
        return $this->hasMany(Task::class)->where('completed', false)->where('datetime', '<', Carbon::tomorrow());
    }

    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAdmins($notification)
    {
        Admin::notifyAll($notification);
    }

    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAssistants($notification)
    {
        Assistant::notifyAll($notification);
    }

    public function getTeamsTicketsAttribute()
    {
        return $this->teamsTickets()->get();
    }

    public function delete()
    {
        $this->tickets()->update(['user_id' => null]);
        $this->leads()->update(['user_id' => null]);

        return parent::delete();
    }
}
