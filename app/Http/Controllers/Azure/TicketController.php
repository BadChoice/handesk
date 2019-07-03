<?php

namespace App\Http\Controllers\Azure;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\ApiNotificationEvent;
use App\Notifications\TicketCreated;
use App\Requester;
use App\Settings;
use App\User;
use Illuminate\Http\Response;
use App\Team;
use App\Type;
use Illuminate\Support\Facades\Validator;
use App\TimeTracker as TT;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const STATUS_NEW = 1;
    const STATUS_OPEN = 2;
    const STATUS_PENDING = 3;
    const STATUS_SOLVED = 4;
    const STATUS_CLOSED = 5;
    const STATUS_MERGED = 6;
    const STATUS_SPAM = 7;
    public function index()
    {
        //

        try {
            $user = auth()->user();
            $type = request('type');
            if ($type=='teams') {
                $teams = $user->teams;
                $tickets = collect([]);
                foreach ($teams as $key => $team) {
                    $tickets = $tickets->merge($team->tickets()->with('requester', 'user', 'type', 'timeTracker')->whereNotIn('status', [self::STATUS_CLOSED, self::STATUS_SOLVED])->get());
                }
            } else {
                $tickets = $user->tickets()->with('requester', 'user', 'type', 'timeTracker')->whereNotIn('status', [self::STATUS_CLOSED, self::STATUS_SOLVED])->get();
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
        return response()->json($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
    public function calculatingCounter()
    {
        try {
            $user = auth()->user();
            $type = request('type');

            $teams = $user->teams;
            $team_ids = $teams->map(function ($t) {
                return $t->id;
            });
            $teams_tickets = collect([]);
            foreach ($teams as $key => $team) {
                $teams_tickets = $teams_tickets->merge($team->tickets()
                    ->with('requester', 'user', 'type', 'timeTracker')
                    ->whereNotIn('status', [self::STATUS_CLOSED, self::STATUS_SOLVED])
                    ->get());
            }
            $teams_counter = count($teams_tickets);
            $tickets = $user->tickets()->with('requester', 'user', 'type', 'timeTracker')->whereNotIn('status', [self::STATUS_CLOSED, self::STATUS_SOLVED])->get();
            $counter = count($tickets);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
        return response()->json(['ticket'=>$counter, 'teams'=>$teams_counter, 'teamIds'=>$team_ids]);
    }
}
