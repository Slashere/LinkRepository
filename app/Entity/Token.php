<?php

namespace App\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Token extends Model
{
    protected $table = 'tokens';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Entity\User', 'user_id');
    }

    public static function createTokens($id)
    {
        self::create([
            'user_id' => $id,
            'access_token' => str_random(40),
            'access_token_expired_date' => Carbon::now()->addHours(Config::get('constants.access_token_time')),
            'refresh_token' => str_random(40),
            'refresh_token_expired_date' => Carbon::now()->addHours(Config::get('constants.refresh_token_time')),
        ]);
    }

    public static function updateTokens($id)
    {
        self::where('user_id', $id)->update([
            'access_token' => str_random(40),
            'access_token_expired_date' => Carbon::now()->addHours(Config::get('constants.access_token_time')),
            'refresh_token' => str_random(40),
            'refresh_token_expired_date' => Carbon::now()->addHours(Config::get('constants.refresh_token_time')),
        ]);
    }

    public static function checkRefreshToken($token)
    {
        if (self::where('refresh_token', $token)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkAccessToken($token)
    {
        if (self::where('access_token', $token)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function invalidate()
    {

    }
}
