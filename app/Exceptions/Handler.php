<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        TokenMismatchException::class,
        ValidationException::class,
        OAuthServerException::class,
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
