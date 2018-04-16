<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException)
        {
            return response()->json([
                'code' => 403,
                'message' => 'This action is unauthorized.',
            ],403);
        }

        if ($exception instanceof  UnauthorizedHttpException)
        {
            return response()->json([
                'code' => 401,
                'message' => 'Your token is expired or didn\'t generated. Please log in',
            ],401);
        }
        if ($exception instanceof \DomainException && $request->expectsJson()) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
