<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Field;

class Tasks extends Field
{
    public function displayInIndex($lead)
    {
        if ($lead->uncompletedTasks->count()) {
            $link  = route('leads.tasks.index', $lead);
            $count = $lead->uncompletedTasks->count();

            return "<span class='label lead-status-failed'> <a href='{$link}' class='white'> {$count}</a ></span >";
        }

        return '';
    }

    public function displayInEdit($object, $inline = false)
    {
        return '';
    }
}
