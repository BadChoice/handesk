<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  Throwable  $e
     * @return void
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Convert an exception into an response.
     *
     * @param  Request  $request
     * @param  Throwable  $e
     * @return JsonResponse|RedirectResponse
     */
    public function render($request, Throwable $e)
    {
        $segments = $request->segments();

        if(count($segments) > 1){
            if($segments[0] == 'api' || ($segments[0] == 'oauth' && $segments[1] == 'token')){
                if (
                    $e instanceof \Dotenv\Exception\ValidationException || 
                    $e instanceof BadRequestHttpException || 
                    $e instanceof OAuthServerException
                ) {
                    return response()->json(['error' => $e->getMessage()], 400);
                }elseif($e instanceof AuthenticationException) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }else if ($e instanceof ModelNotFoundException) {
                    return response()->json(['error' => 'Model not found'], 404);
                }else if ($e instanceof UserNotFound) {
                    return response()->json(['error' => 'User not found'], 404);
                }else if ($e instanceof NotFoundResourceException || $e instanceof NotFoundHttpException) {
                    return response()->json(['error' => 'Resource not found'], 404);
                }else if ($e instanceof MethodNotAllowedException || $e instanceof MethodNotAllowedHttpException) {
                    return response()->json(['error' => $e->getMessage()], 405);
                }else if($e instanceof InternalErrorException) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }else if($e instanceof QueryException) {
                    return response()->json(['error' => $e->getMessage()], 504);
                }else{
                    return response()->json(['error' => $e->getMessage()], $e->getCode());
                }
            }
        }
        
        return parent::render($request, $e);
    }
}
