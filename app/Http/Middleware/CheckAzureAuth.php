<?php

namespace App\Http\Middleware;

use App\Services\AzureService;
use Closure;
use Auth;

class CheckAzureAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $azureService;

    public function __construct(AzureService $azureService)
    {
        $this->azureService = $azureService;
    }
    public function handle($request, Closure $next)
    {
        $accessToken = $request->bearerToken();
        try {
            $userInfo = $this->azureService->getUserByToken($accessToken);
            $user = $this->azureService->asyncUserFromAzureAD($userInfo);
            Auth::login($user, true);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }
        return $next($request);
    }
}