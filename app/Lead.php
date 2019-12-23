<?php

namespace App;

use App\Notifications\LeadAssigned;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends BaseModel
{
    use SoftDeletes, Taggable, Assignable, Subscribable;

    const STATUS_NEW           = 1;
    const STATUS_FIRST_CONTACT = 2;
    const STATUS_VISITED       = 3;
    const STATUS_COMPLETED     = 4;
    const STATUS_FAILED        = 5;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function uncompletedTasks()
    {
        return $this->tasks()->whereCompleted(false);
    }

    public function statusUpdates()
    {
        return $this->hasMany(LeadStatusUpdate::class)->latest();
    }

    public function updateStatus($user, $body, $status)
    {
        if (! $this->user) {
            $this->update(['status' => $status, 'updated_at' => Carbon::now(), 'user_id' => $user->id]);
        } else {
            $this->update(['status' => $status, 'updated_at' => Carbon::now()]);
        }

        return $this->statusUpdates()->create(['user_id' => $user->id, 'new_status' => $status, 'body' => $body]);
    }

    public static function availableStatus()
    {
        return [
            static::STATUS_NEW           => 'new',
            static::STATUS_FIRST_CONTACT => 'first-contact',
            static::STATUS_VISITED       => 'visited',
            static::STATUS_COMPLETED     => 'completed',
            static::STATUS_FAILED        => 'failed',
        ];
    }

    public function statusName()
    {
        return static::getStatusText($this->status);
    }

    public static function getStatusText($status)
    {
        return static::availableStatus()[$status];
    }

    protected function getAssignedNotification()
    {
        return new LeadAssigned($this);
    }

    public function getSubscribableEmail()
    {
        return $this->email;
    }

    public function getSubscribableName()
    {
        return $this->name;
    }
}
