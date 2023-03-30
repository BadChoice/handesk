<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Passport\Traits\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    use FormRequest;

    public function login(Request $request)
    {
        $credentials = $this->buildCredentials($request->all());
        $result = $this->makeRequest($credentials);
         
        return response($result);
    }

    public function me()
    {
        $user = Auth::user();

        return response($user);
    }
}