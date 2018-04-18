<?php

namespace App\Entity;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Http\Requests\User\ApiCreateUser;
use App\Http\Requests\User\EditUser;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'login', 'name', 'last_name', 'email', 'password', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token', 'status', 'updated_at' , 'created_at',
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

    public function isEditor()
    {
        if ($this->role->name == 'Editor') {
            return true;
        }

        return false;
    }

    public static function register(ApiCreateUser $request): self
    {
        return self::create([
            'login' => $request['login'],
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
    }

    public function updateUserBasicValues(User $user, EditUser $request)
    {
        $user->login = $request->input('login') ?? $user->login;
        $user->name = $request->input('name') ?? $user->name;
        $user->last_name = $request->input('last_name') ?? $user->last_name;
    }

    public function updateUserStatusAndRole(User $user, EditUser $request)
    {
        $user->status = $request->input('status') ?? $user->status;
        $user->role_id = $request->input('role') ?? $user->role_id;
    }


    public function getJWTCustomClaims(): array {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
}
