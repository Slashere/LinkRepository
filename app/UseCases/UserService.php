<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use App\User;
use Illuminate\Http\Request;
use Gate;
use Validator;
use App\Http\Resources\User as UserResource;


class UserService
{
    private function updateUserBasicValues(User $user, Request $request)
    {
        $user->login = $request->input('login') ?? $user->login;
        $user->name = $request->input('name') ?? $user->name;
        $user->surname = $request->input('surname') ?? $user->surname;
    }

    private function updateUserStatusAndRole(User $user, Request $request)
    {
        $user->verified = $request->input('verified') ?? $user->verified;
        $user->role_id = $request->input('role') ?? $user->role_id;
    }

    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
        'login' => 'string|max:255|min:3',
        'name' => 'string|max:255|min:2',
        'surname' => 'string|max:255|min:2',
    ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->updateUserBasicValues($user, $request);

        if (Gate::allows('update-user-status-and-role')) {
            $this->updateUserStatusAndRole($user, $request);
        }

        if($user->update()) {
            return new UserResource($user);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
    ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::create([
            'login' => $request['login'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'verified' => 1,
        ]);

        if($user->save()) {
            return new UserResource($user);
        }
    }

    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->delete();
    }

}