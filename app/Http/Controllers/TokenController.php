<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use JWTAuth;


class TokenController extends Controller
{
    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 1,
                'messages' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = JWTAuth::attempt($credentials);

        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['code' => 2, 'message' => 'Invalid token']);
        }
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            return response()->json(['token' => $token]);
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException(
                Response::json(['msg' => "Your token Expired. Need to refresh Token or login again"])
            );
        } catch (TokenBlacklistedException $e) {
            throw new HttpResponseException(
                Response::json(['msg' => "Your token Blacklisted. Need to refresh Token or login again"])
            );
        }
    }

    public function invalidate()
    {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::invalidate($token);
            return response()->json(['response' => 'success','msg' => 'Your token deleted']);
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException(
                Response::json(['msg' => "Your token Expired. Need to refresh Token or login again"])
            );
        }
    }
}