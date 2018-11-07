<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Field;

class Status extends Field
{
    public function displayInIndex($lead)
    {
        $link = route('leads.show', $lead);

        return "<a class='label lead-status-{$lead->statusName()}' href='{$link}'>".__('lead.'.$lead->statusName()).' </a>';
    }

    public function displayInEdit($object, $inline = false)
    {
        return '';
    }
}
