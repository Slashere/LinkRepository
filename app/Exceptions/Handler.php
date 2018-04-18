<?php

namespace App\Exceptions;

use App\Traits\RestExceptionHandlerTrait;
use App\Traits\RestTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{

    use RestTrait;
    use RestExceptionHandlerTrait;

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

    public function render($request, Exception $e)
    {
        if(!$this->isApiCall($request)) {
            $retval = parent::render($request, $e);
        } else {
            $retval = $this->getJsonResponseForException($request, $e);
        }

        return $retval;
    }
}
