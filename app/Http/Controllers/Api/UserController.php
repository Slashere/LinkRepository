<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\User\ApiCreateUser;
use App\Http\Requests\User\EditUser;
use App\Entity\User;
use Gate;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\UseCases\UserService;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;
use Response;

class UserController extends Controller
{
    private $userservice;
    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function show(User $user)
    {
        $user = $this->userservice->show($user);
        return response()->json(['response' => 'success', 'show' => $user]);

    }
    public function store(ApiCreateUser $request)
    {
        $createdUser = $this->userservice->create($request);
        $createdUser->status = 1;
        $createdUser->save();
        return response()->json(['response' => 'success', 'created' => $createdUser]);
    }
    public function update(User $user, EditUser $request)
    {
        $updatedUser = $this->userservice->update($user, $request);
        return response()->json(['response' => 'success', 'updated' => $updatedUser]);
    }
    public function destroy(User $user)
    {
        $token = JWTAuth::getToken();
        try {
            JWTAuth::invalidate($token);
            $this->userservice->delete($user);
            return response()->json(['response' => 'success', 'deleted' => $user]);
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException(
                Response::json(['msg' => "Your token Expired. Need to refresh Token or login again"])
            );
        }
    }
}