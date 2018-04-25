<?php

namespace App\Http\Controllers;

use App\Entity\Token;
use App\Entity\User;
use Illuminate\Auth\TokenGuard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;


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
                Token::createTokens($user->id);
            } else {
                Token::updateTokens($user->id);
            }
            $accessToken = Token::where('user_id', $user->id)->pluck('access_token');
            $accessTokenRefresh = Token::where('user_id', $user->id)->pluck('access_token_expired_date');
            $refreshToken = Token::where('user_id', $user->id)->pluck('refresh_token');
            $refreshTokenRefresh = Token::where('user_id', $user->id)->pluck('refresh_token_expired_date');

            return response()->json(['Access token' => $accessToken, 'Access token expiration date' => $accessTokenRefresh, 'Refresh token' => $refreshToken, 'Refresh token expiration date' => $refreshTokenRefresh ]);
        } else {
            return response()->json(['code' => 401, 'message' => 'These credentials do not match our records.'], 401);
        }
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->bearerToken();
        $token = Token::where('refresh_token', $refreshToken)->first();
        if (Token::checkRefreshToken($refreshToken)) {
            Token::updateTokens($token->user_id);
            $accessToken = Token::where('user_id', $token->user_id)->pluck('access_token');
            $refreshToken = Token::where('user_id', $token->user_id)->pluck('refresh_token');
            return response()->json(['access_token' => $accessToken, 'refresh_token' => $refreshToken]);
        } else {
            return response()->json(['message' => 'Invalid refresh token']);
        }
    }

    public static function invalidate(Request $request)
    {
        $acceessToken = $request->bearerToken();
        if(Token::where('access_token', $acceessToken)->where('access_token_expired_date', '>' , date("Y-m-d H:i:s"))->delete()){
            return response()->json(['response' => 'success', 'msg' => 'Your token deleted']);
        } else return response()->json(['msg' => "Your token Expired. Need to refresh Token or login again"]);

        }

}