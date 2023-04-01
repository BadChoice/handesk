<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Passport\Helpers\JsonResponse;
use App\Classes\Passport\Traits\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;

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
        $rules = [
            'username' => 'required|email',
            'password' => 'required'
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'email'    => ':attribute harus berupa email.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors->first();
            return JsonResponse::badRequest($error);
        }

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