<?php

namespace App\Http\Controllers;

use App\Entity\Token;
use App\Entity\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use JWTAuth;
use Auth;


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

        if (Auth::once($credentials)) {
            $user = Auth::getUser();
            if ($user->token == false) {
                Token::createTokens($user);
            } else {
                Token::updateTokens($user);
            }
            $accessToken = Token::where('user_id', $user->id)->pluck('access_token');
            $refreshToken = Token::where('user_id', $user->id)->pluck('refresh_token');
            return response()->json(['access_token' => $accessToken, 'refresh_token' => $refreshToken]);
        } else {
            return response()->json(['code' => 401, 'message' => 'These credentials do not match our records.'], 401);
        }
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->bearerToken();

        if (Token::checkRefreshToken($refreshToken)) {
            Token::updateTokens($user);
            $accessToken = Token::where('refresh_token', $refreshToken)->pluck('access_token');
            $refreshToken = Token::where('refresh_token', $refreshToken)->pluck('refresh_token');
            return response()->json(['access_token' => $accessToken, 'refresh_token' => $refreshToken]);

        } else {
            return response()->json(['message' => 'Invalid token']);
        }
    }

    public function invalidate(Request $request)
    {
        $token = $request->bearerToken();

        try {
            $token = JWTAuth::invalidate($token);
            return response()->json(['response' => 'success', 'msg' => 'Your token deleted']);
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException(
                Response::json(['msg' => "Your token Expired. Need to refresh Token or login again"])
            );
        }
    }
}