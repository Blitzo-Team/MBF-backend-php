<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // return parent::render($request, $e); # TODO: comment this out in production.
        $error = null;
        $eCode = 400;
        if ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            $error = $e->getMessage();
            $eCode = 401;
        } else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            $error = $e->getMessage();
            $eCode = 401;
        } else if ($e instanceof Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            $error = $e->getMessage();
        } else if ($e->getMessage() == 'Wrong number of segments' || $e->getMessage() == 'Token has expired') {
            $eCode = 401;
        }
        else {
            $error = $e->getMessage();
        }
        return response()->json(['error' => $e->getMessage(), 'messages' => [$e->getMessage(), $e->getTraceAsString()]], $eCode);

    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        return response()->json(['error' => 'unauthenticated', 'messages' => ['Please login.']], 401);
    }
}
