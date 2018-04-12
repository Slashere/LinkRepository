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

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'login' => $data['login'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40),
            'expired_date' => Carbon::now()->addHours(Config::get('constants.options'))
        ]);

        VerifyMail::sendAuthCode($user);

        return $user;
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
