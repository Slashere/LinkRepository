<?php
/**
 * Created by PhpStorm.
 * User: Slash
 * Date: 03.04.2018
 * Time: 2:07
 */

namespace App\UseCases;

use App\Entity\User;
use App\Entity\Link;
use Illuminate\Http\Request;
use Gate;
use Validator;
use App\Http\Requests\Link\EditLink;

class LinkService
{
    public function show(Link $link)
    {
//        if (Gate::allows('show-private-link', $link) or $link->private == 0) {
//           return $link = Link::findOrFail($link->id);
//        } else {
//            return response()->json('asdfsadf', 403);
//        }
    }

    public function update(Link $link, EditLink $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'string|max:255|min:3',
            'name' => 'string|max:255|min:2',
            'surname' => 'string|max:255|min:2',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if($link->save()) {
            return new UserResource($link);
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

    public function destroy(Link $link)
    {
        $link = Link::findOrFail($link->id);
        $link->delete();
    }

}