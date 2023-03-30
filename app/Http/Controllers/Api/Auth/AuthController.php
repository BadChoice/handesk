<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Passport\Traits\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    use FormRequest;

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ExampleStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $this->buildCredentials($request->all());
        $result = $this->makeRequest($credentials);
         
        return response($result);
    }

    /**
     * Profile info
     *
     * @return void
     */
    public function me()
    {
        $user = Auth::user();

        return response($user);
    }
}