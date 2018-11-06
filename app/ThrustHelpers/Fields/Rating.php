<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Field;

class Rating extends Field
{
    public function displayInIndex($object)
    {
        return view('components.ticket.rating', ['ticket' => $object]);
    }

    public function displayInEdit($object, $inline = false)
    {
        return '';
    }
}
