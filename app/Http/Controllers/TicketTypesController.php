<?php

namespace App\Http\Controllers;

use BadChoice\Thrust\Controllers\ThrustController;

class TicketTypesController extends Controller
{
    public function index()
    {
        return (new ThrustController)->index('ticketTypes');
    }
}
