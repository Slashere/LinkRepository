<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\EditUser;
use App\Entity\User;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\UseCases\UserService;
use App\Http\Controllers\Controller;
use Validator;
class UserController extends Controller
{
    private $userservice;
    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function show(User $user)
    {
        if (Gate::allows('update-user-status-and-role')) {
            return $user;
        }
        if (Auth::guard('api')->user()) {
            if (Auth::guard('api')->user()->id == $user->id) {
                return $user;
            } elseif (Auth::guard('api')->user()->isAdmin()){
                return $user->only(['id','name','surname','role_id']);
            }
        }
        return $user->only(['id','name','surname','role_id']);
    }
    public function store(CreateUser $request)
    {
        $user = $this->userservice->create($request);
        $user->status = 1;
        $user->save();
    }
    public function update(User $user, EditUser $request)
    {
        return $this->userservice->update($user, $request);
    }
    public function destroy(User $user)
    {
        $this->userservice->delete($user);
    }
}