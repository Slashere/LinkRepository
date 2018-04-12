<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
