<?php

namespace App;

use App\Authenticatable\Admin;
use App\Notifications\IdeaCreated;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends BaseModel
{
    use SoftDeletes, Taggable, Subscribable;

    const STATUS_NEW      = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_OPEN     = 3;
    const STATUS_RESOLVED = 4;
    const STATUS_CLOSED   = 5;
    const STATUS_DECLINED = 6;
    const STATUS_MERGED   = 7;

    public static function createAndNotify($requester, $title, $body, $repository, $tags)
    {
        $requester = Requester::findOrCreate($requester['name'], $requester['email'] ?? null);
        $idea      = $requester->ideas()->create([
            'title' => $title,
            'body'  => $body,
            'repository' => $repository,
        ])->attachTags($tags);

        tap(new IdeaCreated($idea), function ($newTicketNotification) use ($requester) {
            Admin::notifyAll($newTicketNotification);
            $requester->notify($newTicketNotification);
        });

        return $idea;
    }

    public function score()
    {
        return ($this->sales_impact + $this->current_impact) / ($this->development_effort + 1);
    }

    public function scopePending($query)
    {
        return $query->whereStatus(Idea::STATUS_NEW);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function requester()
    {
        return $this->belongsTo(Requester::class);
    }

    public function getSubscribableEmail()
    {
        return $this->requester->email;
    }

    public function getSubscribableName()
    {
        return $this->requester->name;
    }
}
