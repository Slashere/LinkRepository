<?php

namespace App\Http\Controllers\Auth;

use App\Entity\VerifyUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Entity\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\CreateUser;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function register(CreateUser $request)
    {
        $user = User::register($request);

        VerifyUser::createVerify($user->id);

        VerifyMail::sendAuthCode($user);

        return redirect()->route('login')
            ->with('message', 'Check your email and click on the link to verify.');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->status) {
                $verifyUser->user->status = 1;
                $verifyUser->user->save();
                $verifyUser->delete();
                Auth::login($user);
                $status = "Your e-mail is verified.";
            }else{
                $status = "Your e-mail is already verified.";
            }
        }else{
            return redirect('/login')->with('warning', "It's already expired code.");
        }

        return redirect('/login')->with('status', $status);
    }

    protected function registered(Request $request,User $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}
