<?php

namespace App\Http\Controllers\Api;

use App\User;

class UsersController extends ApiController
{
    //
    public function getUsers()
    {
        try {
            return response()->json(User::all());
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }
}