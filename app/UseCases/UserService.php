<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use App\Entity\User;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\EditUser;
use Gate;
use Response;
use Validator;
use Auth;

class UserService
{
    public function show(User $user)
    {
        if (Auth::guard()->user()) {
            if (Auth::guard()->user()->id == $user->id) {
                return $user->makeVisible(['status']);
            } elseif (Auth::guard()->user()->isAdmin()){
                return $user->makeVisible(['status']);
            }
        }
        return $user;
    }

    public function update(User $user, EditUser $request)
    {
        $user->updateUserBasicValues($user, $request);

        if (Gate::allows('update-user-status-and-role')) {
            $user->updateUserStatusAndRole($user, $request);
        }

       if( $user->update()) {
           return $user;
       }
    }

    public function create(CreateUser $request)
    {
        return User::register($request);
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}