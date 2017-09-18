<?php

namespace App\Http\Controllers;

use App\Lead;

class LeadTagsController extends Controller
{
    public function store(Lead $lead)
    {
        $lead->attachTags([request('tag')]);

        return response()->json();
    }

    public function destroy(Lead $lead, $tag)
    {
        $lead->detachTag($tag);

        return response()->json();
    }
}
