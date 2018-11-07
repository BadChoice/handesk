<?php

namespace App\Repositories;

class LeadsIndexQuery
{
    public static function get(LeadsRepository $repository = null)
    {
        if (! $repository) {
            $repository = app(LeadsRepository::class);
        }

        if (request('mine')) {
            $leads = $repository->assignedToMe();
        } elseif (request('completed')) {
            $leads = $repository->completed();
        } elseif (request('failed')) {
            $leads = $repository->failed();
        } else {
            $leads = $repository->all();
        }

        if (request('team')) {
            $leads = $leads->where('leads.team_id', request('team'));
        }

        return $leads;
    }
}
