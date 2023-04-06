<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    public function show($filename)
    {
        return Storage::disk(config('filesystems.default'))->download("public/attachments/{$filename}");
    }
}
