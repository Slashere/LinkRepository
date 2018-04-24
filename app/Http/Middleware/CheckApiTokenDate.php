<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApiTokenDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (Auth::check() && strtotime(Auth::user()->token['access_token_expired_date']) <= time()) {
            return response()->json(['code' => 401, 'message' => 'access_token is expired'], 401);
        }
        return $response;
    }
}
