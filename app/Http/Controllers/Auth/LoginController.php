<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Socialite;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/tickets';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToAzureProvider()
    {
        return Socialite::with('azure')->redirect();
    }
    public function handleAzureProviderCallback()
    {
        try {
            $user = Socialite::driver('azure')->user();
            // dd($user);
            $auth = $this->bindUserDataFromAzureUser($user->user);
            Auth::login($auth, true);
        } catch (\Exception $e) {
            redirect('/login');
            \Log::error($e);
            $this->incrementLoginAttempts(request());
            return $this->sendFailedLoginResponse(request());
        }
        return $this->sendLoginResponse(request());
    }

    protected function bindUserDataFromAzureUser($azure_user)
    {
        $azure_user = (object)$azure_user;
        $auth = User::where('azure_id', $azure_user->objectId)->first();
        if (!isset($auth->id)) {
            $auth = new User();
            $auth->displayName = $azure_user->displayName;
            $auth->givenName = $azure_user->givenName;
            $auth->jobTitle = $azure_user->jobTitle;
            $auth->mail = $azure_user->mail;
            $auth->telephoneNumber = $azure_user->telephoneNumber;
            $auth->userPrincipalName = $azure_user->userPrincipalName;
            $auth->azure_id = $azure_user->objectId;
            $auth->name = $azure_user->displayName;
            $auth->email = $azure_user->userPrincipalName;
            $auth->accountEnabled = $azure_user->accountEnabled;
            $auth->surname = $azure_user->surname;
            $auth->password = bcrypt('password');
            $auth->preferredLanguage = $azure_user->preferredLanguage;
            $auth->save();
        }
        return $auth;
    }
}