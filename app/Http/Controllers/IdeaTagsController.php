<?php

namespace App\Http\Controllers;

use App\Idea;

class IdeaTagsController extends Controller
{
    public function store(Idea $idea)
    {
        $idea->attachTags([request('tag')]);

        return response()->json();
    }

    public function destroy(Idea $idea, $tag)
    {
        $idea->detachTag($tag);

        return response()->json();
    }
}
