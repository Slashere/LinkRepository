<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Entity\User;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\EditUser;
use Gate;
use Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Validator;


class UserService
{
    private function updateUserBasicValues(User $user, EditUser $request)
    {
        $user->login = $request->input('login') ?? $user->login;
        $user->name = $request->input('name') ?? $user->name;
        $user->last_name = $request->input('last_name') ?? $user->last_name;
    }

    private function updateUserStatusAndRole(User $user, EditUser $request)
    {
        $user->verified = $request->input('verified') ?? $user->verified;
        $user->role_id = $request->input('role') ?? $user->role_id;
    }

    public function update(User $user, EditUser $request)
    {
        $this->updateUserBasicValues($user, $request);

        if (Gate::allows('update-user-status-and-role')) {
            $this->updateUserStatusAndRole($user, $request);
        }

       if( $user->update()) {
           return $user;
       }
    }

    public function create(CreateUser $request)
    {
        $user = User::create([
            'login' => $request['login'],
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}