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
        return view('users.show', compact(['user']));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('users.edit', compact(['user', 'roles']));
    }

    public function admin()
    {
        $users = User::paginate(10);
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
        return redirect()->back()->with('status', 'User was deleted');
    }

}
