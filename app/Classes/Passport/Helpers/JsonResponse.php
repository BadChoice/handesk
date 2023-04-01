<?php

namespace App\Classes\Passport\Helpers;

class JsonResponse
{
    public static function badRequest($msg)
    {
        return response()->json(['error' => $msg], 400);
    }
}
