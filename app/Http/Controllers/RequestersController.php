<?php

namespace App\Http\Controllers;

use BadChoice\Thrust\Controllers\ThrustController;

class RequestersController extends Controller
{
    public function index()
    {
        return (new ThrustController)->index('requesters');
    }
}
