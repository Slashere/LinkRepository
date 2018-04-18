<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api') !== false;
    }

}