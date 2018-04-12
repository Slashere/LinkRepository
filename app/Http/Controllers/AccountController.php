<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Users\CreateRequest;
use Illuminate\Http\Request;
use JWTAuth;
use Gate;

class AccountController extends Controller
{
    public function __construct()
    {
    }

    public function index(CreateRequest $request)
    {
        if (Gate::allows('delete-user')) {
            return 123;
        }
        return $request->email;
    }

}
