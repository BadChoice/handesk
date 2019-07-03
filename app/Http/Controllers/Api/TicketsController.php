<?php

namespace App\Http\Controllers\Api;

use App\Events\ApiNotificationEvent;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Settings;
use App\Ticket;
use App\User;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Response;
use App\Team;
use App\Type;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Validator;
use App\TimeTracker as TT;
use App\Events\TicketNotificationEvent;

class TicketsController extends ApiController
{
    const STATUS_NEW = 1;
    const STATUS_OPEN = 2;
    const STATUS_PENDING = 3;
    const STATUS_SOLVED = 4;
    const STATUS_CLOSED = 5;
    const STATUS_MERGED = 6;
    const STATUS_SPAM = 7;

    public function index()
    {
        try {
            $user = User::where('name', request('requester'))->orWhere('email', request('requester'))->firstOrFail();
            $type = request('type');
            if ($type=='teams') {
                $teams = $user->teams;
                $tickets = collect([]);
                foreach ($teams as $key => $team) {
                    $tickets = $tickets->merge($team->tickets()->with('requester', 'user', 'type', 'timeTracker')->whereNotIn('status', [ self::STATUS_CLOSED, self::STATUS_SOLVED])->get());
                    \Log::info($team->tickets);
                }
            } else {
                $tickets = $user->tickets()->with('requester', 'user', 'type', 'timeTracker')->whereNotIn('status', [ self::STATUS_CLOSED, self::STATUS_SOLVED])->get();
            }
        } catch (\Throwable $th) {
            return $this->respond($th->getMessage(), 404);
        }
        return $this->respond($tickets);
    }

    public function show(Ticket $ticket)
    {
        return $this->respond($ticket->load('requester', 'user', 'type', 'comments', 'timeTracker'));
    }

    public function store()
    {
        $this->validate(request(), [
            'requester' => 'required|array',
            'title' => 'required|min:3',
        ]);

        $ticket = Ticket::createAndNotify(
            request('requester'),
            request('title'),
            request('body'),
            request('tags')
        );

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        } else {
            $this->notifyDefault($ticket);
        }
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = 'New ticket has been created!';
        event(new ApiNotificationEvent($data));

        return $this->respond(['id' => $ticket->id], Response::HTTP_CREATED);
    }

    public function update(Ticket $ticket)
    {
        $ticket->updateStatus(request('status'));
        $ticket->requester;
        $ticket->user;
        $data['data'] = json_encode($ticket);
        $data['type'] = 'ticket';
        $data['message'] = $ticket->title . ' has been updated!';
        event(new ApiNotificationEvent($data));
        return $this->respond(['id' => $ticket->id], Response::HTTP_OK);
    }

    private function notifyDefault($ticket)
    {
        $setting = Settings::first();
        if ($setting && $setting->slack_webhook_url) {
            $setting->notify(new TicketCreated($ticket));
        }
    }
    public function updateRating($id)
    {
        try {
            $rating = request('rating');
            $rating = is_numeric($rating) ? $rating : 0;
            $ticket = Ticket::findOrFail($id);
            $ticket->rating = $rating;
            $ticket->status = 5;
            $ticket->save();
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([], 500);
            //throw $th;
        }
    }

    public function assignTicket($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);

            if (request('team_id')) {
                $this->authorize('assignToTeam', $ticket);
                $ticket->assignToTeam(request('team_id'));
                $teamUsers =  $ticket->team->members;
                foreach ($teamUsers as $key => $user) {
                    event(new TicketNotificationEvent($user->azure_id));
                }
            }
            if (request('user_id')) {
                $ticket->assignTo(request('user_id'));
                event(new TicketNotificationEvent($ticket->user->azure_id));
            }
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }
    public function storeFromApp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' =>' required|min:3',
                'email' => 'required|min:3',
                'title' => 'required|min:3',
                'body' => 'required',
                'team_id' => 'nullable|exists:teams,id',
                'type_id' => 'required|exists:types,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'Submit error', 'data' => $validator->errors(), 'response_code' => 0], 302);
            }
            $data = $request->all();
            $tags = json_decode($request->tags);
            $ticket = Ticket::createAndNotify(['name'=>$request->name, 'email'=>$request->email], request('title'), request('body'), $tags, request('type_id'));
            $ticket->updateStatus(request('status'));
            return response()->json($ticket);
        } catch (\Throwable $th) {
        }
    }

    public function fetchTypeAndStatus()
    {
        try {
            $teams = Team::all();
            $types = Type::all();
            return response()->json([
                'types'=>$types,
                'teams'=>$teams
            ]);
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }

    public function updateTracker($id)
    {
        try {
            $ticket  = Ticket::with('requester', 'user', 'comments', 'type', 'timeTracker')->findOrFail($id);
            $status = request('status');
            $timeTracker = $ticket->timeTracker;
            if (!isset($timeTracker->id)) {
                $timeTracker = new TT();
                $timeTracker->ticket_id = $ticket->id;
            }
            $current_timestamp = date_timestamp_get(date_create());
            switch ($status) {
                case '0':
                    $timeTracker->stop();
                    break;
                case '1':
                case '2':
                    $timeTracker->start();
                    break;
                default:
                    break;
            }
        } catch (\Throwable $th) {
        }
        $ticket->timeTracker =$timeTracker;
        return response()->json($ticket);
    }
}
