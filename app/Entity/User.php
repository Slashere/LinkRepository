<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'login', 'name', 'last_name', 'email', 'password', 'status', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function link()
    {
        return $this->hasMany(Link::class);
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id','role_id');
    }

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function hasAccess(array $permissions)
    {
            if ($this->role->hasAccess($permissions)) {
                return true;
        }
        return false;
    }

    public function isAdmin()
    {
            if ($this->role->name == 'Admin') {
                return true;
        }

        return false;
    }

    public function isWait(): bool
    {
        return $this->status === 0;
    }

    public function isActive(): bool
    {
        return $this->status === 1;
    }

    public function getJWTCustomClaims(): array {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
}
