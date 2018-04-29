<?php

namespace App\Http\Controllers\Api;

use App\Lead;
use App\Team;

class TeamLeadsController extends ApiController
{
    public function index(Team $team)
    {
        $leads = $team->leads()->where('status', '<', Lead::STATUS_COMPLETED);

        if (request('count')) {
            return $this->respond(['count' => $leads->count()]);
        }

        return $this->respond($leads->paginate(50));
    }
}
