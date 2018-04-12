<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


class VerifyUser extends Model
{

    protected $guarded = [];
    public $primaryKey = 'user_id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Entity\User', 'user_id');
    }

}