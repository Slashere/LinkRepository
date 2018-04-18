<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Response;

trait RestExceptionHandlerTrait
{

    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        if ($e instanceof AuthorizationException)
        {
            return response()->json([
                'code' => 403,
                'message' => 'This action is unauthorized.',
            ],403);
        }

        if ($e instanceof UnauthorizedHttpException)
        {
            return response()->json([
                'code' => 401,
                'message' => 'Your token is expired or your account deleted. Please log in or refresh your token',
            ],401);
        }
        if ($e instanceof \DomainException && $request->expectsJson()) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof ModelNotFoundException)
        {
            return response()->json([
                'code' => 404,
                'message' => 'Nothing here.',
            ],404);
        }

        if ($e instanceof NotFoundHttpException)
        {
            return response()->json([
                'code' => 404,
                'message' => 'Nothing here.',
            ],404);
        }

        if ($e instanceof MethodNotAllowedHttpException)
        {
            return response()->json([
                'code' => 405,
                'message' => 'Method not allowed',
            ],405);
        }


        if ($e instanceof HttpException)
        {
            return response()->json([
                'code' => $e->getStatusCode(),
                'response' => $e->getMessage()
            ], $e->getStatusCode());
        }

        return parent::render($request, $e);
    }
}