<?php

namespace App\Http\Controllers\Api;

use App\Lead;
use App\Notifications\LeadCreated;
use App\User;
use Illuminate\Http\Response;

class LeadsController extends ApiController
{
    public function store()
    {
        $this->validate(request(), [
            'name'  => 'required|min:3',
            'email' => 'required|email',
            'tags'  => 'required',
        ]);

        $lead = Lead::where('email', request('email'))->orWhere('phone', request('phone'))->first();
        if ($lead) {
            $lead->attachTags(request('tags'));

            return $this->respond(['id' => $lead->id], Response::HTTP_CREATED);
        }

        $lead = Lead::create([
            'email' => request('email'),
            'name'  => request('name'),

            'team_id'     => request('team_id'),
            'username'    => request('username'),
            'company'     => request('company'),
            'city'        => request('city'),
            'country'     => request('country'),
            'phone'       => request('phone'),
            'address'     => request('address'),
            'postal_code' => request('postal_code'),
            'body'        => request('body'),
        ])->attachTags(request('tags'));

        $lead->subscribeToMailchimp();

        User::notifyAdmins(new LeadCreated($lead));

        return $this->respond(['id' => $lead->id], Response::HTTP_CREATED);
    }
}
