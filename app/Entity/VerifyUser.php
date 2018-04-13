<?php

namespace App\Entity;

use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class VerifyUser extends Model
{

    protected $guarded = [];
    public $primaryKey = 'user_id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Entity\User', 'user_id');
    }

    public static function createVerify($id): self
    {
        return self::create([
            'user_id' => $id,
            'token' => str_random(40),
            'expired_date' => Carbon::now()->addHours(Config::get('constants.options'))
        ]);
    }

}