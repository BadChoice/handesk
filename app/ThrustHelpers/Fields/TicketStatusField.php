<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Field;

class TicketStatusField extends Field
{
    public $showInEdit = false;

    public function displayInIndex($ticket)
    {
        return view('components.ticket.status', ['ticket' => $ticket]);
    }

    public function displayInEdit($object, $inline = false)
    {
        return '';
    }
}
