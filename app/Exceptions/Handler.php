<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  Request  $request
     * @param  Throwable  $exception
     * @return JsonResponse|RedirectResponse
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        
        $exc = $exception->getStatusCode();
        if ($exc != null) {
            $msg = $exception->getMessage();
            
            if($msg == null){
                if($exc == 404) $msg = 'Route not found';
                if($exc == 500) $msg = 'Internal Server Error';
            }
            
            return response()->json(['error' => $msg], $exc);
        }
        
        return parent::render($request, $exception);
    }
}
