<?php

namespace App;

use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use App\Events\TicketCommented;
use App\Events\TicketStatusUpdated;
use App\Notifications\RateTicket;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketCreated;
use App\Notifications\TicketEscalated;
use App\Services\IssueCreator;
use App\Services\TicketLanguageDetector;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Ticket extends BaseModel
{
    use SoftDeletes, Taggable, Assignable, Subscribable, Rateable;

    const STATUS_NEW     = 1;
    const STATUS_OPEN    = 2;
    const STATUS_PENDING = 3;
    const STATUS_SOLVED  = 4;
    const STATUS_CLOSED  = 5;
    const STATUS_MERGED  = 6;
    const STATUS_SPAM    = 7;

    const PRIORITY_LOW       = 1;
    const PRIORITY_NORMAL    = 2;
    const PRIORITY_HIGH      = 3;
    const PRIORITY_BLOCKER   = 4;

    public static function createAndNotify($requester, $title, $body, $tags)
    {
        $requester = Requester::findOrCreate($requester['name'] ?? 'Unknown', $requester['email'] ?? null);
        $ticket    = $requester->tickets()->create([
            'title'        => substr($title, 0, 190),
            'body'         => $body,
            'public_token' => str_random(24),
            'team_id'      => Settings::defaultTeamId(),
        ])->attachTags($tags);
        tap(new TicketCreated($ticket), function ($newTicketNotification) use ($requester, $ticket) {
            Admin::notifyAll($newTicketNotification);
            if ($ticket->team) {
                $ticket->team->notify($newTicketNotification);
            }
        });

        return $ticket;
    }

    public function updateWith($requester, $priority, $ticket_type_id)
    {
        $requester = Requester::findOrCreate($requester['name'] ?? 'Unknown', $requester['email'] ?? null);
        $this->update([
            'priority'       => $priority,
            'requester_id'   => $requester->id,
            'ticket_type_id' => $ticket_type_id,
        ]);

        return $this;
    }

    public function updateSummary($subject, $summary)
    {
        $this->update(['subject' => $subject, 'summary' => $summary]);

        return $this;
    }

    public static function findWithPublicToken($public_token)
    {
        return self::where('public_token', $public_token)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requester()
    {
        return $this->belongsTo(Requester::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comments()
    {
        return $this->commentsAndNotes()->where('private', false);
    }

    public function commentsAndNotes()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function commentsAndNotesAndEvents()
    {
        return $this->commentsAndNotes->toBase()->merge($this->events);
    }

    public function events()
    {
        return $this->hasMany(TicketEvent::class)->latest();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function mergedTickets()
    {
        return $this->belongsToMany(self::class, 'merged_tickets', 'ticket_id', 'merged_ticket_id');
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    /**
     * @param $user
     * @param $newStatus
     *
     * @return mixed
     */
    private function updateStatusFromComment($user, $newStatus)
    {
        $previousStatus = $this->status;
        if ($newStatus && $newStatus != $previousStatus) {
            $this->updateStatus($newStatus);
        } elseif (! $user && $this->status != static::STATUS_NEW) {
            $this->updateStatus(static::STATUS_OPEN);
        } else {
            $this->touch();
        }
        event(new TicketStatusUpdated($this, $user, $previousStatus));

        return $previousStatus;
    }

    private function associateUserIfNecessary($user)
    {
        if (! $this->user && $user) {
            $this->user()->associate($user)->save();
        }
    }

    protected function getAssignedNotification()
    {
        return new TicketAssigned($this);
    }

    public function addComment($user, $body, $newStatus = null)
    {
        if ($user && $this->isEscalated()) {
            return $this->addNote($user, $body);
        }
        $previousStatus = $this->updateStatusFromComment($user, $newStatus);
        $this->associateUserIfNecessary($user);

        if (! $body || ($user && $body === $user->settings->tickets_signature)) {
            return null;
        }

        $comment = $this->comments()->create([
            'body'       => $body,
            'user_id'    => $user ? $user->id : null,
            'new_status' => $newStatus ?: $this->status,
        ])->notifyNewComment();
        event(new TicketCommented($this, $comment, $previousStatus));

        return $comment;
    }

    public function addNote($user, $body)
    {
        if (! $body) {
            return null;
        }
        //if( ! $this->user && $user) { $this->user()->associate($user)->save(); }  //We don't want the notes to automatically assign the user
        else {
            $this->touch();
        }

        return $this->comments()->create([
            'body'       => $body,
            'user_id'    => $user->id,
            'new_status' => $this->status,
            'private'    => true,
        ])->notifyNewNote();
    }

    public function merge($user, $tickets)
    {
        collect($tickets)->map(function ($ticket) {
            return is_numeric($ticket) ? Ticket::find($ticket) : $ticket;
        })->reject(function ($ticket) {
            return $ticket->id == $this->id || $ticket->status > Ticket::STATUS_SOLVED;
        })->each(function ($ticket) use ($user) {
            $ticket->addNote($user, "Merged with #{$this->id}");
            $ticket->updateStatus(Ticket::STATUS_MERGED);
            $this->mergedTickets()->attach($ticket);
        });
    }

    public function updateStatus($status)
    {
        $this->update(['status' => $status, 'updated_at' => Carbon::now()]);
        TicketEvent::make($this, 'Status updated: '.$this->statusName());
        if ($status == Ticket::STATUS_SOLVED && ! $this->rating && config('handesk.sendRatingEmail')) {
            $this->requester->notify((new RateTicket($this))->delay(now()->addMinutes(60)));
        }
    }

    public function updatePriority($priority)
    {
        $this->update(['priority' => $priority, 'updated_at' => Carbon::now()]);
        TicketEvent::make($this, 'Priority updated: '.$this->priorityName());
    }

    public function setLevel($level)
    {
        $this->update(['level' => $level]);
        if ($level == 1) {
            TicketEvent::make($this, 'Escalated');

            return Assistant::notifyAll(new TicketEscalated($this));
        }
        TicketEvent::make($this, 'De-Escalated');
    }

    public function isEscalated()
    {
        return $this->level == 1;
    }

    public function hasBeenReplied()
    {
        return $this->comments()->whereNotNull('user_id')->count() > 1;
    }

    public function scopeOpen($query)
    {
        return $query->where('status', '<', self::STATUS_SOLVED);
    }

    public function scopeSolved($query)
    {
        return $query->where('status', '>=', self::STATUS_SOLVED);
    }

    public function canBeEdited()
    {
        return ! in_array($this->status, [self::STATUS_CLOSED, self::STATUS_MERGED]);
    }

    public static function statusNameFor($status)
    {
        switch ($status) {
            case static::STATUS_NEW: return 'new';
            case static::STATUS_OPEN: return 'open';
            case static::STATUS_PENDING: return 'pending';
            case static::STATUS_SOLVED: return 'solved';
            case static::STATUS_CLOSED: return 'closed';
            case static::STATUS_MERGED: return 'merged';
            case static::STATUS_SPAM: return 'spam';
        }
    }

    public function statusName()
    {
        return static::statusNameFor($this->status);
    }

    public static function priorityNameFor($priority)
    {
        switch ($priority) {
            case static::PRIORITY_LOW: return 'low';
            case static::PRIORITY_NORMAL: return 'normal';
            case static::PRIORITY_HIGH: return 'high';
            case static::PRIORITY_BLOCKER: return 'blocker';
        }
    }

    public function priorityName()
    {
        return static::priorityNameFor($this->priority);
    }

    public function getSubscribableEmail()
    {
        return $this->requester->email;
    }

    public function getSubscribableName()
    {
        return $this->requester->name;
    }

    //========================================================
    // ISSUE
    //========================================================
    public function createIssue(IssueCreator $issueCreator, $repository)
    {
        $repo  = explode('/', $repository);
        $issue = $issueCreator->createIssue(
                $repo[0],
                $repo[1],
                $this->subject ?? $this->title,
                'Issue from ticket: '.route('tickets.show', $this)."   \n\r".($this->summary ?? $this->body)
        );
        $issueUrl = "https://bitbucket.org/{$repository}/issues/{$issue->id}";
        $this->addNote(auth()->user(), "Issue created {$issueUrl} with id #{$issue->id}");
        TicketEvent::make($this, "Issue created #{$issue->id} at {$repository}");

        return $issue;
    }

    public function findIssueNote()
    {
        return $this->commentsAndNotes->first(function ($comment) {
            return starts_with($comment->body, 'Issue created');
        });
    }

    public function getIssueId()
    {
        $issueNote = $this->findIssueNote();
        if (! $issueNote) {
            return null;
        }

        return substr($issueNote->body, strpos($issueNote->body, '#') + 1);
    }

    public function issueUrl()
    {
        $issueNote = $this->findIssueNote();
        if (! $issueNote) {
            return null;
        }
        $start  = strpos($issueNote->body, 'https://');
        $end    = strpos($issueNote->body, 'with id');

        return substr($issueNote->body, $start, $end - $start);
    }

    public function createIdea()
    {
        $idea = Idea::create([
            'requester_id' => $this->requester_id,
            'title'        => $this->title,
            'body'         => $this->body,
        ])->attachTags(['ticket']);
        TicketEvent::make($this, "Idea created #{$idea->id}");
        App::setLocale((new TicketLanguageDetector($this))->detect());
        $this->addComment(auth()->user(), __('idea.fromTicket'), self::STATUS_SOLVED);

        return $idea;
    }

    public function getIdeaId()
    {
        $issueEvent = $this->events()->where('body', 'like', '%Idea created%')->first();
        if (! $issueEvent) {
            return null;
        }

        return explode('#', $issueEvent->body)[1];
    }
}
