<?php

namespace App;

use App\Authenticatable\Admin;
use App\Notifications\IdeaCreated;
use App\Services\IssueCreator;
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
        $requester = Requester::findOrCreate($requester['name'] ?? 'Unknown', $requester['email'] ?? null);
        $idea      = $requester->ideas()->create([
            'title'      => $title,
            'body'       => $body,
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
        return (int) (($this->sales_impact + $this->current_impact) / ($this->development_effort / 10 + 1));
    }

    public function scopePending($query)
    {
        return $query->whereStatus(self::STATUS_NEW);
    }

    public function scopeOngoing($query)
    {
        return $query->where(function ($query) {
            return $query->where('status', self::STATUS_OPEN)->orWhere('status', self::STATUS_ACCEPTED);
        });
    }

    public function scopeRoadmap($query)
    {
        return $query->where(function ($query) {
            return $query->where('status', self::STATUS_OPEN)->orWhere('status', self::STATUS_ACCEPTED)->orWhere('status', self::STATUS_RESOLVED);
        });
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

    public function statusName()
    {
        switch ($this->status) {
            case static::STATUS_NEW: return 'new';
            case static::STATUS_OPEN: return 'open';
            case static::STATUS_ACCEPTED: return 'accepted';
            case static::STATUS_RESOLVED: return 'solved';
            case static::STATUS_CLOSED: return 'closed';
            case static::STATUS_MERGED: return 'merged';
            case static::STATUS_DECLINED: return 'declined';
        }
    }

    public function repositoryName()
    {
        if (! $this->repository) {
            return '';
        }

        return array_flip(config('issues.repositories'))[$this->repository] ?? $this->repository;
    }

    public function createIssue(IssueCreator $issueCreator)
    {
        $repo  = explode('/', $this->repository);
        $issue = $issueCreator->createIssue(
            $repo[0],
            $repo[1],
            $this->title,
            'Issue from idea: '.route('ideas.show', $this)."   \n\r".$this->body
        );
        $this->update(['issue_id' => $issue->id]);

        return $issue;
    }

    public function issueUrl()
    {
        return "https://bitbucket.org/{$this->repository}/issues/{$this->issue_id}/";
    }
}
