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
    public $primaryKey = 'user_id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Entity\User', 'user_id');
    }

    public static function createTokens(User $user)
    {
        self::create([
            'user_id' => $user->id,
            'access_token' => str_random(40)->unique('access_token', 'refresh_token'),
            'access_token_expired_date' => Carbon::now()->addHours(Config::get('constants.access_token_time')),
            'refresh_token' => str_random(40)->unique('access_token', 'refresh_token'),
            'refresh_token_expired_date' => Carbon::now()->addHours(Config::get('constants.refresh_token_time')),
        ]);
    }

    public static function updateTokens(User $user)
    {
        self::where('user_id', $user->id)->update([
            'access_token' => str_random(40)->unique('access_token', 'refresh_token'),
            'access_token_expired_date' => Carbon::now()->addHours(Config::get('constants.access_token_time')),
            'refresh_token' => str_random(40)->unique('access_token', 'refresh_token'),
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
        if (self::findOrFail($token))
            return true;
    }

    public static function invalidate()
    {

    }
}
