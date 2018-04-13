<?php

namespace App\Http\Controllers;

use App\Entity\Role;
use App\Http\Requests\User\EditUser;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Entity\User;
use App\Entity\Link;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\UseCases\UserService;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = $this->userservice->show($user);

        if (Auth::check()) {
            if (Auth::user()->id == $user->id) {
                $links = Link::where('user_id', '=', Auth::user()->id)->paginate(3);
            } else {
                $links = Link::where('private', '=', false)->where('user_id', '=', $user->id)->paginate(3);
            }
        } else {
            $links = Link::where('private', '=', false)->where('user_id', '=', $user->id)->paginate(3);
        }

        if (Gate::allows('list-private-links')) {
            $links = Link::where('user_id', '=', $user->id)->paginate(3);
        }

        return view('users.show', compact(['user', 'links']));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('users.edit', compact(['user', 'roles']));
    }

    public function admin()
    {
        $users = User::paginate(5);
        return view('admin.index', compact('users'));
    }

    public function update(User $user, EditUser $request)
    {
        $this->userservice->update($user, $request);
        return redirect()->route('show_user', $user)->with('success', 'User was updated');
    }

    public function destroy(User $user)
    {
        $this->userservice->delete($user);
        return redirect()->route('admin_panel')->with('delete', 'User was deleted');
    }

}
