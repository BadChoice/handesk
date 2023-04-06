<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Passport\Helpers\JsonResponse;
use App\Classes\Passport\Traits\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
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
        $granTypeValue = array('password', 'refresh_token', 'personal_access', 'implicit', 'authorization_code', 'client_credentials');

        $rules = [
            'username'   => 'required|email',
            'grant_type' => 'required|in:'.implode(',', $granTypeValue),
            'password'   => 'required'
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'email'    => ':attribute harus berupa email.',
            'in'       => ':attribute tidak valid. Value yang tersedia saat ini adalah : password',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors->first();
            return JsonResponse::badRequest($error);
        }

        
        /**
         * Check User
         */
        $user = User::where('email', $request->username)->first();

        if(!$user) return JsonResponse::badRequest('User belum terdaftar!');

        if( !\Hash::check($request->password, $user->password) ) return JsonResponse::badRequest('Kata Sandi tidak sesuai!');

        $credentials = $this->buildCredentials($request->all(), $request->grant_type);
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