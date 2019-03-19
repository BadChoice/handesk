<?php

namespace App\Http\Controllers\Api;

use App\User;

class UsersController extends ApiController
{
    //
    public function getUsers()
    {
        try {
            return response()->json(User::with('teams')->get());
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}